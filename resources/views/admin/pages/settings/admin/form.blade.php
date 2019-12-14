
@component('admin.components.template.card')

	@slot('dropdown')
		<a href="{{ route('settings.index', ['mode' => 'admin', 'action' => 'form']) }}" class='dropdown-item'>New</a>
	@endslot

	@slot('title')
		ADMIN
	@endslot

	<div class='my-3'></div>

	@include('admin.components.settings.admin.form')
		
@endcomponent
