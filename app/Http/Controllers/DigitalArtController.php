<?php

namespace App\Http\Controllers;

use App\Models\DigitalArt;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
class DigitalArtController extends Controller
{
    //
    public function download(Request $request, $id){
        $DAdata = DigitalArt::findOrFail($id);
        $imageUrl = $DAdata->path;

        $path = parse_url($imageUrl, PHP_URL_PATH); // Get path component from URL

        $extension = pathinfo($path, PATHINFO_EXTENSION);

        $filename = bin2hex(random_bytes(4));
        if( $request->has('filename') ){
            $filename = $request->input('filename');
        }

        $filename .= '.'.$extension;
        try {
            $client = new Client();
            $response = $client->get($imageUrl, ['stream' => true]);
            $body = $response->getBody();

            return response()->stream(
                function () use ($body) {
                    while (!$body->eof()) {
                        echo $body->read(1024);
                    }
                },
                200,
                [
                    'Content-Type' => $response->getHeaderLine('content-type'),
                    'Content-Disposition' => "inline; filename={$filename}"
                ]
            );
        } catch (\Exception $e) {
            // Handle exception, e.g., log it, return a placeholder image, etc.
            abort(500, 'Error fetching the image');
        }
    }
}
