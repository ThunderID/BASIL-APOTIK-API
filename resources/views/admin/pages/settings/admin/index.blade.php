
@component('admin.components.template.card')

	@slot('dropdown')
		<a href="{{ route('settings.index', ['mode' => 'admin', 'action' => 'form']) }}" class='dropdown-item'>New</a>
	@endslot

	@slot('title')
		ADMIN
	@endslot

	<div class='my-3'></div>

	@component('admin.components.template.table')
		@slot('thead')
			<tr>
				<th>Name</th>
				<th>Username</th>
				<th>Role</th>
			</tr>
		@endslot
	@endcomponent
@endcomponent
