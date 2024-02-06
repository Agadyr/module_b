<?php

namespace App\Http\Controllers;

use App\Models\Billings;
use App\Models\Quota;
use App\Models\Token;
use App\Models\Tokentype;
use App\Models\User;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    public function loginpage()
    {
        return view('pages.login');
    }

    public function registerpage()
    {
        return view('pages.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:users',
            'password' => 'required'
        ]);
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        Auth::login($user);
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return redirect()->back()->withErrors('Something went wrong please try again');
    }


    public function login(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|exists:users',
            'password' => 'required'
        ]);
        if (Auth::attempt($data)) {
            return redirect()->route('homepage');
        }
        return redirect()->back()->with(['Something went wrong please try again']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('register');
    }

    public function homepage(Request $request)
    {

        $workspaces = \auth()->user()->workspaces;
        return view('pages.homepage', compact('workspaces'));
    }

    public function deleteWorkSpace(Workspace $workspace)
    {
        $workspace->delete();
        return redirect()->back();
    }

    public function createWorkSpace(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $data['user_id'] = \auth()->user()->id;

        Workspace::create($data);

        return redirect()->back();
    }

    public function showWorkSpace(Workspace $workspace)
    {
        $tokentype = Tokentype::all();
        $tokens = $workspace->tokens;
        $quota = $workspace->quota();

        return view('pages.show', compact('workspace', 'tokens', 'tokentype', 'quota'));
    }

    public function createToken(Request $request, Workspace $workspace)
    {
        $data = $request->validate([
            'name' => 'required',
            'tokentype_id' => 'required'
        ]);
        $data['workspace_id'] = $workspace->id;
        $data['token'] = Str::random(40);
        $token = Token::create($data);
        return redirect()->back()->with('token_id', $token->id);

    }

    public function deleteToken(Token $token)
    {
        $token->delete();
        return redirect()->back();
    }

    public function createQuota(Workspace $workspace, Request $request)
    {
        $data = $request->validate([
            'limit' => 'required',
        ]);
        $data['workspace_id'] = $workspace->id;

        Quota::create($data);
        return redirect()->back();
    }

    public function deleteQuota(Quota $quota)
    {
        $quota->delete();
        return redirect()->back();
    }

    public function editWorkSpace(Workspace $workspace)
    {
        return view('pages.eidt', compact('workspace'));
    }

    public function storeWorkSpace(Request $request, Workspace $workspace)
    {
        $data = $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
        $data['user_id'] = \auth()->user()->id;
        $workspace->update($data);
        return redirect()->route('homepage');
    }

    public function billings(Workspace $workspace,Request $request)
    {
        $tokens = $workspace->tokens;
        $quota = $workspace->quota();
        $selectedmonth = Carbon::parse($request->get('month'));
        $months = [];
        $billstokens = [];
        $totalcost = 0;

        for ($i = 0; $i < 12; $i++) {
            $new = now()->subtract('month', $i);
            array_push($months, $new);
        }
        foreach ($tokens as $token) {
            $bills = Billings::whereMonth('created_at',$selectedmonth->month)
            ->where('token_id',$token->id)->get();
            if ($bills->count() > 0) {
                $billstokens[] = [
                    'name'=>$token->name,
                    'tokentype'=>$token->tokentype->name,
                    'persec'=>$token->tokentype->persec,
                    'bills'=> $bills
                ];
            }

            foreach ($bills as $bill) {
                $totalcost += round($bill->time * $token->tokentype->persec,2);
            }
        }
        return view('pages.billings', compact('selectedmonth','months','quota','totalcost','billstokens'));
    }
}
