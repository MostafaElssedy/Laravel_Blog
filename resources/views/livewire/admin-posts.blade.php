<div>
    <style>
        /* Smooth scale animation for all modals in this component */
        .modal.fade .modal-dialog {
            transform: scale(0.85);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) !important;
        }
        .modal.show .modal-dialog {
            transform: scale(1);
            opacity: 1;
        }
    </style>
    
    <!-- Advanced Filters Bar -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-12 mb-3">
            <label style="font-weight: 600; font-size: 13px; color: #475569;">Search:</label>
            <input type="text" wire:model.live="search" class="form-control premium-input" placeholder="Search posts..." style="border-radius: 8px;">
        </div>
        
        @if($isPrivileged)
        <div class="col-md-2 col-sm-6 mb-3">
            <label style="font-weight: 600; font-size: 13px; color: #475569;">Author:</label>
            <select wire:model.live="author" class="form-control premium-select" style="border-radius: 8px;">
                <option value="">No selected</option>
                @foreach($authors as $auth)
                    <option value="{{ $auth->id }}">{{ $auth->name }}</option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="col-md-{{ $isPrivileged ? '3' : '4' }} col-sm-6 mb-3">
            <label style="font-weight: 600; font-size: 13px; color: #475569;">Category:</label>
            <select wire:model.live="category" class="form-control premium-select" style="border-radius: 8px;">
                <option value="">No selected</option>
                @foreach($parent_categories as $parent)
                    <optgroup label="{{ $parent->name }}">
                        @foreach($parent->subcategories as $subcat)
                            <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                        @endforeach
                    </optgroup>
                @endforeach
                @if($uncategorized->count() > 0)
                    <optgroup label="Uncategorized">
                        @foreach($uncategorized as $un)
                            <option value="{{ $un->id }}">{{ $un->name }}</option>
                        @endforeach
                    </optgroup>
                @endif
            </select>
        </div>

        <div class="col-md-2 col-sm-6 mb-3">
            <label style="font-weight: 600; font-size: 13px; color: #475569;">Visibility:</label>
            <select wire:model.live="visibility" class="form-control premium-select" style="border-radius: 8px;">
                <option value="">No selected</option>
                <option value="1">Public</option>
                <option value="0">Private</option>
            </select>
        </div>

        <div class="col-md-2 col-sm-6 mb-3">
            <label style="font-weight: 600; font-size: 13px; color: #475569;">Sort By:</label>
            <select wire:model.live="sortBy" class="form-control premium-select" style="border-radius: 8px;">
                <option value="desc">DESC</option>
                <option value="asc">ASC</option>
            </select>
        </div>
    </div>

    <div class="row">
        @forelse($posts as $post)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-30">
                <div class="post-card">
                    <div class="post-card-img-wrap" wire:click="showPost({{ $post->id }})" style="cursor: pointer;">
                        @if($post->featured_image && file_exists(public_path('images/posts/thumbnails/thumb_'.$post->featured_image)))
                            <img src="{{ asset('images/posts/thumbnails/thumb_'.$post->featured_image) }}" alt="{{ $post->title }}" class="post-card-img">
                        @elseif($post->featured_image && file_exists(public_path('images/posts/'.$post->featured_image)))
                            <img src="{{ asset('images/posts/'.$post->featured_image) }}" alt="{{ $post->title }}" class="post-card-img">
                        @else
                            <img src="https://via.placeholder.com/600x400?text=No+Image" alt="No Image" class="post-card-img">
                        @endif
                        
                    </div>
                    
                    <div class="post-card-body">
                        <h3 class="post-card-title" wire:click="showPost({{ $post->id }})" style="cursor: pointer;" title="Click to view post">{{ $post->title }}</h3>
                        <div class="post-card-meta mt-3" style="display: grid; grid-template-columns: 80px 1fr; row-gap: 10px; font-size: 13px; text-align: left; align-items: center;">
                            <div class="text-muted" style="font-weight: 600;">Date:</div>
                            <div><i class="fa fa-calendar mr-1 text-muted"></i> {{ $post->created_at->format('M d, Y') }}</div>
                            
                            <div class="text-muted" style="font-weight: 600;">Author:</div>
                            <div><i class="fa fa-user mr-1 text-muted"></i> {{ $post->author->name ?? 'Admin' }}</div>
                            
                            <div class="text-muted" style="font-weight: 600;">Category:</div>
                            <div>
                                @if($post->category)
                                    <span class="badge badge-primary" style="padding: 4px 8px; font-size: 11px; border-radius: 4px; background: #0000ff; color: white;">{{ $post->category->name }}</span>
                                @else
                                    <span class="badge badge-secondary" style="padding: 4px 8px; font-size: 11px; border-radius: 4px;">Uncategorized</span>
                                @endif
                            </div>

                            <div class="text-muted" style="font-weight: 600;">Visibility:</div>
                            <div>
                                @if($post->visibility == 1)
                                    <span class="badge badge-success" style="padding: 4px 8px; font-size: 11px; border-radius: 4px; background: #28a745; color: white;"><i class="fa fa-globe mr-1"></i> Public</span>
                                @else
                                    <span class="badge badge-danger" style="padding: 4px 8px; font-size: 11px; border-radius: 4px; background: #dc3545; color: white;"><i class="fa fa-lock mr-1"></i> Private</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="post-card-actions">
                            <a href="{{ route('admin.posts.edit-post', $post->id) }}" class="action-btn action-edit">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            
                            <button type="button" class="action-btn action-delete" wire:click.stop="confirmDelete({{ $post->id }})">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <i class="fa fa-folder-open-o"></i>
                    <h5>No posts found</h5>
                    @if($search)
                        <p class="text-muted mt-2">No posts matched your search for "{{ $search }}".</p>
                    @else
                        <p class="text-muted mt-2">You haven't created any posts yet. Start by creating your first post!</p>
                        <a href="{{ route('admin.posts.add-post') }}" class="btn btn-primary mt-3">Create First Post</a>
                    @endif
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        <div class="d-flex align-items-center">
            <span class="mr-2 text-muted" style="font-weight: 500; font-size: 14px;">Show:</span>
            <select name="perPage" id="perPage" wire:model.live="perPage" class="form-control premium-select" style="width: 75px; height: 35px; padding: 4px 10px; cursor: pointer;">
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="18">18</option>
                <option value="24">24</option>
            </select>
        </div>
        <div>
            {{ $posts->links(data: ['scrollTo' => false]) }}
        </div>
    </div>

    <!-- View Post Modal -->
    <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden; box-shadow: 0 10px 40px rgba(0,0,0,0.1);">
                @if($selectedPost)
                    <div class="modal-header border-0 pb-0 pt-4 px-4">
                        <h4 class="modal-title font-weight-bold" style="color: #1e293b; line-height: 1.4;">{{ $selectedPost->title }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="d-flex flex-wrap align-items-center mb-4 text-muted" style="font-size: 14px; gap: 15px;">
                            <span><i class="fa fa-calendar mr-1"></i> {{ $selectedPost->created_at->format('M d, Y') }}</span>
                            <span><i class="fa fa-user mr-1"></i> {{ $selectedPost->author->name ?? 'Admin' }}</span>
                            <span class="badge badge-primary px-3 py-1" style="border-radius: 8px;">{{ $selectedPost->category->name ?? 'Uncategorized' }}</span>
                            
                            @if($selectedPost->visibility == 1)
                                <span class="badge badge-success px-3 py-1" style="border-radius: 8px;"><i class="fa fa-globe mr-1"></i> Public</span>
                            @else
                                <span class="badge badge-secondary px-3 py-1" style="border-radius: 8px;"><i class="fa fa-lock mr-1"></i> Private</span>
                            @endif
                        </div>

                        @if($selectedPost->featured_image && file_exists(public_path('images/posts/'.$selectedPost->featured_image)))
                            <div class="text-center mb-4">
                                <img src="{{ asset('images/posts/'.$selectedPost->featured_image) }}" alt="Featured Image" class="img-fluid" style="max-height: 450px; object-fit: cover; width: 100%; border-radius: 12px; border: 1px solid #e2e8f0;">
                            </div>
                        @endif

                        <div class="post-content-preview mb-4" style="color: #334155; line-height: 1.8; font-size: 16px;">
                            {!! $selectedPost->content !!}
                        </div>

                        @if($selectedPost->post_tags)
                            <div class="mb-4">
                                <h6 class="font-weight-bold" style="color: #1e293b;"><i class="fa fa-tags mr-2 text-primary"></i>Tags:</h6>
                                <div class="d-flex flex-wrap" style="gap: 8px;">
                                    @foreach(explode(',', $selectedPost->post_tags) as $tag)
                                        <span class="badge bg-light text-primary border px-2 py-1" style="border-radius: 6px; font-size: 13px;">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($selectedPost->meta_title || $selectedPost->meta_description)
                            <div class="seo-preview bg-light p-3" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                                <h6 class="font-weight-bold mb-3" style="color: #1e293b;"><i class="fa fa-search mr-2 text-primary"></i>SEO Details</h6>
                                
                                @if($selectedPost->meta_title)
                                    <div class="mb-2">
                                        <strong style="color: #475569; font-size: 14px;">Meta Title:</strong>
                                        <div style="font-size: 15px; color: #1e293b;">{{ $selectedPost->meta_title }}</div>
                                    </div>
                                @endif
                                
                                @if($selectedPost->meta_description)
                                    <div>
                                        <strong style="color: #475569; font-size: 14px;">Meta Description:</strong>
                                        <div style="font-size: 14px; color: #64748b;">{{ $selectedPost->meta_description }}</div>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer border-0 pt-0 pb-4 px-4 bg-light" style="border-top: 1px solid #f1f5f9 !important; padding-top: 20px !important;">
                        <button type="button" class="btn btn-secondary rounded-pill px-4 font-weight-bold" data-dismiss="modal">Close</button>
                        <a href="{{ route('admin.posts.edit-post', $selectedPost->id) }}" class="btn btn-primary rounded-pill px-4 font-weight-bold shadow-sm">
                            <i class="fa fa-edit mr-1"></i> Edit Post
                        </a>
                    </div>
                @else
                    <div class="modal-body text-center p-5">
                        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <p class="mt-3 text-muted">Loading post details...</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content text-center" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); padding: 30px;">
                <div class="modal-body">
                    <div class="mb-4">
                        <div style="width: 80px; height: 80px; background-color: #fee2e2; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                            <i class="fa fa-trash text-danger" style="font-size: 36px;"></i>
                        </div>
                    </div>
                    <h4 class="font-weight-bold mb-3" style="color: #1e293b;">Are you sure?</h4>
                    <p class="text-muted mb-4" style="font-size: 16px;">Do you really want to delete this post? This process cannot be undone.</p>
                    
                    <div class="d-flex justify-content-center" style="gap: 15px;">
                        <button type="button" class="btn btn-light rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger rounded-pill px-4 font-weight-bold shadow-sm" wire:click="deletePost">
                            <span wire:loading.remove wire:target="deletePost">Yes, Delete it!</span>
                            <span wire:loading wire:target="deletePost" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span wire:loading wire:target="deletePost" class="ml-1">Deleting...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            window.addEventListener('showPostModal', event => {
                $('#postModal').modal('show');
            });

            window.addEventListener('showDeleteModal', event => {
                $('#deleteModal').modal('show');
            });

            window.addEventListener('hideDeleteModal', event => {
                $('#deleteModal').modal('hide');
            });
        });
    </script>
</div>
