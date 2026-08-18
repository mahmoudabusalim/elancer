
@extends('layouts.dashboard')
@section('page-tittle' , 'Create category' )


@section('content')

    <div class="container">
        {{-- @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>
        @endif --}}
        <form action="{{ Route('categories.store') }}" method="post">
            {{-- <input type="hidden" name = "_token" value="{{ csrf_token() }}"> --}}
            {{-- <?php echo csrf_field();?> --}}
            @csrf

            @include('categories._form')
        </form>
    </div>
    @endsection

