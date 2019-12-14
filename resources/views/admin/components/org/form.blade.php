<form method="POST" action="{{ $action_url ?? route('user.org.form.post', ['user_id' => $user->id, 'id' => $org ? $org->id : null]) }}">
	@csrf
	<div class='row'>
		<div class='col-12'>
			@input([
				'type'      => 'hidden', 
				'name'      => 'org_group_id', 
				'value'     => request()->query('org_group_id')
			])
		</div>

		<div class='col-12'>
			@input([
				'type'      => 'text', 
				'label'     => 'name', 
				'name'      => 'name', 
				'errors'    => $errors->get('name'), 
				'autofocus' => true,
				'value'     => request()->old('name', $org ? $org->name : null)
			])
		</div>

		<div class='col-12'>
			@input([
				'type'      => 'text', 
				'label'     => 'address', 
				'name'      => 'address', 
				'errors'    => $errors->get('address'), 
				'autofocus' => true,
				'value'     => request()->old('address', $org ? $org->address : null)
			])
		</div>

		<div class='col-6 col-md-4'>
			@input([
				'type'      => 'text', 
				'label'     => 'city', 
				'name'      => 'city', 
				'errors'    => $errors->get('city'), 
				'autofocus' => true,
				'value'     => request()->old('city', $org ? $org->city : null)
			])
		</div>

		<div class='col-6 col-md-4'>
			@input([
				'type'      => 'text', 
				'label'     => 'province', 
				'name'      => 'province', 
				'errors'    => $errors->get('province'), 
				'autofocus' => true,
				'value'     => request()->old('province', $org ? $org->province : null)
			])
		</div>

		<div class='col-6 col-md-4'>
			@input([
				'type'      => 'text', 
				'label'     => 'country', 
				'name'      => 'country', 
				'errors'    => $errors->get('country'), 
				'autofocus' => true,
				'value'     => request()->old('country', $org ? $org->country : null)
			])
		</div>

		<div class='col-6 col-md-4'>
			@input([
				'type'      => 'text', 
				'label'     => 'phone', 
				'name'      => 'phone', 
				'errors'    => $errors->get('phone'), 
				'autofocus' => true,
				'value'     => request()->old('phone', $org ? $org->phone : null)
			])
		</div>

		<div class='col-12'>
			@button([
				'type'  => 'submit', 
				'name'  => 'login', 
				'class' => 'btn-primary',
				'slot'  => 'Save'
			])
		</div>
	</div>
</form>