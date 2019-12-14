@push('content')
    <div class='py-3'>
        @include('admin.components.form.reset_password')
        <hr>
        <a href='{{ route('login') }}'>Login</a>
    </div>
@endpush