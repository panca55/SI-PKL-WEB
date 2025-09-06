<?php

namespace App\Http\Controllers\Corporation;

use App\Models\User;
use App\Models\Instructor;
use App\Models\Internship;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Corporation::where('user_id', $user->id)->firstOrFail();
        if(request()->wantsJson()){
            return response()->json(['profile'=>$profile]);
        }
        return view('pages.corporation.profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $days = Corporation::DAYS;
        return view('pages.corporation.profile.create', compact('days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $corporation = new Corporation;
        $corporation->user_id = $user->id;
        $corporation->nama = $request->nama;
        $corporation->slug = $request->slug;
        $corporation->quota = $request->quota;
        $corporation->mulai_hari_kerja = $request->mulai_hari_kerja;
        $corporation->akhir_hari_kerja = $request->akhir_hari_kerja;
        $corporation->jam_mulai = $request->jam_mulai;
        $corporation->jam_berakhir = $request->jam_berakhir;
        $corporation->alamat = $request->alamat;
        $corporation->hp = $request->hp;
        $corporation->logo = $request->logo;
        $corporation->email_perusahaan = $request->email_perusahaan;
        $corporation->website = $request->website;
        $corporation->instagram = $request->instagram;
        $corporation->tiktok = $request->tiktok;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $corporation->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/corporations-logos', $filename);
            $corporation->logo = $filename;
        }

        $corporation->save();
        if($request->wantsJson()){
            return response()->json(['message' => 'Data perusahaan berhasil disimpan','corporate'=>$corporation]);
        }
        return redirect()->route('corporation/dashboard.index')->with('success', 'Data Perusahaan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $profile = Corporation::where('user_id', $user->id)->firstOrFail();
        $days = Corporation::DAYS;
        // dd($profile);
        return view('pages.corporation.profile.edit', compact(['user', 'profile', 'days']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        // Validasi input
        $request->validate([
            'username' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto' => 'image|file|max:2048',
        ]);

        // Update data user
        $user->name = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update data Perusahaan
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();
        $corporation->nama = $request->nama;
        $corporation->slug = $request->slug;
        $corporation->alamat = $request->alamat;
        $corporation->quota = $request->quota;
        $corporation->mulai_hari_kerja = $request->mulai_hari_kerja;
        $corporation->akhir_hari_kerja = $request->akhir_hari_kerja;
        $corporation->jam_mulai = $request->jam_mulai;
        $corporation->jam_berakhir = $request->jam_berakhir;
        $corporation->deskripsi = $request->deskripsi;
        $corporation->email_perusahaan = $request->email_perusahaan;
        $corporation->website = $request->website;
        $corporation->instagram = $request->instagram;
        $corporation->tiktok = $request->tiktok;

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($corporation->logo) {
                Storage::delete('public/corporations-logos/' . $corporation->logo);
            }

            // Store the new logo
            $file = $request->file('logo');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $corporation->nama);
            $filename = $cleanName . '_logo_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/corporations-logos', $filename);
            $corporation->logo = $filename;
        } elseif ($request->oldLogo) {
            // If no new logo is uploaded, keep the old one
            $corporation->logo = $request->oldLogo;
        }

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($corporation->foto) {
                Storage::delete('public/corporations-images/' . $corporation->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $corporation->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/corporations-images', $filename);
            $corporation->foto = $filename;
        } elseif ($request->oldImage) {
            $corporation->foto = $request->oldImage;
        }
        // dd($request);
        $corporation->save();
        if($request->wantsJson()){
            return response()->json(['message' => 'Data perusahaan berhasil disimpan']);
        }
        return redirect()->route('corporation/profile.index')->with('success', 'Profile berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Corporation::class, 'slug', $request->nama);
        return response()->json(['slug' => $slug]);
    }
}
