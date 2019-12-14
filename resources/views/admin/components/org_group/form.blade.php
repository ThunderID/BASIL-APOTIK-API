<form method="POST" action="{{ $action_url ?? route('user.org_group.form.post', ['user_id' => $user->id, 'id' => $org_group ? $org_group->id : null]) }}">
	@csrf
	<div class='row'>
		<div class='col-12'>
			@input([
				'type'      => 'text', 
				'label'     => 'name', 
				'name'      => 'name', 
				'errors'    => $errors->get('name'), 
				'autofocus' => true,
				'value'     => request()->old('name', $org_group ? $org_group->name : null)
			])
		</div>

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