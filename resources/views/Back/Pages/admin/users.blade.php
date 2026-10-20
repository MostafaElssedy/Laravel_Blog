@extends('Back.Layout.pages-layout')

@section('pageTitle')
    Users &amp; Authors Management
@endsection

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/add-post.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/categories.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/admin-profile.css') }}" />
@endpush

@section('content')
    <x-form-alerts></x-form-alerts>
    @livewire('admin-users')
@endsection

@push('scripts')
<script>
    window.addEventListener('showToast', function(event) {
        let data = event.detail;
        if (Array.isArray(data)) {
            data = data[0];
        }
        if (typeof ijabo !== 'undefined') {
            ijabo.showToast(data.message, data.type);
        } else if (typeof toastr !== 'undefined') {
            toastr[data.type](data.message);
        } else {
            alert(data.message);
        }
    });
</script>
@endpush
