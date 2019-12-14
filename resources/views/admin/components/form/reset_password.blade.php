<form method="POST" action="{{ $action_url ?? route('reset_password.post') }}">
    @csrf
    <p>Please enter your OTP and your new password to reset the password</p>
    @input([
        'type'  => 'hidden', 
        'name'  => 'username', 
        'value' => request()->input('username'), 
    ])

    @input([
        'type'        => 'text', 
        'label'       => 'otp', 
        'name'        => 'otp', 
        'errors'      => $errors->get('otp'), 
        'autofocus'   => true,
    ])

    @input([
        'type'        => 'password', 
        'label'       => 'password', 
        'name'        => 'password', 
        'errors'      => $errors->get('password'), 
        'autofocus'   => true,
    ])

    @input([
        'type'        => 'password', 
        'label'       => 'password confirmation', 
        'name'        => 'password_confirmation', 
        'errors'      => $errors->get('password_confirmation'), 
        'autofocus'   => true,
    ])


    @button([
        'type'  => 'submit', 
        'name'  => 'login', 
        'class' => 'btn-primary btn-block',
        'slot'  => 'Reset Password'
    ])
</form>