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
				{{ $me->name }} ({{ $me->username }})
			@endslot
			
			<div class='row mt-4'>
				<div class='col-auto'>
					<ul class="nav nav-pills flex-column">
						<li class="nav-item"><a class="nav-link {{ request()->query('mode') == 'update_profile' || !request()->query('mode') ? 'active' : '' }}" href="{{ route('me.index', ['mode' => 'update_profile']) }}">Update Profile</a></li>
						<li class="nav-item"><a class="nav-link {{ request()->query('mode') == 'update_password' ? 'active' : '' }}" href="{{ route('me.index', ['mode' => 'update_password']) }}">Update Password</a></li>
					</ul>
				</div>

				<div class='col mt-2'>
					@includeWhen(!request()->query('mode') || request()->query('mode') == 'update_profile', 'admin.pages.me.update-profile', ['user' => $me])
					@includeWhen(request()->query('mode') == 'update_password', 'admin.pages.me.update-password')
				</div>
			</div>

		@endcomponent
	</div>
</div>
@endpush