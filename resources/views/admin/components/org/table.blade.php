@component('admin.components.template.table')
	@slot('thead')
		<tr>
			<th>#</th>
			<th>Group</th>
			<th>Org</th>
			<th>Owner</th>
			<th>Created At</th>
		</tr>
	@endslot

	@forelse ($orgs as $k => $org)
		<tr>
			<td>{{ $k + 1 }}</td>
			<td>{{ $org->org_group->name }}</td>
			<td>{{ $org->name }}</td>
			<td>{{ $org->org_group->owner->name }}</td>
			<td>{{ $org->created_at->format('d-M-Y [H:i]') }} </td>
		</tr>
	@empty
		<tr>
			<td colspan='100'>-</td>
		</tr>
	@endforelse
@endcomponent

@if (method_exists($orgs, 'links'))
	{{ $orgs->appends(request()->query())->links() }}
@endif


