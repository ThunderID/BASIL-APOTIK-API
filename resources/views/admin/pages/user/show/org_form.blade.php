@component('admin.components.template.card')
	@slot('dropdown')
		@if (isset($org) && $org)
			<a href="{{ route('user.show', ['mode' => 'org', 'id' => $user->id, 'org_id' => $org->id ]) }}" class='dropdown-item'>Cancel</a>
		@endif 
	@endslot

	@slot('title')
		@if (isset($org))
			Edit {{$org->name}}
		@else
			New Hotel
		@endif
	@endslot

	@include('admin.components.org.form', ['org' => $org ?? null])

@endcomponent