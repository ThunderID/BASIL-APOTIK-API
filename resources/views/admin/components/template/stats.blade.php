<div class='card'>
	<div class='card-body'>
		<div class='row'>
			<div class='col-12 text-uppercase text-muted mb-3'>
				@if (isset($icon))
					<i class='float-right fa {{$icon}}'></i>
				@endif
				<strong>{{ $label ?? '' }}</strong>
			</div>
			
			<div class='col-12 h3'>
				{{ $slot ?? '' }}
			</div>

			@if (isset($footer_stat))
				<div class='col-12 text-muted'>
					<span class='badge badge-{{$footer_stat >= 0 ? 'success' : "danger"}} px-2 py-1 mr-2 strong'>
						{{ $footer_prefix ?? '' }} {{ $footer_stat ?? '' }}
					</span> 
					{{ $footer_suffix }}
				</div>
			@endif
		</div>
	</div>
</div>
