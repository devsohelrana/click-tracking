<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Click;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClickController extends Controller
{

    public function index()
    {
        $clicksData = Click::select('query', DB::raw('COUNT(*) as click_count'))
            ->groupBy('query')
            ->orderBy('click_count', 'desc')
            ->get();

        return view('show', compact('clicksData'));
    }

    public function click(Request $request)
    {
        $query = $request->input('q');

        // Generate a unique identifier for the link
        $cid = uniqid();

        // Get Session id
        $sid = Str::limit($request->session()->getId(), 7, '');

        // Create an instance of the Agent class
        $agent = new Agent();

        // Save the click data
        Click::create([
            'query' => $query,
            'cid' => $cid, // Storing the unique link ID
            'sid' => $sid, // Storing the session ID
            'ip_address' => $request->ip(), // Storing the IP address of the user
            'browser' => $agent->browser(), // Extract the browser name
        ]);

        // Redirect the user to the Google search URL with the query parameter and the unique link ID
        return redirect()->away("https://www.google.co.il/search?q=$query&sid=$sid");
    }
}
