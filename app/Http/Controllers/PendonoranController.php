<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendonoran;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class PendonoranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Pendonoran::all();
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
        $userExists = User::where('id', '=', $request->user_id)->first();
//        dd(isset($userExists));

        if(isset($userExists)){
            $validation = [
                'no_pendonoran'     => 'required|unique:App\Models\Pendonoran,no_pendonoran',
                'waktu_donor'       => 'required|date',    # should be dateTime
                'location'          => 'required',
                'user_id'           => 'required',
                'pendonoran_ke'     => 'required|numeric',
//                'petugas_periksa',
                'hemoglobin'        => 'required|numeric',
                'berat_badan'       => 'required|numeric',
                'tensi'             => 'required|regex:/[0-9]*\/[0-9]*/',
                'cc_diambil'        => 'required|numeric',
                'kembali_setelah'   => 'required|date',
            ];

            $validator = Validator::make($request->all(), $validation);

            if($validator->fails()){
                return response()->json([
                    $validator->messages()
                ]);
            }

            $pendonoran = new Pendonoran();
            $pendonoran->no_pendonoran = $request->no_pendonoran;
            $pendonoran->waktu_donor = $request->waktu_donor;
            $pendonoran->location = $request->location;
            $pendonoran->user_id = $request->user_id;
            $pendonoran->pendonoran_ke = $request->pendonoran_ke;
            $pendonoran->petugas_periksa = $request->petugas_periksa;
            $pendonoran->hemoglobin = $request->hemoglobin;
            $pendonoran->berat_badan = $request->berat_badan;
            $pendonoran->tensi = $request->tensi;
            $pendonoran->cc_diambil = $request->cc_diambil;
            $pendonoran->kembali_setelah = $request->kembali_setelah;
            $pendonoran->save();

            return response()->json([
                'status' => 'Insert pendonoran success!'
            ]);
        }
        else{
            return response()->json([
                'message' => 'User does not exist!'
            ]);
        }


//        return Pemeriksaan::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
