<?php

namespace App\Jobs;

use App\Helpers\CMail;
use App\Models\GeneralSetting;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SendPostNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 3;

    /**
     * The number of seconds to wait before retrying the job.
     */
    public int $backoff = 10;

    public Post $post;
    public bool $isUpdate;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post, bool $isUpdate = false)
    {
        $this->post = $post;
        $this->isUpdate = $isUpdate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->post->refresh();

        // Only notify about public posts
        if ((int)$this->post->visibility !== 1) {
            return;
        }

        $subscribers = Subscriber::where('status', true)->get();

        if ($subscribers->isEmpty()) {
            return;
        }

        $blogSettings = GeneralSetting::getSettings();
        $blogName = optional($blogSettings)->blog_name ?? 'LaraBlog';
        $actionLink = route('post.show', $this->post->slug);

        // Check if image exists locally for embedded CID attachment
        $imagePath = !empty($this->post->featured_image) ? public_path('images/posts/' . $this->post->featured_image) : null;
        $hasEmbeddedImage = ($imagePath && file_exists($imagePath));

        $embeddedImages = [];
        if ($hasEmbeddedImage) {
            $embeddedImages[] = [
                'path' => $imagePath,
                'cid'  => 'post_featured_image',
                'name' => $this->post->featured_image,
            ];
        }

        // Clean content with proper spacing between block tags before stripping
        $cleanContent = preg_replace('/<[^>]+>/', ' ', $this->post->content ?? '');
        $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
        $excerpt = Str::limit(trim($cleanContent), 180, '...');

        // Render the email body once for all recipients
        $body = view('email-templates.new-post-notification', [
            'post'             => $this->post,
            'actionLink'       => $actionLink,
            'isUpdate'         => $this->isUpdate,
            'hasEmbeddedImage' => $hasEmbeddedImage,
            'excerpt'          => $excerpt,
        ])->render();

        $prefix = $this->isUpdate ? 'Updated Article: ' : 'New Article: ';
        $subject = $prefix . $this->post->title . ' — ' . $blogName;

        foreach ($subscribers as $index => $subscriber) {
            if ($index > 0) {
                // Pause to prevent SMTP rate limits (e.g. Mailtrap)
                sleep(3);
            }

            try {
                CMail::send([
                    'recipient_address' => $subscriber->email,
                    'recipient_name'    => null,
                    'subject'           => $subject,
                    'body'              => $body,
                    'embedded_images'   => $embeddedImages,
                ]);
            } catch (\Throwable $e) {
                Log::warning("Failed to send post notification to {$subscriber->email}: " . $e->getMessage());
            }
        }
    }
}
