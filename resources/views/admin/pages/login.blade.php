@push('content')
    <div class='py-3'>
        @include('admin.components.form.login')
        <hr>
        <a href='{{ route('forget_password') }}'>Forget password?</a>
    </div>
@endpush