<div>
<div>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    @endpush

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                };

                @if(Session::has('info'))
                    toastr.info('{!! Session::get("info") !!}');
                @endif

                @if(Session::has('success'))
                    toastr.success('{!! Session::get("success") !!}');
                @endif

                @if(Session::has('fail'))
                    toastr.error('{!! Session::get("fail") !!}');
                @endif
            });
        </script>
    @endpush
</div>
</div>