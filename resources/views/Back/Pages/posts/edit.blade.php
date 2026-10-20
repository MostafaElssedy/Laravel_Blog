@extends('Back.Layout.pages-layout')
@section('pageTitle')
    Edit post: {{ $post->title }}
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('Back/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/add-post.css') }}" />
@endpush

@section('content')

<div class="premium-page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Edit post</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.posts.all-posts') }}">All Posts</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit post</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{ route('admin.posts.all-posts') }}" class="custom-action-btn add-btn m-0" style="padding: 10px 24px; font-size: 14px;">
                <i class="fa fa-list mr-2"></i>View all posts
            </a>
        </div>
    </div>
</div>

<form action="{{ route('admin.posts.update-post', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <!-- Main Content Card -->
            <div class="card-box pd-20 premium-card mb-30">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h4 class="premium-card-title mb-0"><i class="fa fa-pencil-square-o mr-2 text-primary"></i>Post Content</h4>
                </div>
                
                <div class="form-group">
                    <label class="custom-label" for="title">Title</label>
                    <input class="form-control premium-input @error('title') is-invalid @enderror" type="text" name="title" id="title" placeholder="Enter post title" value="{{ old('title') ?? $post->title }}">
                    @error('title')
                        <span class="text-danger ml-2 mt-1 d-block"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                
                <div class="form-group mb-0">
                    <label class="custom-label" for="content">Content</label>
                    <textarea class="form-control rich-text-editor premium-input post-content-textarea @error('content') is-invalid @enderror" name="content" id="content" rows="15" placeholder="Enter post content here..." required>{{ old('content') ?? $post->content }}</textarea>
                    @error('content')
                        <span class="text-danger ml-2 mt-1 d-block"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>

            <!-- SEO Card -->
            <div class="card-box pd-20 premium-card mb-30">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h4 class="premium-card-title mb-0 seo-card-title">
                        <i class="fa fa-search mr-2 seo-card-icon"></i>SEO Settings
                    </h4>
                </div>
                
                <div class="form-group">
                    <label class="custom-label" for="meta_keywords">Post meta keywords <small class="text-muted">(Separated by comma)</small></label>
                    <input class="form-control premium-input @error('meta_keywords') is-invalid @enderror" type="text" name="meta_keywords" id="meta_keywords" placeholder="keyword1, keyword2, keyword3" value="{{ old('meta_keywords') ?? $post->meta_keywords }}">
                    @error('meta_keywords')
                        <span class="text-danger ml-2 mt-1 d-block"><small>{{ $message }}</small></span>
                    @enderror
                </div>
                
                <div class="form-group mb-0">
                    <label class="custom-label" for="meta_description">Post meta description</label>
                    <textarea class="form-control premium-input @error('meta_description') is-invalid @enderror" name="meta_description" id="meta_description" rows="4" placeholder="Enter post meta description for search engines">{{ old('meta_description') ?? $post->meta_description }}</textarea>
                    @error('meta_description')
                        <span class="text-danger ml-2 mt-1 d-block"><small>{{ $message }}</small></span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Sidebar Settings Card -->
            <div class="card-box pd-20 premium-card mb-30">
                <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
                    <h4 class="premium-card-title mb-0"><i class="fa fa-cogs mr-2 text-primary"></i>Post Settings</h4>
                </div>
                
                <div class="form-group">
                    <label class="custom-label" for="category_id">Post category</label>
                    <select class="form-control premium-select post-category-select @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                        <option value="">Choose category...</option>
                        @foreach($parent_categories as $parent)
                            <optgroup label="{{ $parent->name }}">
                                @foreach($parent->subcategories as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id') ?? $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                        
                        @if($uncategorized->count() > 0)
                            <optgroup label="Uncategorized">
                                @foreach($uncategorized as $category)
                                    <option value="{{ $category->id }}" {{ (old('category_id') ?? $post->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </optgroup>
                        @endif
                    </select>
                    @error('category_id')
                        <span class="text-danger ml-2 mt-1 d-block"><small>{{ $message }}</small></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="custom-label" for="image">Featured image</label>
                    <div class="custom-file mb-3">
                        <input type="file" class="custom-file-input @error('image') is-invalid @enderror" name="image" id="image" accept="image/*">
                        <label class="custom-file-label post-image-label" for="image">Choose Image...</label>
                    </div>
                    <small class="text-muted d-block mb-2">Leave empty to keep the current image.</small>
                    @error('image')
                        <span class="text-danger ml-2 mt-1 mb-2 d-block"><small>{{ $message }}</small></span>
                    @enderror
                    
                    <div class="image-preview-wrapper text-center {{ $post->featured_image ? '' : 'd-none' }}" id="imagePreviewWrapper">
                        @if($post->featured_image)
                            <img id="imagePreview" src="{{ asset('images/posts/thumbnails/thumb_'.$post->featured_image) }}" alt="Image Preview" class="img-fluid" style="max-height: 200px; width: 100%; object-fit: cover; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        @else
                            <img id="imagePreview" src="" alt="Image Preview" class="img-fluid" style="max-height: 200px; width: 100%; object-fit: cover; border-radius: 12px; border: 1px solid #cbd5e1; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="custom-label" for="tags">Tags</label>
                    <input type="text" name="tags" id="tags" class="form-control" data-role="tagsinput" placeholder="Enter Tags" value="{{ old('tags') ?? $post->tags }}">
                </div>

                <div class="form-group mb-4 pb-3 border-bottom">
                    <label class="custom-label d-block">Visibility</label>
                    @php $visibility = old('visibility') ?? ($post->visibility == 1 ? 'public' : 'private'); @endphp
                    <div class="custom-control custom-radio custom-control-inline mb-2">
                        <input type="radio" id="visibilityPublic" name="visibility" class="custom-control-input" value="public" {{ $visibility == 'public' ? 'checked' : '' }}>
                        <label class="custom-control-label visibility-label" for="visibilityPublic">Public</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mb-2">
                        <input type="radio" id="visibilityPrivate" name="visibility" class="custom-control-input" value="private" {{ $visibility == 'private' ? 'checked' : '' }}>
                        <label class="custom-control-label visibility-label" for="visibilityPrivate">Private</label>
                    </div>
                </div>

                <div class="form-group mb-4 pb-3 border-bottom">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="notifySubscribers" name="notify_subscribers" value="1">
                        <label class="custom-control-label font-weight-bold text-dark" for="notifySubscribers">
                            <i class="fa fa-paper-plane text-primary mr-1"></i> Notify Newsletter Subscribers
                        </label>
                        <small class="form-text text-muted">Send an update email about this edited post to all active subscribers.</small>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-save btn-block mt-4" style="font-size: 16px; padding: 12px 28px;">
                    <i class="fa fa-save mr-2"></i>Update Post
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script src="{{ asset('Back/src/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
<script>
    //handle choose image and show preview
    $('#image').on('change', function() {
        var file = $(this).get(0).files[0];
        if (file) {
            // Update the label with the file name
            $(this).next('.custom-file-label').html(file.name);
            
            var reader = new FileReader();
            reader.onload = function() {
                $('#imagePreview').attr('src', reader.result);
                $('#imagePreviewWrapper').removeClass('d-none'); // Show the preview wrapper
            }
            reader.readAsDataURL(file);
        } else {
            // Reset if no file is selected
            $(this).next('.custom-file-label').html('Choose Image...');
            @if(!$post->featured_image)
            $('#imagePreviewWrapper').addClass('d-none'); // Hide the preview wrapper
            $('#imagePreview').attr('src', '');
            @else
            $('#imagePreview').attr('src', '{{ asset('images/posts/thumbnails/thumb_'.$post->featured_image) }}');
            @endif
        }
    });
</script>
@endpush

@push('scripts')
@if(Session::has('success'))
<script>
    if(typeof ijabo !== 'undefined') {
        ijabo.showToast('{{ Session::get('success') }}', 'success');
    } else if (typeof toastr !== 'undefined') {
        toastr.success('{{ Session::get('success') }}');
    } else {
        alert('{{ Session::get('success') }}');
    }
</script>
@endif

@if(Session::has('error'))
<script>
    if(typeof ijabo !== 'undefined') {
        ijabo.showToast('{{ Session::get('error') }}', 'error');
    } else if (typeof toastr !== 'undefined') {
        toastr.error('{{ Session::get('error') }}');
    } else {
        alert('{{ Session::get('error') }}');
    }
</script>
@endif
@endpush
