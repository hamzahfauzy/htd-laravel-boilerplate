<?php

namespace App\Modules\Cms\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Cms\Models\Media;
use Illuminate\Http\Request;

class MediaController extends Controller {

    public function upload(Request $request)
    {
        $file = $request->file('file');
        $data = $file->store('media');

        if($request->type == 'media')
        {
            $fileData = [
                'name' => $file->getClientOriginalName(),
                'filename' => $data,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ];

            $data = Media::create($fileData);
        }
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}