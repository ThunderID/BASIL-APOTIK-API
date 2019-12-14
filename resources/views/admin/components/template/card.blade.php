<div class="card {{ $class ?? '' }}">
	@if (isset($header))
		<div class="card-header bg-white">
			{{ $header }}
		</div>
	@endif

	<div class="card-body">
		@if (isset($img))
			<img src="{{ $img }}" class="card-img-top">
		@endif 

		@if (isset($dropdown))
			<div class="dropdown float-right">
				<button class="btn dropdown-toggle no-caret" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class='fa fa-ellipsis-v'></i></button>
				<div class="dropdown-menu dropdown-menu-right">
					{!! $dropdown !!}
				</div>
			</div>
		@endif

		@if (isset($title))
			<div class='text-muted pt-1'>
				<strong>{{ $title }}</strong>
			</div>
		@endif

		@if (isset($subtitle))
			<h6 class="card-subtitle mb-2">{{ $subtitle }}</h6>
		@endif

		{{ $slot }}
	</div>

	@if (isset($footer))
	<div class="card-footer">
		{{ $footer }}
	</div>
	@endif
</div>