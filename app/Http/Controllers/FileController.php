<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Handle image upload.
     */
    public function uploadImage(Request $request, string $type, ?string $oldImage = null): string
    {
        $file = $request->file('file');
        $imageName = $file->hashName();

        if ($oldImage) {
            unlink(public_path("images/$type/$oldImage"));
        }

        $file->move(public_path("images/$type"), $imageName);

        return $imageName;
    }
}