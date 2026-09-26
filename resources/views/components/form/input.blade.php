@props([
    'type'=>'text',
    'id',
    'name',
    'label',
    'value'=>''

])

@if(isset($label))
<label for="{{ $id }}">{{$label}}</label>
@endif
<input 
type="{{ $type }}" 
id="{{ $id }}" 
name="{{ $name }}"
value="{{ old($name, $value) }}"
{{-- class="form-control @error($name) is-invalid @enderror" --}}
{{ $attributes->class(['form-control','is-invalid'=>$errors->has($name) ]) }}
    >
{{-- @if ($errors->has('name'))
                <p class="text-danger">{{$errors->first('name')}}</p>
                @endif --}}
{{-- OR --}}
@error($name )
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
