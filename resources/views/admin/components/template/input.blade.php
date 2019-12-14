@php
	$id = Str::random(15);
@endphp

<div class="form-group">
	@if (isset($label))	
		<label for="{{ $id }}" class='text-uppercase text-muted'><small>{{ $label ?? "" }}</small></label>
	@endif
	
	<input type="{{ $type ?? 'text' }}" id="{{ $id }}" name="{{ $name }}" value="{{ $value ?? '' }}" class="form-control {{ $class ?? '' }} {{ isset($errors) && count($errors) ? 'is-invalid' : ''}} " placeholder="{{ $placeholder ?? '' }}" autocomplete="{{ $autocomplete ?? 'off' }}" {{ isset($autofocus) && $autofocus ? 'autofocus' : '' }}>
	
	@if (isset($errors))
		<span class='text-danger'>
			@foreach ($errors as $error)
				{{ $error }}<br>
			@endforeach
		</span>
	@endif
</div>
