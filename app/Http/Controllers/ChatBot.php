<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Yaml\Yaml;
use Session;

class ChatBot extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $conversation_id = uniqid('conv_', false);
        $conversation = $request->data;

        $yaml = Yaml::dump($conversation);
        Storage::disk('local')->put('database/conversations/'.$conversation_id.'.yaml', $yaml);

        return $conversation_id;
            
    }

    /**
     * Display the specified resources.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request)
    {
        $holiday_data = Yaml::parse(Storage::disk('local')->get('database/holiday-data.yaml'));
        $suggested_destinations = [];

        foreach($holiday_data as $destination)
        {
            $temp_rating = strtolower($request->temp);
            $location = strtolower($request->location);
            $category = strtolower($request->category);

            if ($destination["TempRating"] == $temp_rating && $destination["Location"] == $location && $destination["Category"] == $category) {
                array_push($suggested_destinations, $destination);
            }
        }

        return $suggested_destinations;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id = null)
    {
        $conversation = $request->data;

        $yaml = Yaml::dump($conversation);
        Storage::disk('local')->put('database/conversations/'.$id.'.yaml', $yaml);

        return $conversation;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
    }
}