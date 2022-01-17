<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Spatie\Permission\Models\Ganaderia;
use Illuminate\Support\Facades\DB;
use App\Models\Ganaderia;
class GanaderiaController extends Controller
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
        $ganaderias = Ganaderia::all();
        return response()->json( $ganaderias );
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $ganaderia = DB::table('ganaderias')
        ->select('ganaderias.name','ganaderias.email')
        ->where('ganaderias.id', '=' , $id)
        ->first();
        return response()->json($ganaderia);
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
        $ganaderia = DB::table('ganaderias')
        ->select('ganaderias.id', 'ganaderias.name', 'ganaderias.email')
        ->where('ganaderias.id', '=', $id)
        ->first();
        return response()->json( $ganaderia );
    }
    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
    {
        return response()->json( ['status' => 'success'] );  
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
            'email'           => 'required|max:1024',
        ]);
        $user = auth()->userOrFail();
        $ganaderias = new Ganaderia();
        $ganaderias->name     = $request->input('name');
        $ganaderias->email   = $request->input('email');
        // $note->users_id = $user->id;
        $ganaderias->save();
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
            'email'      => 'required|email|max:256'
        ]);
        $ganaderia = Ganaderia::find($id);
        $ganaderia->name       = $request->input('name');
        $ganaderia->email      = $request->input('email');
        $ganaderia->save();
       

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
        $ganaderia = Ganaderia::find($id);
        if($ganaderia){
            $ganaderia->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
 
}
