@extends('layouts.main')
@section('title')
    edit workspace
@endsection

@section('content')
    <div style="padding-top: 100px"></div>
    <div class="section" style="max-width: 1000px;margin: 0 auto">
        <div class="card shadow-sm border p-4  mt-5">
            <h2>Edit Workspace</h2>
            <form method="POST" action="{{route('storeWorkSpace',$workspace->id)}}">
                @csrf
                @method('PUT')
                <div class="form-floating py-3">
                    <input class="form-control" type="text" name="name" id="name" value="{{$workspace->name}}">
                    <label for="name">Name</label>
                    @error('name')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <div class="form-floating py-3">
                    <input class="form-control" type="text" name="description" id="description"
                           value="{{$workspace->description}}">
                    <label for="description">Description</label>
                    @error('description')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <button class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection
