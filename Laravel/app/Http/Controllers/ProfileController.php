<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the form for adding profile photo.
     *
     * @return \Illuminate\View\View
     */
    public function addProfilePhoto()
    {
        return view('auth.add_photo');
    }

    /**
     * Store the profile photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProfilePhoto(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Ambil user yang sedang masuk
        $user = Auth::user();

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($user->image) {
                // Hapus gambar lama dari penyimpanan
                Storage::delete('public/images/' . $user->image);
            }

            // Simpan gambar baru
            $imagePath = $request->file('image')->store('public/images');
            $imageName = basename($imagePath);

            // Update kolom image pada model User
            $user->image = $imageName;
            $user->save();
        }

        return redirect()->route('home');
    }
}
