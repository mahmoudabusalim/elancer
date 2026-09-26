@props([
    'id' , 
    'label',
    'name',
    'value',
])
@if(isset($label))
<label for="{{$id}}">{{$label}}</label>
@endif
<textarea 
name="{{$name}}"
 id="{{$id}}"
     {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
>
{{old($name,$value)}}
</textarea>
@error($name)
<p class="invalid-feedback">{{ $message }}</p>
@enderror