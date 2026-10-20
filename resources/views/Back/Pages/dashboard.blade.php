@extends('Back.Layout.pages-layout')

@section('pageTitle') Dashboard @endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/add-post.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/categories.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/dashboard.css') }}" />
    <style>
        .custom-progress {
            height: 7px;
            border-radius: 10px;
            background: #E2E8F0;
            overflow: hidden;
            margin: 0;
        }
        .custom-progress-bar {
            height: 100%;
            border-radius: 10px;
            transition: width 0.5s ease;
        }
        .dash-subscriber-icon {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.2));
            color: #10B981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            flex-shrink: 0;
        }
    </style>
@endpush

@section('content')

{{-- Alerts --}}
<x-form-alerts></x-form-alerts>

{{-- Standard Premium Page Header (Matching all other admin pages) --}}
<div class="premium-page-header">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Dashboard</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-md-right mt-3 mt-md-0">
            <a href="{{ route('admin.posts.add-post') }}" class="custom-action-btn add-btn m-0" style="padding: 10px 22px; font-size: 14px;">
                <i class="fa fa-plus mr-2"></i>Create New Post
            </a>
            <a href="{{ url('/') }}" target="_blank" class="custom-action-btn add-btn m-0 ml-2" style="padding: 10px 18px; font-size: 14px; background: linear-gradient(135deg, #10B981, #059669); border-color: #10B981;">
                <i class="fa fa-external-link mr-2"></i>View Site
            </a>
        </div>
    </div>
</div>

{{-- Stat Cards Grid --}}
<div class="dash-stats-grid">
    {{-- Total Posts --}}
    <a href="{{ route('admin.posts.all-posts') }}" class="dash-stat-card" style="--card-color: #5B4BDB;">
        <div class="dash-stat-icon">
            <i class="dw dw-newspaper-1"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalPosts) }}</div>
            <div class="dash-stat-label">Total Articles</div>
            <div class="dash-stat-badge">
                <i class="dw dw-checked mr-1"></i>{{ $publishedPosts }} Published &middot; {{ $privatePosts }} Private
            </div>
        </div>
    </a>

    {{-- Categories --}}
    @if(auth()->user()->type->value === 'superAdmin')
    <a href="{{ route('admin.categories') }}" class="dash-stat-card" style="--card-color: #3B82F6;">
        <div class="dash-stat-icon">
            <i class="dw dw-list"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalCategories) }}</div>
            <div class="dash-stat-label">Categories</div>
            <div class="dash-stat-badge">Organized Topics</div>
        </div>
    </a>
    @else
    <div class="dash-stat-card" style="--card-color: #3B82F6;">
        <div class="dash-stat-icon">
            <i class="dw dw-list"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalCategories) }}</div>
            <div class="dash-stat-label">Categories</div>
            <div class="dash-stat-badge">Organized Topics</div>
        </div>
    </div>
    @endif

    {{-- Subscribers --}}
    <div class="dash-stat-card" style="--card-color: #10B981;">
        <div class="dash-stat-icon">
            <i class="dw dw-email"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalSubscribers) }}</div>
            <div class="dash-stat-label">Subscribers</div>
            <div class="dash-stat-badge">
                <i class="dw dw-checked mr-1"></i>{{ $activeSubscribers }} Active Readers
            </div>
        </div>
    </div>

    {{-- Users / Authors --}}
    @if(auth()->user()->type->value === 'superAdmin')
    <a href="{{ route('admin.users') }}" class="dash-stat-card" style="--card-color: #F59E0B;">
        <div class="dash-stat-icon">
            <i class="dw dw-user1"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalUsers) }}</div>
            <div class="dash-stat-label">Authors &amp; Admins</div>
            <div class="dash-stat-badge">Manage Team &rarr;</div>
        </div>
    </a>
    @else
    <div class="dash-stat-card" style="--card-color: #F59E0B;">
        <div class="dash-stat-icon">
            <i class="dw dw-user1"></i>
        </div>
        <div class="dash-stat-info">
            <div class="dash-stat-value">{{ number_format($totalUsers) }}</div>
            <div class="dash-stat-label">Authors &amp; Admins</div>
            <div class="dash-stat-badge">Content Creators</div>
        </div>
    </div>
    @endif
</div>

