@extends('Back.Layout.pages-layout')
@section('pageTitle')
    All Posts
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/add-post.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/all-posts.css') }}" />
@endpush

@section('content')
<div class="premium-page-header mb-4">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>All Posts</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">All Posts</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{ route('admin.posts.add-post') }}" class="custom-action-btn add-btn m-0" style="padding: 10px 24px; font-size: 14px;">
                <i class="fa fa-plus mr-2"></i>Create New Post
            </a>
        </div>
    </div>
</div>

<div class="card-box pd-20 premium-card mb-30">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
        <h4 class="premium-card-title mb-0"><i class="fa fa-newspaper-o mr-2 text-primary"></i>Manage Posts</h4>
    </div>
    
    @livewire('admin-posts')
</div>
@endsection

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

<script>
    window.addEventListener('showToast', function(event) {
        let data = event.detail;
        if(Array.isArray(data)){
            data = data[0];
        }
        if(typeof ijabo !== 'undefined') {
            ijabo.showToast(data.message, data.type);
        } else if (typeof toastr !== 'undefined') {
            toastr[data.type](data.message);
        } else {
            alert(data.message);
        }
    });
</script>
@endpush
