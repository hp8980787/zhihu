<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UploadCOntroller extends Controller
{
    protected $errno = 0;

    public function upload(Request $request)
    {
        $data = [];
        if ($request->file('images')->isValid()) {
            $path = $request->images->store('images', 'upload');

            $alt = $path;
            $url = config('filesystems.disks.upload.url');
            $url = $url . $path;
            $href = $url;

            $img = ['url' => $url, 'alt' => $alt, 'href' => $href];

            $data[] =(object)$img;
        } else {
            $this->errno = 1;

        }
        return response(['errno'=>$this->errno, 'data' => $data]);
    }
}
