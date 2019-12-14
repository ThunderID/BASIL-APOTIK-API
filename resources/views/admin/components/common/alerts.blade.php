@foreach (['success', 'info', 'danger', 'primary', 'warning'] as $type)
	@if (session('alert_' . $type))
		<div class='alert alert-{{ $type }}'>
			{{ session('alert_' . $type) }}
		</div>
	@endif
@endforeach