@extends('layouts.dashboard')
@section('page-tittle',"Edit category")
@section('content')
    <div class="container">

        <form action="{{route( 'categories.update',[$category->id])}}" method="post">
            {{-- <input type="hidden" name = "_method" value = "put" > --}}
            @method('put')
            {{-- <input type="hidden" name = "_token" value="{{ csrf_token() }}"> --}}
            {{-- {{  echo csrf_field() }} --}}
            @csrf

          @include('categories._form')
        </form>
    </div>
    @endsection

