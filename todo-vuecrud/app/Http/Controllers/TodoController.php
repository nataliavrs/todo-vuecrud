<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  GET TO-DOS BY THE LATEST ONE ORDER
    public function index()
    {
        return Todo::latest() -> get();
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

    // Create new todo
    public function store(Request $request)
    {
        // Validate request
        $this->validate($request,
            [
                'title' => 'required'
            ],
            [
                'title.required' => 'Hey, write something!'
            ]
        );

        Todo::create($request -> all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */

    //  Toggle to-do completed
    public function update(Request $request, $id)
    {   
        $todo = Todo::findOrFail($id);
        $todo -> update($request -> all());;
        $todo -> save();        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        //
    }
}
