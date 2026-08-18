@props([
    'id' , 
    'label',
    'name',
    'selected'=>'',
    'options'=>[],
])
<label for="{{$id}}" >{{ $label }}</label>
    <select 
    id="{{ $id }}" 
    name="{{ $name }}" 
    {{ $attributes->class(['form-control','is-invalid'=>$errors->has($name)]) }}

    >
        <option value="">No parent</option>


        @foreach ($options as $value=>$text)
            <option value="{{ $value }}" @if ($value == old($name, $selected)) selected @endif>{{ $text }}
            </option>
        @endforeach
        {{-- @foreach ($parent_id as $parent)
            <option value="{{ $parent->id }}" @if ($parent->id == old('parent_id', $category->parent_id)) selected @endif>{{ $parent->name }}
            </option>
        @endforeach --}}
    </select>

    @error($name)
        <p class="text-danger">{{ $message }}</p>
    @enderror