@extends('Back.Layout.pages-layout')
@section('pageTitle')
    Categories
@endsection
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/admin-profile.css') }}" />
@endpush
@section('content')
    @livewire('categories.categories')
@endsection
@push('scripts')
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