

    @extends('layouts.dashboard')
@section('page-tittle')
    <div class="container">
        <h1 class="mb-3">{{ $title }}
            <small><a href="{{ route('categories.create') }}">Create</a></small>
        </h1>

    @endsection


        @section('content')
        <x-flash-message />
         {{-- @if ($flashMassage)
        <div class="alert alert-success">
            {{$flashMassage}}
        </div>
        @endif --}}

        <div class="table-responsive">
            <table class = "table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent Id</th>
                        <th>Created At</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        </a>
                        <td>{{ $category->id }}</td>
                        <td><a href="{{ route('categories.show',['category'=>$category->id]) }}">{{ $category->name }}</a></td>
                        <td>{{ $category->slug }}</td>
                        <td>{{ $category->parent_name }}</td>
                        <td>{{ $category->created_at }}</td>
                        <td><a href="{{ route('categories.edit',['category'=> $category->id]) }}" class = "btn btn-sm btn-dark">Edit</a></td>
                        <td><form action="{{ route('categories.destroy', $category->id) }}" method="post" >
                            @csrf
                            @method('delete')
                            <button class="btn btn-sm btn-danger" >Delete</button>
                        </form></td>
                    </tr>
                    @endforeach
                </tbody>
        </div>
    </div>
    </table>
    {{ $categories->links() }}
    @endsection
