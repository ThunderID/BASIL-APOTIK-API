<form method="POST" action="{{ $action_url ?? route('me.update_password.post') }}">
    @csrf
    @input([
        'type'        => 'password', 
        'label'       => 'current password', 
        'name'        => 'current_password', 
        'errors'      => $errors->get('current_password'), 
        'autofocus'   => true,
        'placeholder' => '*********'
    ])

    @input([
        'type'        => 'password', 
        'label'       => 'new password', 
        'name'        => 'new_password', 
        'errors'      => $errors->get('new_password'), 
        'placeholder' => '*********'
    ])

    @input([
        'type'        => 'password', 
        'label'       => 'new password confirmation', 
        'name'        => 'new_password_confirmation', 
        'errors'      => $errors->get('new_password_confirmation'), 
        'placeholder' => '*********'
    ])
    
    @button([
        'type'  => 'submit', 
        'name'  => 'login', 
        'class' => 'btn-primary',
        'slot'  => 'Save'
    ])
</form>