@php
	$errorName = $name;
	if (str_is('*[*', $name)) {
		$errorName = str_replace('[', '.', str_replace(']', '', $name));
	}
@endphp

<div class="form-group mb-4{{ $errors->has($errorName) ? ' has-error has-danger' : '' }} {{ $class ?? null }}">
	@if(isset($label) && ! in_array($type, ['checkbox', 'radio']))
		{{ Form::label($name, trans('messages.'. $label), ['class' => 'font-weight-bold']) }}
	@endif

	@if(isset($inputGroup))
		<div class="input-group">
			<div class="input-group-prepend">
				<span class="input-group-text">{{ $inputGroup }}</span>
			</div>
			@endif

			@switch($type)
				@case('password')
				@case('file')
				{{ Form::$type($name, array_merge(['class' => 'form-control'], $attributes ?? [])) }}
				@break

				@case('editor')
				<div class="editor quill-container" data-name="{{ $name }}">{!! $value ?? old($name) !!}</div>
				{{ Form::textarea($name, $value ?? null, array_merge(['class' => 'd-none'], $attributes ?? [])) }}
				@break

				@case('datepicker')
				<div class="input-group date datepicker">
					{{ Form::text($name, $value ?? null, array_merge(['class' => 'form-control'], $attributes ?? [])) }}
					<span class="input-group-addon input-group-append border-left">
                          <span class="mdi mdi-calendar input-group-text"></span>
                    </span>
				</div>
				@break

				@case('select')
				{{ Form::select($name,
					$options ?? [],
					$selected ?? null,
					array_merge(['class' => 'form-control'], $attributes ?? []),
					$optionsAttributes ?? [],
					$optgroupsAttributes ?? []
				) }}
				@break

				@case('checkbox')
				@case('radio')
				<div class="custom-control custom-{{ $type }}">
					{!! Form::$type($name, $value ?? null, $checked ?? null,
						array_merge(['class' => 'custom-control-input', 'id' => $name], $attributes ?? [])
					); !!}
					{{ Form::label($name, trans('messages.'. $label), ['class' => 'font-weight-bold custom-control-label']) }}
				</div>
				@break

				@default
				{{ Form::$type($name, $value ?? null, array_merge(['class' => 'form-control'], $attributes ?? [])) }}
			@endswitch

			@if(isset($inputGroup))
		</div>
	@endif

	@if($slot)
		<small class="form-text form-control-feedback">{{ $slot }}</small>
	@endif

	@if($errors->has($errorName))
		<small class="form-text text-danger form-control-feedback">
			{{ $errors->first($errorName) }}
		</small>
	@endif
</div>