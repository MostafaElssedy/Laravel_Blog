<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ContactRequest;

use App\Models\Post;
use App\Models\Category;

use App\Models\User;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        // Fetch posts once to avoid duplicate queries for relationships
        $posts = Post::with(['author', 'category'])
                     ->orderBy('created_at', 'desc')
                     ->take(11)
                     ->get();
                     
        $featuredPosts = $posts->take(5);
        $latestPosts = $posts->slice(0, 6); // Change 0 to 5 if you want to skip the featured posts
        $sidebarCategories = Category::withCount('posts')
                                     ->orderBy('posts_count', 'desc')
                                     ->take(6)
                                     ->get();

        $sidebarTags = Post::whereNotNull('tags')
                           ->where('tags', '!=', '')
                           ->pluck('tags')
                           ->flatMap(function ($tagsStr) {
                               return explode(',', $tagsStr);
                           })
                           ->map(function ($tag) {
                               return trim($tag);
                           })
                           ->filter()
                           ->unique()
                           ->sort()
                           ->values();

        return view('Front.pages.index', compact('featuredPosts', 'latestPosts', 'sidebarCategories', 'sidebarTags'));
    }

    public function show($slug)
    {
        $post = Post::with(['author', 'category'])->where('slug', $slug)->firstOrFail();

        // Get previous and next posts based on ID
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        // Get related posts from the same category
        $relatedPosts = Post::where('category_id', $post->category_id)
                            ->where('id', '!=', $post->id)
                            ->inRandomOrder()
                            ->take(3)
                            ->get();

        // Assign already loaded relations to prevent duplicate queries
        $relatedPosts->each(function ($relatedPost) use ($post) {
            $relatedPost->setRelation('category', $post->category);
            
            if ($relatedPost->author_id === $post->author_id) {
                $relatedPost->setRelation('author', $post->author);
            }
        });

        // Load any remaining authors that were not the same as the main post
        $relatedPosts->loadMissing('author');

        return view('Front.pages.single_post', compact('post', 'previousPost', 'nextPost', 'relatedPosts'));
    }

    public function categoryPosts($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::with(['category', 'author'])->where('category_id', $category->id)->orderBy('created_at', 'desc')->paginate(6);
        return view('Front.pages.category_posts', compact('category', 'posts'));
    }

    public function authorPosts($username)
    {
        $author = User::where('username', $username)->firstOrFail();
        $posts = Post::with(['category'])->where('author_id', $author->id)->orderBy('created_at', 'desc')->paginate(12);
        return view('Front.pages.author_posts', compact('author', 'posts'));
    }

    public function authors()
    {
        // Get users who have published posts, ordered by post count
        $authors = User::with('socialLinks')
                       ->withCount('posts')
                       ->having('posts_count', '>', 0)
                       ->orderBy('posts_count', 'desc')
                       ->paginate(12);
                       
        return view('Front.pages.authors', compact('authors'));
    }

    public function tagPosts($any)
    {
        $posts = Post::with(['category', 'author'])->where('tags', 'like', "%{$any}%")->orderBy('created_at', 'desc')->paginate(6);
        return view('Front.pages.tag_posts', ['tag' => $any, 'posts' => $posts]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');
        $posts = Post::where('title', 'like', "%{$query}%")
                     ->orWhere('content', 'like', "%{$query}%")
                     ->orderBy('created_at', 'desc')
                     ->paginate(10);
                     
        return view('Front.pages.search', compact('posts', 'query'));
    }
    public function searchJson(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $posts = Post::with('category')
                     ->where('title', 'like', "%{$query}%")
                     ->orWhere('content', 'like', "%{$query}%")
                     ->orderBy('created_at', 'desc')
                     ->take(6)
                     ->get();

        $results = $posts->map(function ($post) {
            return [
                'title' => $post->title,
                'excerpt' => \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 100),
                'category' => optional($post->category)->name ?? 'Uncategorized',
                'url' => route('post.show', $post->slug),
                'image' => $post->featured_image ? asset('images/posts/' . $post->featured_image) : null,
                'author' => optional($post->author)->name ?? 'Admin',
                'readTime' => '5 min',
            ];
        });

        return response()->json($results);
    }

    public function trendingTopics()
    {
        // Get popular categories
        $categories = Category::withCount('posts')
                              ->orderBy('posts_count', 'desc')
                              ->take(8)
                              ->pluck('name');
        
        return response()->json($categories);
    }

    public function contact()
    {
        return view('Front.pages.contact');
    }

    public function contactProcess(ContactRequest $request)
    {
        $config = [
            'recipient_address' => env('MAIL_FROM_ADDRESS', 'support@sawa.com'),
            'recipient_name'    => 'Sawa Support',
            'subject'           => 'New Contact Message: ' . $request->subject,
            'body'              => view('email-templates.contact-message', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'messageContent' => $request->message
            ])->render()
        ];

        if (\App\Helpers\CMail::send($config)) {
            return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
        } else {
            return back()->with('error', 'Something went wrong while sending your message. Please try again later.')->withInput();
        }
    }

    public function articles(Request $request)
    {
        $posts = Post::with(['category', 'author'])
                     ->where('visibility', 1)
                     ->orderBy('created_at', 'desc')
                     ->paginate(9);

        return view('Front.pages.articles', compact('posts'));
    }

    public function categories()
    {
        $parentCategories = \App\Models\ParentCategory::with(['subcategories' => function($q) {
            $q->withCount('posts');
        }])->orderBy('ordering', 'asc')->get();

        $allCategories = Category::withCount('posts')
                                 ->orderBy('posts_count', 'desc')
                                 ->get();

        return view('Front.pages.categories', compact('parentCategories', 'allCategories'));
    }

    public function about()
    {
        $totalArticles = Post::where('visibility', 1)->count();
        $totalAuthors = User::whereHas('posts')->count();
        $totalCategories = Category::count();

        return view('Front.pages.about', compact('totalArticles', 'totalAuthors', 'totalCategories'));
    }

    public function privacy()
    {
        return view('Front.pages.privacy');
    }

    public function terms()
    {
        return view('Front.pages.terms');
    }

    public function cookies()
    {
        return view('Front.pages.cookies');
    }
}
