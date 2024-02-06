@extends('layouts.main')
@section('title')
    homepage
@endsection

@section('content')
    <div style="padding-top: 100px"></div>
    <div style="max-width: 950px;margin: 0 auto">
        <div class="d-flex justify-content-sm-between align-items-center">
            <a style="color: #0d6efd" href="/homepage">
                <h1 style="text-align: center">Workspace - {{$workspace->name}}</h1>
            </a>
            <a href="{{route('editWorkSpace',$workspace->id)}}">
                <button class="btn btn-primary">
                    Edit Workspace
                </button>
            </a>
        </div>
        <h1 style="text-align: center" class="mt-5">Tokens of workspace</h1>
        <table class="table border p-3  shadow-sm mt-5" style="width: 100%!important;">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Token</th>
                <th>Deactivated at</th>
                <th>Created at</th>
            </tr>
            @if(count($tokens) >= 1)
                @foreach($tokens as $token)
                    <tr>
                        <td>{{$token->id}}</td>
                        <td>{{$token->name}}</td>
                        <td>
                            @if(\Illuminate\Support\Facades\Session::get('token_id') != $token->id)
                                Hidden
                            @else
                                {{$token->token}}
                            @endif
                        </td>
                        <td>
                            @if($token->deleted_at == '' || $token->deleted_at == null)
                                <form action="{{route('deleteToken',$token->id)}}" method="POST">
                                    @csrf
                                    @method('get')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            @else
                                {{\Illuminate\Support\Carbon::parse($token->deleted_at)->format('Y M D')}}
                            @endif
                        </td>
                        <td>{{\Illuminate\Support\Carbon::parse($token->created_at)->format('Y M D')}}</td>
                    </tr>
                @endforeach
            @else
                <tr>Empty</tr>
            @endif
        </table>
        <div class="card shadow-sm border p-4  mt-5">
            <h2>Creating Token</h2>
            <form method="POST" action="{{route('createToken',$workspace->id)}}">
                @csrf
                @method('POST')
                <div class="form-floating py-3">
                    <input class="form-control" type="text" name="name" id="name" value="{{old('name')}}">
                    <label for="name">Name</label>
                    @error('name')
                    <p class="text-danger">{{$message}}</p>
                    @enderror
                </div>
                <select class="form-select" name="tokentype_id">
                    <option selected disabled>Choose Tokentype for your Token</option>
                    @foreach($tokentype as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
                @error('tokentype_id')
                <p class="text-danger">{{$message}}</p>
                @enderror
                <button class="btn btn-primary mt-3" type="submit">Create</button>
            </form>
        </div>
        <h1 style="text-align: center" class="mt-5">Billing Quota</h1>
        <div class="card border shadow-sm p-3 w-50 mt-5">
            @if($quota->count() == 0)
                <h2 class="mb-2">Creating Quota</h2>
                <form method="POST" action="{{route('createQuota',$workspace->id)}}">
                    @csrf
                    @method('POST')
                    <div class="form-floating py-3">
                        <input class="form-control" type="text" name="limit" id="limit" value="{{old('limit')}}">
                        <label for="limit">Limit</label>
                        @error('limit')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button class="btn btn-success" type="submit">Create</button>
                </form>
            @else
                <h2>Your Quota</h2>
                <h4>Your current limit quota is {{$quota->limit}} $</h4>
                <p>Days to left - {{30 - now()->day}}</p>
                <form action="{{route('deleteQuota',$token->id)}}" method="POST">
                    @csrf
                    @method('get')
                    <button class="btn btn-danger">Delete</button>
                </form>
            @endif
        </div>
        <h1 style="text-align: center" class="mt-5">Billings</h1>
        <a href="{{route('billings',$workspace->id)}}">
            <button class="btn-success">
                Show bills
            </button>
        </a>
    </div>
@endsection
