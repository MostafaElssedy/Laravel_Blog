<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class SeedRealPosts extends Command
{
    protected $signature = 'app:seed-posts';
    protected $description = 'Seed 200 real posts with images';

    public function handle()
    {
        $faker = Faker::create();
        $manager = new ImageManager(new Driver());
        
        $path = public_path('images/posts/');
        $thumb_path = public_path('images/posts/thumbnails/');
        
        if (!file_exists($path)) mkdir($path, 0755, true);
        if (!file_exists($thumb_path)) mkdir($thumb_path, 0755, true);

        // Get categories and a user
        $categories = Category::pluck('id')->toArray();
        $user = User::first();
        if(!$user) {
            $this->error('No users found in database to assign posts to!');
            return;
        }
        
        if(empty($categories)) {
            $this->error('No categories found! Please create a category first.');
            return;
        }

        $this->info('Starting to generate 200 posts. This might take a few minutes...');
        $bar = $this->output->createProgressBar(200);
        $bar->start();

        for ($i = 0; $i < 200; $i++) {
            // Fetch random image
            $imageContent = @file_get_contents('https://picsum.photos/1200/800');
            if(!$imageContent) {
                // Fallback dummy image if picsum fails
                $imageContent = @file_get_contents('https://via.placeholder.com/1200x800.png?text=Placeholder');
            }

            $filename = 'POST_' . date('Ymd') . uniqid() . '.jpg';

            try {
                // Save main image
                $image = $manager->read($imageContent);
                $image->scaleDown(width: 1200);
                $image->save($path . $filename);

                // Save thumbnail
                $thumbnail = $manager->read($imageContent);
                $thumbnail->cover(300, 200);
                $thumbnail->save($thumb_path . 'thumb_' . $filename);
            } catch (\Exception $e) {
                $this->error("Failed to process image for post $i: " . $e->getMessage());
                continue;
            }

            $title = $faker->sentence(6);
            
            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "<p>" . implode("</p><p>", $faker->paragraphs(6)) . "</p>",
                'featured_image' => $filename,
                'meta_description' => $faker->text(150),
                'meta_keywords' => implode(',', $faker->words(5)),
                'tags' => implode(',', $faker->words(3)),
                'category_id' => $faker->randomElement($categories),
                'author_id' => $user->id,
                'visibility' => 1
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully seeded 200 posts with images!');
    }
}
