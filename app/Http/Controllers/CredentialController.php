<?php

namespace App\Http\Controllers;

use App\Credential;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request, [
            'name' => 'required|max:255',
            'value' => 'required|max:255',
        ]);

        $credential = Credential::create($request->all());

        return response()->json([
            'credential' => $credential,
            'message'  => 'Credenziale creata con successo!'
        ], 200);
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
    public function update(Request $request, Credential $credential)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'value' => 'required|max:255'
        ]);

        $credential->name = request('name');
        $credential->value = request('value');
        $credential->save();

        return response()->json([
            'message' => 'Credenziale modificata con successo!'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Credential $credential)
    {
        $credential->delete();

        return response()->json([
            'message' => 'Credenziale cancellata con successo!'
        ], 200);
    }
}
