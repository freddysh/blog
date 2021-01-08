<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        return view('user.index');
    }
    public function api_index()
    {
        //
        return User::get();
        // return Post::with(['user','categoria','imagenes'])->get();
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
        //
        $name=$request->name;
        $email=$request->email;
        $password=$request->password;
        $rol=$request->rol;

        $objeto=new User();
        $objeto->name=$name;
        $objeto->email=$email;
        $objeto->password=bcrypt($password);
        $objeto->password2=$password;
        $objeto->rol=$rol;
        $objeto->save();

        return response()->json(['status'=>'1']);
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
        $name=$request->name;
        $email=$request->email;
        $password=$request->password;
        $rol=$request->rol;

        $objeto= User::findorfail($id);
        $objeto->name=$name;
        $objeto->email=$email;
        $objeto->password=bcrypt($password);
        $objeto->password2=$password;
        $objeto->rol=$rol;
        $objeto->save();

        return response()->json(['status'=>'1']);
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

        $objeto= User::findorfail($id);
        $objeto->delete();
        return response()->json(['status'=>'1']);
    }
}
