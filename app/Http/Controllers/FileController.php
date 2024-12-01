<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Handle profile image upload.
     */
    public function uploadImage(Request $request, string $type)
    {
        $file = $request->file('file');
        $imageName = $file->hashName();

        $file->move(public_path("images/$type"), $imageName);

        return $imageName;
    }
}