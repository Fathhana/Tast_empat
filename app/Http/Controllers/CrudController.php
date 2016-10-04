<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Crud;
use App\Http\Requests;
use App\Http\Requests\Crud\StoreRequest;
use App\Http\Requests\Crud\UpdateRequest;
use Validator, Response;
use Illuminate\Support\Facades\Input;


class CrudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cruds = Crud::all();
        return view('index', compact('cruds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        // $rules = array (
        //         'nama' => 'required' 
        // );
        // $validator = Validator::make ( Input::all (), $rules );
        // if ($validator->fails ())
        //     return Response::json ( array (
                    
        //             'errors' => $validator->getMessageBag ()->toArray () 
        //     ) );

        // else {

            $cruds = new Crud();
            $cruds->nama = $request->nama;
            $cruds->phone = $request->phone;
            $cruds->save();
            return response ()->json ( $cruds );
        // }
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
        $cruds = Crud::findOrFail($id);
        return view('edit', compact('cruds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cruds = Crud::findOrFail($request->id);
        $cruds->nama = $request->nama;
        $cruds->phone = $request->phone;
        $cruds->save();
        // return redirect()->route('crud.index')->with('alert-success', 'Data Berhasil Diubah.');
        return response ()->json ( $cruds );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cruds = Crud::find($request->id);
        $cruds->delete();
        return response ()->json ( $cruds );
        // return redirect()->route('crud.index')->with('alert-success', 'Data Berhasil Dihapus.');
    }
}
