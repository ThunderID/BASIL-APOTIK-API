<form method="POST" action="{{ $action_url ?? route('forget_password.post') }}">
    @csrf
    <p>Please enter your username to receive an OTP (One-Time-Password) to reset the password</p>
    @input([
        'type'        => 'text', 
        'label'       => 'username', 
        'name'        => 'username', 
        'errors'      => $errors->get('username'), 
        'autofocus'   => true,
    ])

    @button([
        'type'  => 'submit', 
        'name'  => 'login', 
        'class' => 'btn-primary btn-block',
        'slot'  => 'Send me OTP'
    ])
</form>