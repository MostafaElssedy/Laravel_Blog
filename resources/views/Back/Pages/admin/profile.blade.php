@extends('Back.Layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Profile')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('Back/vendors/styles/admin-profile.css') }}" />
@endpush

@section('content')
<div class="premium-page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="row align-items-stretch">
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30 d-flex flex-column">
        <div class="w-100 flex-grow-1 d-flex flex-column">
            @livewire('admin-profile-header')
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30 d-flex flex-column">
        <div class="w-100 flex-grow-1 d-flex flex-column">
            @livewire('admin-profile-tabs')
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    window.addEventListener('showToast', function(event) {
        let data = event.detail[0];
        if(typeof ijabo !== 'undefined') {
            ijabo.showToast(data.message, data.type);
        } else {
            alert(data.message);
        }
    });

    if(typeof $.fn.ijaboCropTool !== 'undefined') {
        $('#profile_picture').ijaboCropTool({
            preview : '.profile-picture',
            setRatio:1,
            allowedExtensions: ['jpg', 'jpeg','png'],
            buttonsText:['CROP','QUIT'],
            buttonsColor:['#30bf7d','#ee5155', -15],
            processUrl:'{{ route("admin.updateProfilePicture") }}',
            withCSRF:['_token','{{ csrf_token() }}'],
            onSuccess:function(message, element, status){
                if(typeof ijabo !== 'undefined') ijabo.showToast(message, 'success');
                Livewire.dispatch('updateAdminProfileHeader');
            },
            onError:function(message, element, status){
                if(typeof ijabo !== 'undefined') ijabo.showToast(message, 'error');
            }
        });
    } else {
        console.error('ijaboCropTool is not loaded!');
    }
});
</script>
@endpush
