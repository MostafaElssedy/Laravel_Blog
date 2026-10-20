<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \App\Models\ParentCategory::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        $realData = [
            'Technology' => ['Web Development', 'Mobile Apps', 'Cybersecurity', 'Artificial Intelligence', 'Gadgets & Reviews'],
            'Lifestyle' => ['Travel', 'Fashion', 'Food & Drink', 'Home Decor', 'Personal Finance'],
            'Health & Wellness' => ['Mental Health', 'Fitness & Exercise', 'Nutrition', 'Yoga & Meditation', 'Alternative Medicine'],
            'Business' => ['Entrepreneurship', 'Investing', 'Marketing Strategy', 'E-commerce', 'Management'],
            'Arts & Entertainment' => ['Movies & TV', 'Music', 'Books & Literature', 'Photography', 'Fine Arts'],
            'Sports' => ['Football', 'Basketball', 'Tennis', 'E-Sports', 'Extreme Sports'],
            'Education' => ['Online Learning', 'College Tips', 'Language Learning', 'Science Basics', 'World History'],
            'Programming' => ['Python', 'JavaScript', 'PHP', 'C++', 'Java Development'],
            'Software Engineering' => ['System Design', 'DevOps & Cloud', 'Software Testing', 'Agile Methodologies', 'Databases'],
            'Digital Marketing' => ['SEO & SEM', 'Social Media', 'Content Marketing', 'Email Campaigns', 'Paid Advertising'],
            'Personal Development' => ['Productivity', 'Motivation', 'Leadership', 'Communication Skills', 'Time Management'],
            'Photography & Video' => ['Portrait Photography', 'Landscape', 'Video Editing', 'Drone Videography', 'Lighting Techniques'],
            'Food & Recipes' => ['Vegan Recipes', 'Baking & Pastries', 'Quick Meals', 'Healthy Eating', 'Desserts'],
            'Home & Garden' => ['DIY Projects', 'Interior Design', 'Gardening Tips', 'Smart Home Tech', 'Home Organization'],
            'Automotive' => ['Car Reviews', 'Vehicle Maintenance', 'Electric Vehicles', 'Motorcycles', 'Motorsports'],
            'Science' => ['Space Exploration', 'Biotech', 'Physics', 'Robotics', 'Environmental Science'],
            'Pets & Animals' => ['Dog Training', 'Cat Care', 'Aquariums', 'Exotic Pets', 'Animal Rescue'],
            'Gaming' => ['PC Gaming', 'Console Games', 'Board Games', 'Game Development', 'VR Gaming'],
            'Real Estate' => ['Buying a Home', 'Real Estate Investing', 'Architecture', 'Commercial Property', 'Mortgages'],
            'Parenting' => ['Pregnancy', 'Toddlers', 'Teenagers', 'Education & School', 'Family Activities'],
        ];

        $p_order = 1;
        $c_order = 1;

        foreach ($realData as $parentName => $children) {
            $parent = \App\Models\ParentCategory::create([
                'name' => $parentName,
                'ordering' => $p_order++
            ]);

            foreach ($children as $childName) {
                \App\Models\Category::create([
                    'name' => $childName,
                    'parent' => $parent->id,
                    'ordering' => $c_order++
                ]);
            }
        }
    }
}
