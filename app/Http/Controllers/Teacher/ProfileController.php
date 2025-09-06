<?php

namespace App\Http\Controllers\Teacher;

use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard()
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        if (!$teacher) {
            return redirect()->route('teacher/profile.create')->with('message', 'Silakan lengkapi data diri Anda.');
        }
        if (request()->wantsJson()) {
            return response()->json([
                'user' => $user,
                'teacher' => $teacher,
            ]);
        }
        return view('pages.teacher.dashboard');
    }

    public function index()
    {
        $user = Auth::user();
        $profile = Teacher::where('user_id', $user->id)->firstOrFail();
        if (request()->wantsJson()) {
            return response()->json([
                'teacher' => $profile,
            ]);
        }
        return view('pages.teacher.profile.index', compact('profile'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genders = Teacher::GENDERS;
        $golonganPNS = [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];
        return view('pages.teacher.profile.create', compact('genders', 'golonganPNS'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pns,non_pns',
            'nip' => 'nullable|required_if:status,pns|string|max:20|unique:teachers,nip',
            'golongan' => 'nullable|required_if:status,pns|string',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:' . implode(',', array_keys(Teacher::GENDERS)),
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'hp' => 'required|string|max:13',
            'bidang_studi' => 'required|string|max:255',
            'pendidikan_terakhir' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Tambahkan user_id ke data yang akan disimpan
        $validatedData['user_id'] = Auth::id();

        // Hapus field yang tidak ada di database jika status bukan PNS
        if ($validatedData['status'] === 'non_pns') {
            unset($validatedData['nip'], $validatedData['golongan']);
        }

        // Hapus field status karena tidak ada di model Teacher
        unset($validatedData['status']);

        // Simpan data guru
        $teacher = Teacher::create($validatedData);

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $teacher->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/teachers-images', $filename);
            $teacher->foto = $filename;
            $teacher->save();
        }
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data guru berhasil disimpan']);
        }

        // Redirect dengan pesan sukses
        return redirect()->route('teacher/profile.index')->with('success', 'Data anda berhasil disimpan.');
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
        $profile = Teacher::where('user_id', $user->id)->firstOrFail();
        $genders = Teacher::GENDERS;
        $golonganPNS = [
            'I/a',
            'I/b',
            'I/c',
            'I/d',
            'II/a',
            'II/b',
            'II/c',
            'II/d',
            'III/a',
            'III/b',
            'III/c',
            'III/d',
            'IV/a',
            'IV/b',
            'IV/c',
            'IV/d',
            'IV/e'
        ];
        return view('pages.teacher.profile.edit', compact(['user', 'profile', 'genders', 'golonganPNS']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);  // langsung cari teacher
        $user = $teacher->user; // relasi ke user

        // Validasi
        $validationRules = [
            'username' => 'sometimes|string|max:255|unique:users,name,' . $user->id,
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|file|max:2048',
        ];

        if ($request->filled('password')) {
            $validationRules['password'] = 'string|min:8|confirmed';
        }
        $request->validate($validationRules);

        // Update user hanya jika dikirim
        if ($request->filled('username')) $user->name = $request->username;
        if ($request->filled('email')) $user->email = $request->email;
        if ($request->filled('password')) $user->password = Hash::make($request->password);
        $user->save();

        // Update teacher - langsung assign untuk debugging
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        // Debug: Log semua data sebelum assignment
        Log::info('=== DEBUG TEACHER UPDATE ===', [
            'request_all' => $request->all(),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'teacher_before' => $teacher->toArray(),
        ]);

        // Debug: Log setiap field secara individual
        Log::info('Individual field values:', [
            'nip' => $request->nip,
            'nama' => $request->nama,
            'nama_is_null' => is_null($request->nama),
            'nama_is_empty' => empty($request->nama),
            'nama_length' => strlen($request->nama ?? ''),
            'golongan' => $request->golongan,
            'bidang_studi' => $request->bidang_studi,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jabatan' => $request->jabatan,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tempat_lahir' => $request->tempat_lahir,
            'alamat' => $request->alamat,
            'hp' => $request->hp,
        ]);

        // Assignment langsung
        $teacher->nip = $request->input('nip');
        $teacher->nama = $request->input('nama');
        $teacher->golongan = $request->input('golongan');
        $teacher->bidang_studi = $request->input('bidang_studi');
        $teacher->pendidikan_terakhir = $request->input('pendidikan_terakhir');
        $teacher->jabatan = $request->input('jabatan');
        $teacher->jenis_kelamin = $request->input('jenis_kelamin');
        $teacher->tanggal_lahir = $request->input('tanggal_lahir');
        $teacher->tempat_lahir = $request->input('tempat_lahir');
        $teacher->alamat = $request->input('alamat');
        $teacher->hp = $request->input('hp');


        // Debug: Log data setelah assignment tapi sebelum save
        Log::info('Teacher data after assignment (before save):', [
            'teacher_after_assignment' => $teacher->toArray(),
            'teacher_dirty' => $teacher->getDirty(),
        ]);

        // Handle foto upload (seperti sudah kamu buat)
        if ($request->hasFile('foto')) {
            if ($teacher->foto) {
                Storage::delete('public/teachers-images/' . $teacher->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $teacher->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/teachers-images', $filename);
            $teacher->foto = $filename;
        } elseif ($request->has('oldImage')) {
            $teacher->foto = $request->oldImage;
        }
        $teacher->save();

        return response()->json(['message' => 'Data guru berhasil diupdate']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
