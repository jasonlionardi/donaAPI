<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function login(Request $request)
    {
        if(isset($request->email)){

            $validation = [
                'email' => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $validation);

            if($validator->fails()) {
                return response()->json([
                    'message' => 'Email or Password input failure'
                ]);
            }

//            request()->validate([
//                'email' => 'required',
//                'password' => 'required',
//            ]);

            $credentials=[
                'email' => $request->email,
                'password' => $request->password
            ];
        }
        else{

            $validation = [
                'username' => 'required',
                'password' => 'required',
            ];

            $validator = Validator::make($request->all(), $validation);

            if($validator->fails()) {
                return response()->json([
                    'message' => 'Username or Password input failure'
                ]);
            }

//            $request->validate([
//                'username' => 'required',
//                'password' => 'required',
//            ]);

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
    public function index(Request $request)
    {
        if($request->scope !== 'admin') {
            return abort(response()->json([
                'message' => 'Unauthorized'
            ], 403));
        }
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        FURTHER VALIDATION REQUIRED!!!
        $validation = [
            'no_regis_donor' => 'required',
            'name' => 'required',
            'username' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'blood_type' => 'required',
            'rhesus' => 'required',
            'email_verified_at' => 'required',
            'password' => 'required',
            'remember_token' => 'required',
        ];

        $validator = Validator::make($request->all(), $validation);

        if($validator->fails()) {
            return response()->json([
                'message' => 'All parameters must be filled!'
            ]);
        }

        if (User::where('email', '=', $request->email)->exists()) {
            return response()->json([
                'message' => 'Email is already in use!'
            ]);
        }
        else if (User::where('username', '=', $request->username)->exists()) {
            return response()->json([
                'message' => 'Username is already in use!'
            ]);
        }

//        $userData = [
//            'no_regis_donor' => $request->no_regis_donor,
//            'name' => $request->name,
//            'username' => $request->username,
//            'phone' => $request->phone,
//            'email' => $request->email,
//            'date_of_birth' => $request->date_of_birth,
//            'gender' => $request->gender,
//            'blood_type' => $request->blood_type,
//            'rhesus' => $request->rhesus,
//            'email_verified_at' => $request->email_verified_at,
//            'password' => $request->password,
//            'remember_token' => $request->remember_token,
//        ];

//        $userData = [
//            'no_regis_donor' => '123456789wertyu',
//            'name' => 'John Doe',
//            'username' => 'jdoe',
//            'phone' => '098765432',
//            'email' => 't@t.com',
//            'date_of_birth' => '2000-01-01',
//            'gender' => 'M',
//            'blood_type' => 'O',
//            'rhesus' => '+',
//            'email_verified_at' => now(),
//            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
//            'remember_token' => Str::random(10),
//        ];
//        dd('store request', $request->all(), 'user data', $userData);
//        return User::create($request->all());

        $user = new User();

//        $user->no_regis_donor = '123456789wertyu';
//        $user->name = 'John Doe';
//        $user->username = 'jdoe';
//        $user->phone = '098765432';
//        $user->email = 'tes@mail.com';
//        $user->date_of_birth = '2000-01-01';
//        $user->gender = 'M';
//        $user->blood_type = 'O';
//        $user->rhesus = '+';
//        $user->email_verified_at = now();
//        $user->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
//        $user->remember_token = Str::random(10);

        $user->no_regis_donor = $request->no_regis_donor;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->blood_type = $request->blood_type;
        $user->rhesus = $request->rhesus;
        $user->email_verified_at = $request->email_verified_at;
        $user->password = $request->password;
        $user->remember_token = $request->remember_token;

        $user->save();
//        dd('store request', $request->all(), 'user save', $user);

        return response()->json([
            'message' => 'New user created!'
        ]);
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
//        dd('check user role', $request->user(), $request->user()->scopes, $request->scope);
        if($reqUserId !== $id && $request->scope !== 'admin') {
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
