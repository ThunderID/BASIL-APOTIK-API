@push('content')
    <div class='py-3'>
        @include('admin.components.form.forget_password')
        <hr>
        <a href='{{ route('login') }}'>Login</a>
    </div>
@endpush