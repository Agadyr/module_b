@extends('layouts.main')
@section('title')
    homepage
@endsection

@section('content')
    <div style="padding-top: 100px"></div>
    <div style="max-width: 950px;margin: 0 auto">
        <h1 style="text-align: center" class="mt-5">Billing Quotas</h1>
        <div class="d-flex justify-content-md-start col-8 gap-3">
            <h4>Choose Month:</h4>
            <form class="d-flex">
                <select name="month" class="form-select">
                    @foreach($months as $item)
                        <option value="{{$item}}">{{\Illuminate\Support\Carbon::parse($item)->format('Y M')}}</option>
                    @endforeach
                </select>
                <button class="btn btn-primary" style="margin-left: 10px;">Filter</button>
            </form>
        </div>
        <table class="table table-hover border p-5 shadow-sm mt-5" style="width: 100%!important;">
            <tr>
                <th class="w-50">Token</th>
                <th>Time</th>
                <th>Per.sec</th>
                <th>Total</th>
            </tr>
            @if(count($billstokens) <= 0)
                <tr>Empty Bills</tr>
            @else
                @foreach($billstokens as $token)
                    @for($i = 0;$i < $token['bills']->count();$i++)
                        <tr>
                            <td>
                                <h4>
                                    {{$token['name']}}
                                </h4>
                                <p class="p">
                                    {{$token['tokentype']}}
                                </p>
                            </td>
                            <td>
                                {{$token['bills'][$i]->time}}
                            </td>
                            <td>
                                {{$token['persec']}}
                            </td>
                            <td>
                                {{$token['bills'][$i]->time * $token['persec']}}
                            </td>
                        </tr>
                    @endfor
                @endforeach
            @endif
        </table>
        <div class="d-flex justify-content-sm-between">
            <h2>Total:</h2>
            <h4>
                @if($quota->limit < $totalcost)
                    <span>{{$quota->limit}}$/{{$totalcost}}
                    <h5 class="text-danger">Превышен Лимит</h5>
                    </span>

                @else
                    {{$quota->limit}}$/{{$totalcost}}
                @endif
            </h4>
        </div>
    </div>
@endsection
