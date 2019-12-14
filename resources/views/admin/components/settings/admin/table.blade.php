@component('admin.components.template.table')
	@slot('thead')
	<tr>
		<th width='5'>#</th>
		<th>User's Name</th>
		<th>User's Username</th>
		<th># Org Group</th>
		<th># Org</th>
	</tr>
	@endslot

	@foreach ($users as $k => $user)
	<tr>
		<td>{{ (($users->currentPage() - 1) * $users->perPage()) + ($k + 1) }}</td>
		<td><a href="{{ route('user.show', ['id' => $user->id]) }}">{{ $user->name }}</a></td>
		<td>{{ $user->username }}</td>
		<td>{{ $user->org_groups->count() }}</td>
		<td>{{ $user->orgs->count() }}</td>
	</tr>
	@endforeach
@endcomponent

@if (method_exists($users, 'links'))
	{{ $users->appends(request()->query())->links() }}
@endif
