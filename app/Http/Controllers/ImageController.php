<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'image' => 'required|image|max:2048',
    ]);

    $path = $request->file('image')->store('public/images/backgroundImage');

    return back()->with('success', 'Image uploaded successfully');
}

public function delete($filename)
{
    Storage::delete('public/images/' . $filename);

    return back()->with('success', 'Image deleted successfully');
}
public function uploadBackground(Request $request)
{
    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // Define static filename
        $filename = 'background.png';

        // Destination path
        $destination = public_path('uploads');

        // Create folder if it doesn't exist
        if (!file_exists($destination)) {
            mkdir($destination, 0755, true);
        }

        // Move and overwrite existing file
        $file->move($destination, $filename);

        return back()->with('success', 'Background image uploaded as background.png successfully.');
    }

    return back()->with('error', 'No image uploaded.');
}

}