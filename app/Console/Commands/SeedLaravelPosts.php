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

class SeedLaravelPosts extends Command
{
    protected $signature = 'app:seed-laravel';
    protected $description = 'Seed 20 real posts specifically about Laravel';

    public function handle()
    {
        $faker = Faker::create();
        $manager = new ImageManager(new Driver());
        
        $path = public_path('images/posts/');
        $thumb_path = public_path('images/posts/thumbnails/');
        
        if (!file_exists($path)) mkdir($path, 0755, true);
        if (!file_exists($thumb_path)) mkdir($thumb_path, 0755, true);

        // Find or create Laravel category
        $category = Category::firstOrCreate(
            ['slug' => 'laravel'],
            ['name' => 'Laravel', 'description' => 'Everything about the Laravel PHP Framework', 'status' => 1]
        );

        $user = User::first();
        if(!$user) {
            $this->error('No users found in database to assign posts to!');
            return;
        }

        $laravelTitles = [
            'Mastering Eloquent ORM in Laravel 11',
            'How to Build RESTful APIs with Laravel Sanctum',
            'Understanding Dependency Injection in Laravel',
            'Top 10 Laravel Packages You Must Use in 2026',
            'A Deep Dive into Laravel Livewire 3',
            'Optimizing Database Queries in Laravel',
            'Building Real-Time Apps with Laravel Reverb',
            'Laravel Breeze vs Jetstream: Which to Choose?',
            'How to Write Custom Artisan Commands',
            'Understanding Laravel Middleware and Routing',
            'Handling File Uploads Securely in Laravel',
            'Testing Laravel Applications with Pest',
            'Deploying Laravel Apps to AWS using Vapor',
            'Creating Beautiful UIs with Laravel and Tailwind CSS',
            'Understanding Service Providers in Laravel',
            'How to Use Laravel Jobs and Queues Efficiently',
            'Implementing Two-Factor Authentication in Laravel',
            'Laravel Task Scheduling Explained',
            'Advanced Model Factories and Seeding in Laravel',
            'Securing Your Laravel Application from Top Vulnerabilities'
        ];

        $this->info('Starting to generate 20 Laravel posts. This might take a few minutes...');
        $bar = $this->output->createProgressBar(20);
        $bar->start();

        foreach ($laravelTitles as $index => $title) {
            // Fetch random tech-related image from Unsplash Source (via picsum as fallback)
            $imageContent = @file_get_contents('https://picsum.photos/1200/800?random=' . ($index + 100));
            if(!$imageContent) {
                $imageContent = @file_get_contents('https://via.placeholder.com/1200x800.png?text=Laravel');
            }

            $filename = 'LARAVEL_' . date('Ymd') . uniqid() . '.jpg';

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
                $this->error("Failed to process image for post: " . $e->getMessage());
                continue;
            }

            Post::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => "<h2>Introduction</h2><p>" . $faker->paragraph(4) . "</p><h2>Core Concepts</h2><p>" . implode("</p><p>", $faker->paragraphs(4)) . "</p><h2>Conclusion</h2><p>Laravel makes PHP development a breeze. " . $faker->paragraph(2) . "</p>",
                'featured_image' => $filename,
                'meta_description' => $faker->text(150),
                'meta_keywords' => 'laravel, php, web development, ' . implode(',', $faker->words(2)),
                'tags' => 'Laravel,PHP,WebDev',
                'category_id' => $category->id,
                'author_id' => $user->id,
                'visibility' => 1,
                'created_at' => now()->subDays(rand(0, 30)) // Randomize dates
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Successfully seeded 20 Laravel posts!');
    }
}
