<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Diagnostico;
class DiagnosticoController extends Controller
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
        $diagnostico = Diagnostico::all();
        return response()->json( $diagnostico );
    }
       /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $diagnostico = DB::table('diagnosticos')
        ->select('diagnosticos.id','diagnosticos.diagnostico','diagnosticos.tratamiento','diagnosticos.inicio','diagnosticos.final')
        ->where('diagnosticos.ganado_id', '=' , $id)
        ->get();
        // ->first();
        // $diagnostico = Ganado::all();
        // ->where('ganados.ganaderia_id', '=' , $id);
        return response()->json($diagnostico);
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
        $diagnostico = DB::table('diagnosticos')
        ->select('diagnosticos.id', 'diagnosticos.diagnostico', 'diagnosticos.tratamiento','diagnosticos.inicio','diagnosticos.final')
        ->where('diagnosticos.id', '=', $id)
        ->first();
        return response()->json( $diagnostico );
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
            'diagnostico'             => 'required|min:1',
            'tratamiento'           => 'required|min:1',
            'inicio'        => 'required',
            'final'             => 'required',
            'ganado_id'     => 'required',
        ]);
        $user = auth()->userOrFail();
        $diagnosticos = new Diagnostico();
        $diagnosticos->diagnostico     = $request->input('diagnostico');
        $diagnosticos->tratamiento     = $request->input('tratamiento');
        $diagnosticos->inicio     = $request->input('inicio');
        $diagnosticos->final     = $request->input('final');
        $diagnosticos->ganado_id     = $request->input('ganado_id');
        // $note->users_id = $user->id;
        $diagnosticos->save();
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
            'diagnostico'       => 'required|min:1',
            'tratamiento'      => 'required|min:1'

        ]);
        $diagnostico = Diagnostico::find($id);
        $diagnostico->diagnostico       = $request->input('diagnostico');
        $diagnostico->tratamiento      = $request->input('tratamiento');
        $diagnostico->inicio            = $request->input('inicio'); 
        $diagnostico->final            = $request->input('final');
        $diagnostico->save();
       

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
        $diagnostico = Diagnostico::find($id);
        if($diagnostico){
            $diagnostico->delete();
        }
        return response()->json( ['status' => 'success'] );
    }

}
