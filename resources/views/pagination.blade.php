@if ($paginator->lastPage() > 1)
	<div class="pagination-holder">
		<ul class="pagination pull-right">
			<li class="{{ ($paginator->currentPage() == 1) ? ' disabled' : '' }}">
				<a href="{{ $paginator->url(1) }}"><</a>
			</li>
			<li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' disabled' : '' }}">
				<a href="{{ $paginator->url($paginator->currentPage()+1) }}">></a>
			</li>
		</ul>
		<div class="pull-right pagination-digits">
			<b>
				{{ $paginator->perPage() * ($paginator->currentPage() - 1) + 1 }}
				-
				@if ($paginator->currentPage() == $paginator->lastPage())
					{{ $paginator->total() }}
				@else
					{{ $paginator->perPage() * $paginator->currentPage() }}
				@endif
			</b>
			of {{ $paginator->total() }}
		</div>
	</div>
@endif