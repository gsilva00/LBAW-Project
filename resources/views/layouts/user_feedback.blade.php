@if(session('success'))
    @include('partials.success_popup')
@endif

@if($errors->any())
    @include('partials.error_popup')
@endif