@push('page_actions')
	<ul class="nav nav-pills card-header-tabs">
		<li class="nav-item"><a class="nav-link {{ request()->get('mode') != 'owner' ? 'active' : ''}}" href="{{ route('user.index') }}">All Users</a></li>
		<li class="nav-item"><a class="nav-link {{ request()->get('mode') == 'owner' ? 'active' : ''}}" href="{{ route('user.index', ['mode' => 'owner']) }}">Org Owner</a></li>
	</ul>
@endpush

@push('content')
<div class='row'>
	<div class='col'>
		@component('admin.components.template.card')
			@slot('dropdown')
				<a href="{{ route('user.form') }}" class='dropdown-item'>New</a>
			@endslot

			@slot('title')
				{{ request()->get('mode') == 'owner' ? 'Org Owner' : 'All User' }}
			@endslot

			@include('admin.components.user.table', ['users' => $users])
		@endcomponent
		
	</div>
</div>
@endpush