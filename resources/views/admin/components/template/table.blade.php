<div class='table-responsive'>
	<table class="table table-hover">

		@if (isset($thead) && $thead)
		<thead>
			{{ $thead }}
		</thead>
		@endif

		<tbody>
			{{ $slot }}
		</tbody>

		@if (isset($tfooter) && $tfooter)
			{{ $tfooter }}
		@endif

	</table>
</div>