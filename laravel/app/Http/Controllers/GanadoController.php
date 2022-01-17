<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ganado;
class GanadoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $ganado = Ganado::all();
        return response()->json( $ganado );
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $ganado = DB::table('ganados')
        ->select('ganados.id','ganados.name','ganados.crotal')
        ->where('ganados.ganaderia_id', '=' , $id)
        ->get();
        // ->first();
        // $ganado = Ganado::all();
        // ->where('ganados.ganaderia_id', '=' , $id);
        return response()->json($ganado);
    }

       /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // return response()->json( [ 'name','email' => Ganaderia::find($id) ] );
        $ganado = DB::table('ganados')
        ->select('ganados.id', 'ganados.name', 'ganados.crotal','ganados.costillar','ganados.raza','ganados.ganaderia_id')
        ->where('ganados.id', '=', $id)
        ->first();
        return response()->json( $ganado );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name'             => 'required|min:1|max:64',
            'crotal'           => 'required|max:1024',
            'costillar'        => 'required|min:10|max:11',
            'raza'             => 'required|max:1024',
            'ganaderia_id'     => 'required|min:1|max:64',
        ]);
        $user = auth()->userOrFail();
        $ganados = new Ganado();
        $ganados->name     = $request->input('name');
        $ganados->crotal     = $request->input('crotal');
        $ganados->costillar     = $request->input('costillar');
        $ganados->raza     = $request->input('raza');
        $ganados->ganaderia_id     = $request->input('ganaderia_id');
        // $note->users_id = $user->id;
        $ganados->save();
        return response()->json( ['status' => 'success'] );
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
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'crotal'      => 'required|min:1|max:256',
            'costillar'        => 'required|min:10|max:11',
            'raza'             => 'required|max:1024',
        ]);
        $ganado = Ganado::find($id);
        $ganado->name       = $request->input('name');
        $ganado->crotal      = $request->input('crotal');
        $ganado->costillar      = $request->input('costillar');
        $ganado->raza      = $request->input('raza');
        $ganado->save();
       

        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ganado = Ganado::find($id);
        if($ganado){
            $ganado->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
