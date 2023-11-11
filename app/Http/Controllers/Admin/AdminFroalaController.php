<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \stdClass;
use Illuminate\Support\Facades\Storage;

class AdminFroalaController extends Controller
{
    public function saveImage( Request $request ) {
        $path = public_path($request->path);
        !is_dir($path) &&
            mkdir($path, 0777, true);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move($path, $imageName);

        $response = new StdClass;
        $response->link = "/{$request->path}{$imageName}";

        return stripslashes(json_encode($response));
    }

    public function deleteImage( Request $request ) {
        if( \File::exists(public_path($request->image)) ) {

            \File::delete(public_path($request->image));

        }
    }
}
