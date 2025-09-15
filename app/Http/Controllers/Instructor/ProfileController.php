<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Student;
use App\Models\Internship;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Corporation;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        $user = Auth::user();
        $instructor = Instructor::where('user_id', $user->id)->first();

        if (!$instructor) {
            return redirect()->route('instructor/profile.create')->with('message', 'Silakan lengkapi data diri Anda.');
        }
        return view('pages.instructor.dashboard');
    }

    public function index()
    {
        $user = Auth::user();
        $profile = Instructor::where('user_id', $user->id)->firstOrFail();
        $profileData = $profile->toArray();
        $profileData = array_map(function ($value) {
            return $value === null ? 'Belum diisi' : $value;
        }, $profileData);
        if (request()->wantsJson()) {
            return response()->json([
                'profile' => $profileData,
            ]);
        }
        return view('pages.instructor.profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $corporations = Corporation::all();
        $genders = Instructor::GENDERS;
        return view('pages.instructor.profile.create', compact('genders', 'corporations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nip' => 'nullable|string|max:255|unique:instructors',
            'jenis_kelamin' => 'required|in:' . implode(',', array_keys(Instructor::GENDERS)),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $instructor = new Instructor;
        $instructor->user_id = $user->id;
        $instructor->corporation_id = $request->corporation_id;
        $instructor->nip = $request->nip;
        $instructor->nama = $request->nama;
        $instructor->jenis_kelamin = $request->jenis_kelamin;
        $instructor->tanggal_lahir = $request->tanggal_lahir;
        $instructor->tempat_lahir = $request->tempat_lahir;
        $instructor->alamat = $request->alamat;
        $instructor->hp = $request->hp;
        $instructor->foto = $request->foto;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $instructor->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/instructors-images', $filename);
            $instructor->foto = $filename;
        }

        $instructor->save();
        if ($request->wantsJson()) {
            return response()->json(['messafe' => 'Data Instruktur berhasil disimpan']);
        }
        return redirect()->route('instructor/profile.index')->with('success', 'Data Instruktur berhasil disimpan.');
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
        $profile = Instructor::where('user_id', $user->id)->firstOrFail();
        $genders = Instructor::GENDERS;
        return view('pages.instructor.profile.edit', compact(['user', 'profile', 'genders']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);
        $user = User::findOrFail($instructor->user_id);
        // Validasi input
        $request->validate([
            'username' => 'sometimes|string|max:255|unique:users,name,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'foto' => 'nullable|image|file|max:2048',
        ]);

        // Update data user
        $user->name = $request->username;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        // Update data student
        $instructor->nip = $request->nip;
        $instructor->nama = $request->nama;
        $instructor->jenis_kelamin = $request->jenis_kelamin;
        $instructor->tanggal_lahir = $request->tanggal_lahir;
        $instructor->tempat_lahir = $request->tempat_lahir;
        $instructor->alamat = $request->alamat;
        $instructor->hp = $request->hp;
        $instructor->foto = $request->foto;

        // Handle foto upload
        if ($request->hasFile('foto')) {
            if ($instructor->foto) {
                Storage::delete('public/instructors-images/' . $instructor->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $instructor->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/instructors-images', $filename);
            $instructor->foto = $filename;
        } elseif ($request->oldImage) {
            $instructor->foto = $request->oldImage;
        }

        $instructor->save();
        if ($request->wantsJson()) {
            return response()->json(['messafe' => 'Data Instruktur berhasil diperbarui']);
        }

        return redirect()->route('instructor/profile.index')->with('success', 'Profile berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
