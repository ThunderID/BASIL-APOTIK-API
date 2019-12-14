@push('page_actions')
@endpush

@push('content')
<div class='row'>
	<div class='col'>
		@component('admin.components.template.card')

			@slot('class')
				border-light
			@endslot

			@slot('dropdown')
				<a href="{{ route("user.show", ['user_id' => $user->id, 'mode' => 'edit']) }}" class='dropdown-item'>Edit</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="{{ route('user.show', ['user_id' => $user->id, 'mode' => 'org_group_form']) }}">Add Org Group</a>
			@endslot

			@slot('title')
				{{ $user->name }} ({{ $user->username }})
			@endslot

			<div class='row'>
				<div class='col-auto mt-4'>
					<ul class="nav nav-pills flex-column">
						<li class="nav-item"><a class="nav-link {{ !request()->query('mode') ? 'active' : '' }}" href="{{ route('user.show', ['id' => $user->id]) }}">Summary</a></li>
					</ul>

					<h6 class='mt-3 text-muted small'><strong>GROUP</strong></h6>
					@foreach ($user->org_groups as $org_group)
						<ul class="nav nav-pills flex-column">
							<li class="nav-item"><a class="nav-link {{ request()->query('org_group_id') == $org_group->id ? 'active' : '' }}" href="{{ route('user.show', ['id' => $user->id, 'mode' => 'org_group', 'org_group_id' => $org_group->id]) }}">{{ $org_group->name }}</a></li>
						</ul>
					@endforeach
				</div>

				<div class='col mt-4'>
					@includeWhen(request()->query('mode') == 'edit', 'admin.pages.user.show.edit', ['user' => $user])
					@includeWhen(!request()->query('mode'), 'admin.pages.user.show.index', ['user' => $user])
					
					{{---------------------- ORG GROUP ----------------------}}
					{{-- OrgGroup New --}}
					@includeWhen(request()->query('mode') == 'org_group_form' && !request()->query('org_group_id'), 'admin.pages.user.show.org_group_form', ['user' => $user, 'org_group' => null])

					@foreach ($user->org_groups as $org_group)
						{{-- OrgGroup Table --}}
						@includeWhen(request()->query('mode') == 'org_group' && request()->query('org_group_id') == $org_group->id, 'admin.pages.user.show.org_group', ['user' => $user, 'org_group' => $org_group])

						{{-- OrgGroup Edit --}}
						@includeWhen(request()->query('mode') == 'org_group_form' && request()->query('org_group_id') == $org_group->id, 'admin.pages.user.show.org_group_form', ['user' => $user, 'org_group' => $org_group])
						
						{{---------------------- ORG ----------------------}}
						{{-- Org New --}}
						@includeWhen(request()->query('mode') == 'org_form' && request()->query('org_group_id') == $org_group->id && !request()->query('org_id'), 'admin.pages.user.show.org_form', ['user' => $user, 'org_group' => $org_group, 'org' => null])

						{{-- Org Edit --}}
						@if ($org_group->orgs->firstWhere('id', '=', request()->query('org_id')))
							@includeWhen(request()->query('mode') == 'org_form' && request()->query('org_group_id') == $org_group->id && request()->query('org_id'), 'admin.pages.user.show.org_form', ['user' => $user, 'org_group' => $org_group, 'org' => $org_group->orgs->firstWhere('id', '=', request()->query('org_id'))])
						@endif
					@endforeach



				</div>
			</div>
		@endcomponent
	</div>
</div>
@endpush