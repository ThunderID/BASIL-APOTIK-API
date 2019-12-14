<div class='row'>
	<div class='col-12 col-md-3 mb-3'>
		@stats([
			'icon'          => 'fa-building-o',
			'label'         => 'Hotel Group',
			'slot'          => number_format($user->org_groups->count()),
		])
	</div>

	<div class='col-12 col-md-3 mb-3'>
		@stats([
			'icon'          => 'fa-building-o',
			'label'         => 'Hotel',
			'slot'          => number_format($user->orgs->count()),
		])
	</div>
</div>