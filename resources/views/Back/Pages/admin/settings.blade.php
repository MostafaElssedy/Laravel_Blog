@extends('Back.Layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Settings')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/admin-profile.css') }}" />
@endpush

@section('content')

    <div class="premium-page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="title">
                    <h4>General Settings</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @livewire('admin-settings')

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
