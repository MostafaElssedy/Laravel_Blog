<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    public function dashboard(Request $request){
        $totalPosts         = \App\Models\Post::count();
        $publishedPosts     = \App\Models\Post::where('visibility', 1)->count();
        $privatePosts       = \App\Models\Post::where('visibility', 0)->count();
        $totalCategories    = \App\Models\Category::count();
        $totalUsers         = \App\Models\User::count();
        $totalSubscribers   = \App\Models\Subscriber::count();
        $activeSubscribers  = \App\Models\Subscriber::where('status', 1)->count();

        $recentPosts        = \App\Models\Post::with(['category', 'author'])->latest()->take(12)->get();
        $recentUsers        = \App\Models\User::latest()->take(5)->get();
        $recentSubscribers  = \App\Models\Subscriber::latest()->take(10)->get();

        $topCategories      = \App\Models\Category::withCount('posts')
                                                 ->orderBy('posts_count', 'desc')
                                                 ->take(10)
                                                 ->get();

        $blogName = optional(\App\Models\GeneralSetting::getSettings())->blog_name ?? 'Blog';

        $data = [
            'pageTitle'         => 'Dashboard',
            'totalPosts'        => $totalPosts,
            'publishedPosts'    => $publishedPosts,
            'privatePosts'      => $privatePosts,
            'totalCategories'   => $totalCategories,
            'totalUsers'        => $totalUsers,
            'totalSubscribers'  => $totalSubscribers,
            'activeSubscribers' => $activeSubscribers,
            'recentPosts'       => $recentPosts,
            'recentUsers'       => $recentUsers,
            'recentSubscribers' => $recentSubscribers,
            'topCategories'     => $topCategories,
            'blogName'          => $blogName,
        ];
        return view('Back.Pages.dashboard', $data);
    }   

    public function profile(Request $request){
        $data = [
            'pageTitle' => 'Profile'
        ];
        return view('Back.Pages.admin.profile', $data);
    }

    public function settings(Request $request){
        $data = [
            'pageTitle' => 'General Settings'
        ];
        return view('Back.Pages.admin.settings', $data);
    }

    public function updateProfilePicture(Request $request){
        $path = 'images/users/';
        $file = $request->file('profile_picture');
        $new_image_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';

        if($file){
            $upload = $file->move(public_path($path), $new_image_name);
            if($upload){
                $user = Auth::user();
                $old_picture = $user->profile_image;
                
                // Only delete the old picture if it exists AND no other user is currently using it
                if($old_picture != null && \Illuminate\Support\Facades\File::exists(public_path($path.$old_picture))){
                    $users_using_image = \App\Models\User::where('profile_image', $old_picture)->count();
                    if ($users_using_image <= 1) {
                        \Illuminate\Support\Facades\File::delete(public_path($path.$old_picture));
                    }
                }
                
                $user->profile_image = $new_image_name;
                $user->save();

                return response()->json(['status'=>1, 'msg'=>'Your profile picture has been updated successfully.']);
            }else{
                return response()->json(['status'=>0, 'msg'=>'Something went wrong.']);
            }
        }
        return response()->json(['status'=>0, 'msg'=>'No file was uploaded.']);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('info', 'You have been logged out.');
    }

    public function categories(Request $request){
        $data = [
            'pageTitle' => 'Categories'
        ];
        return view('Back.Pages.categories.categories', $data);
    }

    public function users(Request $request){
        $data = [
            'pageTitle' => 'Users & Authors'
        ];
        return view('Back.Pages.admin.users', $data);
    }
}
