<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{

    public function login(Request $request)
    {
        if(isset($request->email)){
            request()->validate([
                'email' => 'required',
                'password' => 'required',
            ]);

            $credentials=[
                'email' => $request->email,
                'password' => $request->password
            ];
        }
        else{
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $credentials=[
                'username' => $request->username,
                'password' => $request->password
            ];
        }


        if(!Auth::attempt($credentials)){
            return response()->json([
                'status' => 'Login Failed'
            ]);
        }else{
            $user = Auth::user();
            $userRole = $user->role()->first();

            if ($userRole) {
                $this->scope = $userRole->role;
            }

//            dd('$user', $user, '$userRole', $userRole, '$userRole->role', $userRole->role, '$this', $this, '$this->scope', $this->scope);

            $token = $user->createToken($user->username.'-'.now(), [$this->scope]);
//            dd('$token', $token);
            return response()->json([
//                'token' => Auth::user()->createToken('testToken')->accessToken
                'token' => $token->accessToken
            ]);
        }

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return User::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
//        dd('$request', $request, '$request->user', $request->user(), '$request->user->id', $request->user()->id);
        $id = (int)$id;
        $reqUserId = $request->user()->id;
//        dd('$reqUserId', $reqUserId, '$id', $id);
        if($reqUserId !== $id) {
            return abort(response()->json([
                'message' => 'Unauthorized'
            ], 403));
        }

        return User::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
