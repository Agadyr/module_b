@extends('layouts.main')
@section('title')
    register
@endsection

@section('content')
    <div style="padding-top: 180px"></div>
    <div class="section d-flex justify-content-center">
        <form action="{{route('register')}}" method="POST" class="table border shadow-sm p-3" style="max-width: 450px">
            @csrf
            @method('post')
            <h2 style="text-align: center">Register</h2>
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="name" id="name">
                <label for="name">Username</label>
                @error('name')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <div class="form-floating mt-3">
                <input type="text" class="form-control" name="password" id="password">
                <label for="password">Password</label>
                @error('password')
                <p class="text-danger">{{$message}}</p>
                @enderror
            </div>
            <button class="btn btn-primary mt-3" style="width: 100%">Register</button>
        </form>
    </div>
@endsection
