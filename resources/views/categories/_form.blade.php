<div class="form-group">
    <x-form.input label="Category Name" id="name" name="name" class="form-control-lg"
        value="{{ $category->name }}" />
</div>
<div class="form-group">
    <x-form.input label="Category slug" id="slug" name="slug" class="form-control-lg"
        value="{{ $category->slug }}" />
</div>
<div class="form-group">


    <label for="description">Description</label>
    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
    @error('description')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>
<div class="form-group">
    <x-form.select label="Parent" id="parent_id" name="parent_id" :selected="$category->parent_id" :options="$parents->pluck('name','id')->toArray()" />
</div>
<div class="form-group">
    <x-form.input label="Art file" id="art_file" name="art_file" type="file" value="{{ $category->art_file }}" />

</div>
<div class="form-group">
    <button class="btn btn-primary"> Save </button>
</div>
