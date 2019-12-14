@push('page_actions')
@endpush

@push('content')
<div class='row'>
	<div class='col'>
		@component('admin.components.template.card')

			@slot('class')
				border-light
			@endslot

			@slot('title')
				Settings
			@endslot
			
			<div class='row mt-4'>
				<div class='col-auto'>
					<ul class="nav nav-pills flex-column">
						<li class="nav-item"><a class="nav-link {{ !request()->query('mode') || request()->query('mode') == 'admin' ? 'active' : '' }}" href="{{ route('settings.index') }}">Manage Admin</a></li>
					</ul>
				</div>

				<div class='col'>
					@includeWhen((!request()->query('mode') || request()->query('mode') == 'admin') && !request()->query('action'), 'admin.pages.settings.admin.index', ['user' => $me])
					@includeWhen((!request()->query('mode') || request()->query('mode') == 'admin') && request()->query('action') == 'form', 'admin.pages.settings.admin.form', ['user' => $me])
				</div>
			</div>

		@endcomponent
	</div>
</div>
@endpush