{{-- Main Dashboard Content: Symmetrical Full-Width Stacked Tables with Scroll --}}
<div class="row">
    {{-- 1. Recent Articles Table --}}
    <div class="col-12 mb-30">
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">
                    <i class="dw dw-newspaper-1" style="background: rgba(91, 75, 219, 0.1); color: #5B4BDB;"></i>
                    Recent Articles
                </h2>
                <a href="{{ route('admin.posts.all-posts') }}" class="dash-view-all">
                    View All Articles <i class="fa fa-arrow-right ml-1"></i>
                </a>
            </div>
            <div class="dash-card-body">
                @if($recentPosts->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="dw dw-newspaper-1" style="font-size:3rem; opacity:0.3; margin-bottom:15px; display:block;"></i>
                        <h5 class="text-muted">No articles created yet</h5>
                        <p class="font-14">Get started by creating your first blog article.</p>
                        <a href="{{ route('admin.posts.add-post') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fa fa-plus mr-1"></i> Create First Post
                        </a>
                    </div>
                @else
                    <div class="table-responsive dash-scroll-container" style="max-height: 380px;">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Article</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPosts as $post)
                                <tr>
                                    <td>
                                        <div class="post-title-cell">
                                            @if($post->featured_image && file_exists(public_path('images/posts/' . $post->featured_image)))
                                                <img src="{{ asset('images/posts/' . $post->featured_image) }}" class="post-thumb" alt="{{ $post->title }}">
                                            @else
                                                <div class="post-no-thumb">
                                                    <i class="dw dw-image1"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <a href="{{ route('admin.posts.edit-post', $post->id) }}" class="post-title-text d-block" title="{{ $post->title }}">
                                                    {{ $post->title }}
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border text-primary font-12 font-weight-bold py-1 px-2">
                                            {{ optional($post->category)->name ?? 'General' }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="font-13 text-secondary font-weight-bold">{{ optional($post->author)->name ?? 'Admin' }}</span>
                                    </td>
                                    <td>
                                        @if((int)$post->visibility === 1)
                                            <span class="vis-badge pub">
                                                <i class="dw dw-checked mr-1"></i> Published
                                            </span>
                                        @else
                                            <span class="vis-badge priv">
                                                <i class="dw dw-padlock mr-1"></i> Private
                                            </span>
                                        @endif
                                    </td>
                                    <td class="font-13 text-muted">
                                        {{ optional($post->created_at)->format('d M, Y') ?? '—' }}
                                    </td>
                                    <td class="text-right">
                                        <div class="d-inline-flex align-items-center">
                                            <a href="{{ route('post.show', $post->slug) }}" target="_blank" class="btn btn-outline-secondary btn-sm" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;" title="View Article on Site">
                                                <i class="dw dw-eye" style="font-size: 14px;"></i>
                                            </a>
                                            <a href="{{ route('admin.posts.edit-post', $post->id) }}" class="btn btn-outline-primary btn-sm ml-1" style="width: 32px; height: 32px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 8px;" title="Edit Article">
                                                <i class="dw dw-edit2" style="font-size: 14px;"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- 2. Top Categories & Content Share Table --}}
    @if(!$topCategories->isEmpty())
    <div class="col-12 mb-30">
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">
                    <i class="dw dw-layers" style="background: rgba(59, 130, 246, 0.1); color: #3B82F6;"></i>
                    Categories &amp; Content Share
                </h2>
                @if(auth()->user()->type->value === 'superAdmin')
                <a href="{{ route('admin.categories') }}" class="dash-view-all">
                    Manage Categories <i class="fa fa-arrow-right ml-1"></i>
                </a>
                @endif
            </div>
            <div class="dash-card-body">
                <div class="table-responsive dash-scroll-container" style="max-height: 320px;">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Articles Count</th>
                                <th style="width: 45%;">Content Share</th>
                                <th>Percentage</th>
                                @if(auth()->user()->type->value === 'superAdmin')
                                <th class="text-right">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $palette = ['#5B4BDB', '#3B82F6', '#10B981', '#F59E0B', '#EC4899', '#8B5CF6', '#06B6D4', '#F97316'];
                            @endphp
                            @foreach($topCategories as $idx => $cat)
                                @php
                                    $percentage = $totalPosts > 0 ? round(($cat->posts_count / $totalPosts) * 100) : 0;
                                    $color = $palette[$idx % count($palette)];
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <i class="dw dw-tag mr-2 flex-shrink-0" style="color: {{ $color }}; font-size: 15px;"></i>
                                            <span class="font-14 font-weight-bold text-dark">{{ $cat->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border font-12 font-weight-bold px-2 py-1">
                                            {{ $cat->posts_count }} articles
                                        </span>
                                    </td>
                                    <td>
                                        <div class="custom-progress" style="margin-top: 0; height: 7px;">
                                            <div class="custom-progress-bar" style="width: {{ $percentage }}%; background-color: {{ $color }};"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="font-13 font-weight-bold" style="color: {{ $color }};">{{ $percentage }}%</span>
                                    </td>
                                    @if(auth()->user()->type->value === 'superAdmin')
                                    <td class="text-right">
                                        <a href="{{ route('admin.categories') }}" class="btn btn-outline-primary btn-sm" style="border-radius: 8px; padding: 5px 14px; font-weight: 600;" title="Manage Category">
                                            <i class="dw dw-edit2 mr-1"></i> Manage
                                        </a>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 3. Newsletter Subscribers Table --}}
    <div class="col-12 mb-30">
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">
                    <i class="dw dw-email" style="background: rgba(16, 185, 129, 0.1); color: #10B981;"></i>
                    Newsletter Subscribers
                </h2>
                <span class="badge badge-success badge-pill font-12">{{ $activeSubscribers }} Active Subscribers</span>
            </div>
            <div class="dash-card-body">
                @if($recentSubscribers->isEmpty())
                    <div class="text-center py-4 text-muted font-14">
                        <i class="dw dw-email font-24 d-block mb-2 opacity-50"></i>
                        No subscribers yet.
                    </div>
                @else
                    <div class="table-responsive dash-scroll-container" style="max-height: 320px;">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Subscriber Email</th>
                                    <th>Subscribed Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSubscribers as $subscriber)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="dash-subscriber-icon mr-3">
                                                <i class="dw dw-email" style="font-size: 15px;"></i>
                                            </div>
                                            <span class="font-14 font-weight-bold text-dark">{{ $subscriber->email }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-13 text-dark font-weight-bold">{{ optional($subscriber->created_at)->format('d M, Y') ?? '—' }}</div>
                                        <div class="font-11 text-muted">{{ optional($subscriber->created_at)->diffForHumans() }}</div>
                                    </td>
                                    <td>
                                        <span class="vis-badge {{ $subscriber->status ? 'pub' : 'dft' }}">
                                            <i class="dw {{ $subscriber->status ? 'dw-checked' : 'dw-cancel' }} mr-1"></i>
                                            {{ $subscriber->status ? 'Active' : 'Unsubscribed' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
