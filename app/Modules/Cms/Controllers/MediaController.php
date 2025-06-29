<?php

namespace App\Modules\Cms\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller {

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $fileUrl = $file->store('media');
        return response()->json([
            'status' => 'success',
            'data' => $fileUrl
        ]);
    }
}