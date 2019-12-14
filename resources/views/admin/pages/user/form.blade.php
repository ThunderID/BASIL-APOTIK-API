@push('page_actions')
@endpush

@push('content')
	@component('admin.components.template.card')
		@slot('title')
			<a href='{{ !$user->id ? route("user.index") : route("user.show", ['id' => $user->id]) }}' class='btn float-right'><i class='fa fa-close'></i></a>
			USER FORM
		@endslot
		
		@include('admin.components.user.form', ['action_url' => route('user.form.post')])

	@endcomponent
@endpush