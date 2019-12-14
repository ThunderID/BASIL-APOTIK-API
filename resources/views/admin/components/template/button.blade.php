<button type="{{ $type ?? 'text' }}" name="{{ $name }}" value="{{ $value ?? '' }}" class="btn {{ $class ?? '' }}">
	@if (isset($icon))
		<i class='fa {{ $icon }}'></i>
	@endif
	{!! $slot ?? '' !!}
</button>
