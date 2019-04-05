<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respondent;

class SurveyController extends Controller
{
    public function result(Request $request)
    {
        $respondent = Respondent::create([
            'name'  => $request->name,
            'email' => $request->email,
            'isp'   => $request->isp,
            'satisfaction' => $request->satisfaction,
            'lat'   => $request->lat,
            'long'  => $request->long
        ]);

        $data['name'] = $respondent->name;
        return view('about')->with($data);
    }
}
