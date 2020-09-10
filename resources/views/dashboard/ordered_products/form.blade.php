@extends('layouts.dashboard')

@section('content')
	<form method="post"
	      action="@if ($item->id == null) {{ route('dashboard.ordered_products.store') }} @else {{ route('dashboard.ordered_products.update', ['id' => $item->id]) }} @endif"
	      enctype="multipart/form-data">
		{{ csrf_field() }}
		@if ($item->id != null)
			{{ method_field('PUT') }}
		@endif
		<input type="hidden" name="order_id" value="{{ $order->id }}">
		<input type="hidden" name="product_id" class="js-product-id" value="{{ $item->product_id }}">

		<div class="form-group {{ $errors->has('product_id') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.products.f_name')}}</label>
			<input type="text" class="form-control" value="{{($item->product == null) ? '' : $item->product->name}}"
			       name="product_name" id="autocomplete"/>
			@if ($errors->has('product_id'))
				<span class="help-block">
                    <strong>{{ $errors->first('product_id') }}</strong>
                </span>
			@endif
		</div>

		<div class="form-group {{ $errors->has('count') ? ' has-error' : '' }}">
			<label for="" class="control-label">{{__('messages.ordered_products.f_count')}}</label>
			<input type="text" class="form-control" value="{{$item->count}}" name="count"/>
			@if ($errors->has('count'))
				<span class="help-block">
                    <strong>{{ $errors->first('count') }}</strong>
                </span>
			@endif
		</div>

		<br>
		<br>

		<button type="submit" class="btn btn-primary btn-block">{{__('messages.actions.save')}}</button>
	</form>
	<script src="/vendor/jquery.autocomplete.js"></script>
	<script>
        $(document).ready(function () {
            $('#autocomplete').autocomplete({
                serviceUrl: '/products/autocomplete?city_id={{ $order->city_id }}&restaurant_id={{ $order->restaurant_id }}',
                onSelect: function (suggestion) {
                    $('.js-product-id').val(suggestion.data);
                }
            });
        });
	</script>
@endsection