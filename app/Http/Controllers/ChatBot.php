<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class ChatBot extends Controller
{
    public function __construct()
    {
        $this->is_started = false;
        $this->config = [
            "started" => $this->is_started
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request = null)
    {
        if (!$this->is_started) {
            $this->begin();
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request = null)
    {
        if ($request)
        {
            $name = $request->session()->get('name');
            dump($name);
        }

        return view('home', [
            "started" => $this->is_started,
            "replies" => [
                [
                    "sender" => 'bot',
                    "message" => 'Hi There'.(isset($name) ? ' '.$name : '').'!'
                ], 
                [
                    "sender" => 'user',
                    "message" => 'Hi.'
                ]
            ]
        ]);
    }

    /**
     * Begin Conversation.
     *
     * @return \Illuminate\Http\Response
     */
    public function begin()
    {
        $this->is_started = true;
        return $this->index();
    }

    /**
     * End Conversation.
     *
     * @return \Illuminate\Http\Response
     */
    public function end()
    {
        $this->is_started = false;
        return $this->index();
    }

    /**
     * Update Conversation.
     *
     * @return \Illuminate\Http\Response
     */
    public function reply(Request $request)
    {
        if (!$this->is_started)
        {
            $this->is_started = true;
        }

        $request->session()->put('name', $request->name);
        return $this->index($request);
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
