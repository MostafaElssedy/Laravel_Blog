<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;
use Illuminate\Support\Facades\File;

use Livewire\Attributes\Url;

class AdminPosts extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $perPage = 6;
    
    #[Url]
    public $author = null;
    
    #[Url]
    public $category = null;
    
    #[Url]
    public $visibility = null;
    
    #[Url]
    public $sortBy = 'desc';
    
    public $selectedPost = null;
    public $postToDelete = null;
    
    protected $paginationTheme = 'bootstrap';

    // Reset pagination when searching or filtering
    public function updatingSearch() { $this->resetPage(); }
    public function updatingAuthor() { $this->resetPage(); }
    public function updatingCategory() { $this->resetPage(); }
    public function updatingVisibility() { $this->resetPage(); }
    public function updatingSortBy() { $this->resetPage(); }

    public function showPost($id)
    {
        $this->selectedPost = Post::with(['category', 'author'])->find($id);
        $this->dispatch('showPostModal');
    }

    public function confirmDelete($id)
    {
        $this->postToDelete = $id;
        $this->dispatch('showDeleteModal');
    }

    public function deletePost()
    {
        if ($this->postToDelete) {
            $post = Post::findOrFail($this->postToDelete);
            
            $isPrivileged = auth()->user()->type->value === 'superAdmin';
            if (! $isPrivileged && $post->author_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            // Delete the associated images
        $path = public_path('images/posts/');
        $thumb_path = public_path('images/posts/thumbnails/');
        
        if ($post->featured_image && File::exists($path . $post->featured_image)) {
            File::delete($path . $post->featured_image);
        }
        if ($post->featured_image && File::exists($thumb_path . 'thumb_' . $post->featured_image)) {
            File::delete($thumb_path . 'thumb_' . $post->featured_image);
        }

        $post->delete();
        $this->postToDelete = null;

        $this->dispatch('hideDeleteModal');
        // Dispatch browser event to show toastr
        $this->dispatch('showToast', ['message' => 'Post has been deleted successfully!', 'type' => 'success']);
        }
    }

    public function render()
    {
        $query = Post::with(['category', 'author']);

        if ($this->sortBy === 'asc') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // Check if user is superAdmin
        $isPrivileged = auth()->user()->type->value === 'superAdmin';

        // If not privileged, only show their own posts
        if (! $isPrivileged) {
            $query->where('author_id', auth()->id());
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhereHas('category', function($q) {
                      $q->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->author) {
            $query->where('author_id', $this->author);
        }

        if ($this->category) {
            $query->where('category_id', $this->category);
        }

        if ($this->visibility !== null && $this->visibility !== '') {
            $query->where('visibility', $this->visibility);
        }

        $posts = $query->paginate($this->perPage);

        $parent_categories = \App\Models\ParentCategory::with('subcategories')->orderBy('ordering', 'asc')->get();
        $uncategorized = \App\Models\Category::where('parent', 0)->orWhereNull('parent')->get();
        $authors = \App\Models\User::whereHas('posts')->orWhereIn('type', ['admin', 'superAdmin'])->get();

        return view('livewire.admin-posts', [
            'posts' => $posts,
            'parent_categories' => $parent_categories,
            'uncategorized' => $uncategorized,
            'authors' => $authors,
            'isPrivileged' => $isPrivileged
        ]);
    }
}
