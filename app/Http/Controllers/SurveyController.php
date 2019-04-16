<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Respondent;
use App\Notifications\NewRespondentGiven;

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

        $this->notify('Dave Block', 'dave@northcreek.ca', $respondent);
        $data['resp'] = $respondent;
        return view('about')->with($data);
    }

    public function viewResponse($id)
    {
        $respondent = Respondent::find($id);
        $data['resp'] = $respondent;
        $responses = Respondent::all();
        $inrange = array();
        foreach ($responses as $check)
        {
            if ($check != $respondent)
            {
                if ($respondent->inRange($check))
                {
                    $inrange[] = $check;
                }
            }
        }
        $data['responses'] = $responses;
        $data['responsesInRange'] = $inrange;
        $data = $this->get_isp_data($data);
        return view('response')->with($data);
    }

    public function viewAllResponses()
    {
        $data['responses'] = Respondent::all();
        $data = $this->get_isp_data($data);
        $data['location'] = $this->average_location($data['responses']);
        $data['lastResponse'] = Respondent::orderBy('created_at', 'desc')->first();
        return view('all')->with($data);
    }

    private function get_isp_data($data, $isp = null)
    {
        $data['isp'] = $isp;
        $isps = array();
        $count = array();
        foreach ($data['responses'] as $resp)
        {
            if (!array_key_exists($resp->isp, $count))
            {
                $count[$resp->isp] = 0;
                $isps[$resp->isp]  = 0;
            }
            $count[$resp->isp]++;
            $isps[$resp->isp] += $resp->score;
        }
        $data['isps'] = array_keys($isps);
        foreach($isps as $i => $total)
        {
            $average[$i] = number_format($total/$count[$i], 2);
        }
        $data['average'] = $average;
        $matching = array();
        if (in_array($isp, $data['isps']))
        {
            foreach ($data['responses'] as $resp)
            {
                if ($resp->isp == $isp)
                {
                    $matching[] = $resp;
                }
            }
        }
        $data['matching'] = $matching;
        $data['count'] = $count;
        return $data;
    }

    public function viewByIsp($isp = null)
    {
        $data['responses'] = Respondent::all();
        $data = $this->get_isp_data($data, $isp);
        $data['location'] = $this->average_location($data['matching']);
        return view('by_isp')->with($data);
    }

    public function survey()
    {
        $data['responses'] = Respondent::all();
        $data = $this->get_isp_data($data);
        return view('survey')->with($data);
    }

    public function about()
    {
        $data['responses'] = Respondent::all();
        $data = $this->get_isp_data($data);
        return view('about')->with($data);
    }

    public function average_location($responses)
    {
        $lat = 0;
        $long = 0;
        $count = 0;
        foreach($responses as $resp)
        {
            $lat  += floatval($resp->lat);
            $long += floatval($resp->long);
            $count++;
        }
        if ($count > 0)
        {
            $final_lat = $lat / $count;
            $final_long= $long/ $count;
        }
        else
        {
            $final_lat = 53.73;
            $final_long = -114.17;
        }
        return [$final_lat, $final_long];
    }

    public function notify($name, $email, $respondent)
    {
        $user = new \App\User([
            'name' => $name,
            'email' => $email
        ]);
        $user->notify(new NewRespondentGiven($respondent));
    }
}
