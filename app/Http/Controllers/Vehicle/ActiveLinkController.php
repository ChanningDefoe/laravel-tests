<?php

namespace App\Http\Controllers\Vehicle;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
// guzzle
use GuzzleHttp\Client;
// Models
use App\Models\Scrape\CdkLink;
use App\Models\Scrape\Vehicle;

class ActiveLinkController extends Controller
{
    /**
     * Check status of link to see if still active
     */
    public function check()
    {
        $date = Carbon::now()->toDateString();

        $link = CdkLink::where('visited', true)
            ->where('http_response_code', '200')
            ->whereDate('updated_at', '!=', $date)
            ->inRandomOrder()
            ->first();

        if (!$link->vdp_url) {
            abort(402, 'No more results from db.');
        }

        // Try using guzzle
        $client = new Client();
        // make try request and abort on exception
        try {
            $response = $client->request('GET', $link->vdp_url, array('allow_redirects' => false));
            // $response = $client->head($vehicle->url);
        } catch(RequestException $e) {
            // dd( Psr7\str($e->getRequest()) );
            abort(406, "Error while getting link.");
        }

        $http_response_code = $response->getStatusCode();

        // update model
        $link->http_response_code = $http_response_code;
        $link->updated_at = Carbon::now()->toDateTime();
        $link->save();

        if($http_response_code != 200) {
            $vehicle = Vehicle::where('url', $link->vdp_url)->first();
            $vehicle->deleted_at = now()->toDateTimeString();
            $vehicle->save();

            return response()->json([
                'link' => $link,
                'vehicle' => $vehicle,
            ]);
        }

        return response()->json($link);
    }
}
