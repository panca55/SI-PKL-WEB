<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Corporation;
use App\Models\Instructor;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $instructors =
            Instructor::with('user' ,'corporation')->get();
        if (request()->wantsJson()) {
            return response()->json(['instructors' => $instructors], 200);
        }
        return view('pages.admin.instructor.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'INSTRUKTUR')->get();
        $corporations = Corporation::all();
        $genders = Instructor::GENDERS;
        return view('pages.admin.instructor.create', compact(['users', 'genders', 'corporations']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:255|unique:instructors',
            'jenis_kelamin' => 'required|in:' . implode(',', array_keys(Instructor::GENDERS)),
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $instructor = new Instructor;
        $instructor->user_id = $request->user_id;
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
            return response()->json(['instruktur' => $instructor, 'message' => 'Data Instruktur berhasil ditambahkan'], 200);
        }
        return redirect()->route('admin/instructor.index')->with('success', 'Data Instruktur berhasil ditambahkan.');
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
    public function edit($id)
    {
        $instructor = Instructor::findOrFail($id);
        $genders = Instructor::GENDERS;
        return view('pages.admin.instructor.edit', compact(['instructor', 'genders']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);

        $instructor->nip = $request->nip;
        $instructor->nama = $request->nama;
        $instructor->jenis_kelamin = $request->jenis_kelamin;
        $instructor->tanggal_lahir = $request->tanggal_lahir;
        $instructor->tempat_lahir = $request->tempat_lahir;
        $instructor->alamat = $request->alamat;
        $instructor->hp = $request->hp;

        if ($request->hasFile('foto')) {
            if ($instructor->foto) {
                Storage::delete($instructor->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $instructor->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/instructors-images', $filename);
            $instructor->foto = $filename;
        } else {
            $instructor->foto = $request->oldImage;
        }
        $instructor->save();
        if ($request->wantsJson()) {
            return response()->json(['id' => $id, 'instruktur' => $instructor, 'message' => 'Data instruktur berhasil diperbarui.'], 200);
        }
        return redirect()->route('admin/instructor.index')->with('success', 'Data instruktur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Instructor $instructor)
    {
        if ($instructor->image) {
            Storage::delete($instructor->image);
        }

        $instructor->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Data Instrukur berhasil dihapus'], 200);
        }
        return redirect()->route('admin/instructor.index')->with('success', 'Data instruktur berhasil dihapus.');
    }
}
