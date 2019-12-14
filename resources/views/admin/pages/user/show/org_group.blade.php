@component('admin.components.template.card')
	@slot('dropdown')
		<a href="{{ route('user.show', ['user_id' => $user->id, 'mode' => 'org_group_form', 'org_group_id' => $org_group->id]) }}" class='dropdown-item'>Edit</a>
		<div class="dropdown-divider"></div>
		<a href="{{ route('user.show', ['user_id' => $user->id, 'mode' => 'org_form', 'org_group_id' => $org_group->id]) }}" class='dropdown-item'>Add Hotel</a>
	@endslot

	@slot('title')
		{{$org_group->name}}
	@endslot

	@component('admin.components.template.table')
		@slot('thead')
			<tr>
				<th width='15'>#</th>
				<th width='30%'>Name</th>
				<th width='50%'>Address</th>
				<th width='20%'>Phone</th>
		@endslot

		@php
			$prev_city = '';				
		@endphp
		@forelse ($org_group->orgs->sortBy('city') as $k => $org)
			@if ($prev_city != strtolower($org->city))
				<tr>
					<td colspan='5' class='bg-light'>
						{{ $org->city }}
					</td>
				</tr>
			@endif

			<tr>
				<td>{{ $k + 1 }}</td>
				<td><a href="{{ route('user.show', ['user_id' => $user->id, 'mode' => 'org_form', 'org_group_id' => $org->org_group_id, 'org_id' => $org->id]) }}">{{ $org->name }}</a></td>
				<td>
					{{ $org->address }}
					<br>{{ $org->city }} - {{ $org->province }}
					<br>{{ $org->country }}
				</td>
				<td>{{ $org->phone }}</td>
			</tr>

			@php
				$prev_city = strtolower($org->city)
			@endphp
		@empty
			<tr>
				<td colspan='5'>-</td>
			</tr>
		@endforelse
	@endcomponent

@endcomponent