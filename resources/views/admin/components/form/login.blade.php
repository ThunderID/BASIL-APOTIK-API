<form method="POST" action="{{ $action_url ?? route('login.post') }}">
    @csrf
    @input([
        'type'        => 'text', 
        'name'        => 'username', 
        'value'       => $username ?? '6281333517875', 
        'placeholder' => '6281...'
    ])
    
    @input([
        'type'        => 'password', 
        'name'        => 'password', 
        'placeholder' => '*********'
    ])
    
    @button([
        'type'  => 'submit', 
        'name'  => 'login', 
        'class' => 'btn-primary',
        'slot'  => 'Login'
    ])
</form>