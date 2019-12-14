@push('content')
	<div class='row'>
		<div class='col-12 col-md-4 mb-3'>
			@stats([
				'icon'          => 'fa-user',
				'label'         => 'Client',
				'slot'          => number_format($user_count),
				'footer_prefix' => $user_count - $prev_user_count >= 0 ? "+" : "-",
				'footer_stat'   => $user_count - $prev_user_count,
				'footer_suffix' => 'this month'
			])
		</div>

		<div class='col-12 col-md-4 mb-3'>
			@stats([
				'icon'          => 'fa-building-o',
				'label'         => 'Org Group',
				'slot'          => number_format($org_group_count),
				'footer_prefix' => $org_group_count - $prev_org_group_count >= 0 ? "+" : "-",
				'footer_stat'   => $org_group_count - $prev_org_group_count,
				'footer_suffix' => 'this month'
			])
		</div>

		<div class='col-12 col-md-4 mb-3'>
			@stats([
				'icon'          => 'fa-h-square',
				'label'         => 'Org',
				'slot'          => number_format($org_count),
				'footer_prefix' => $org_count - $prev_org_count >= 0 ? "+" : "-",
				'footer_stat'   => $org_count - $prev_org_count,
				'footer_suffix' => 'this month'
			])
		</div>
	</div>

	<div class='row'>
		<div class='col-12'>
			@component('admin.components.template.card')
				@slot('title')
					10 Latest Hotel
				@endslot

				@include('admin.components.org.table', ['orgs' => $latest_orgs])

			@endcomponent
		</div>
	</div>
@endpush