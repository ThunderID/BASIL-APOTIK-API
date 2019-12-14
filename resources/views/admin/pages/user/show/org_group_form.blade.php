@component('admin.components.template.card')
	@slot('dropdown')
		@if (isset($org_group) && $org_group)
			<a href="{{ route('user.show', ['mode' => 'org_group', 'id' => $user->id, 'org_group_id' => $org_group->id ]) }}" class='dropdown-item'>Cancel</a>
		@endif 
	@endslot

	@slot('title')
		@if (isset($org_group))
			Edit {{$org_group->name}}
		@else
			New Org Group
		@endif
	@endslot

	@include('admin.components.org_group.form', ['org_group' => $org_group ?? null])

@endcomponent