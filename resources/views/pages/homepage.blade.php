@extends('layouts.main')
@section('title')
    homepage
@endsection

@section('content')
    <div style="padding-top: 100px"></div>
    <div class="section" style="max-width: 1300px;margin: 0 auto">
        @if(count($workspaces) >= 1)
            <h1 style="margin-bottom: 30px;">My <span style="color: #0d6efd;text-align: center">Workspaces</span></h1>

        @else
            <h1 style="margin-bottom: 30px;">You don't have <span style="color: #0d6efd;"> workspaces</span></h1>
        @endif
        @foreach($workspaces as $item)
            <div class="card  border shadow-sm mb-3 p-3 col-4">
                <a href="{{route('showWorkSpace',$item->id)}}">
                    <h2>{{$item->name}}</h2>
                </a>
                <h4>{{$item->description}}</h4>
                <form action="{{route('deleteWorkSpace',$item->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Delete</button>
                </form>
            </div>
        @endforeach
        <div class="card shadow-sm border p-4 col-8 mt-5">
            <h2>Creating Workspace</h2>
            <form method="POST" action="{{route('createWorkSpace')}}">
                @csrf
                @method('POST')
                <div class="form-floating py-3">
                    <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                    <label for="name">Name</label>
                </div>
                <div class="form-floating py-3">
                    <input class="form-control" type="text" name="description" id="description"
                           value="{{old('description')}}">
                    <label for="description">Description</label>
                </div>
                <button class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
