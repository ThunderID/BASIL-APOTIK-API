<form method="POST" action="{{ $action_url ?? route('me.update_profile.post') }}">
	@csrf
	<div class='row'>
		<div class='col-12'>
			@input([
				'type'  => 'text', 
				'label' => 'name', 
				'name'  => 'name', 
				'value'  => $user ? $user->name : '', 
				'errors'  => $errors->get('name'), 
				'autofocus' => true,
				'value' => request()->old('name', $user->name) ?? '', 
			])
		</div>

		<div class='col-12'>
			@input([
				'type'  => 'text', 
				'label' => 'username (mobile phone number)', 
				'name'  => 'username', 
				'value'  => $user ? $user->username : '', 
				'errors'  => $errors->get('username'), 
				'value' => request()->old('username', $user->username) ?? '', 
			])
		</div>

		@if (!$user->id)
			<div class='col-6'>
				@input([
					'type'  => 'password', 
					'label' => 'password', 
					'name'  => 'password', 
					'errors'  => $errors->get('password'), 
				])
			</div>

			<div class='col-6'>
				@input([
					'type'  => 'password', 
					'label' => 'Password Confirmation', 
					'name'  => 'password_confirmation', 
					'errors'  => $errors->get('password_confirmation'), 
				])
			</div>
		@endif

		<div class='col-6'>
			@button([
				'type'  => 'submit', 
				'name'  => 'login', 
				'class' => 'btn-primary',
				'slot'  => 'Save'
			])
		</div>
	</div>
</form>