<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\UsersImport;
use App\Models\Corporation;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function dashboard(Request $request)
    {
        $totalUsers = User::count();
        $totalCorporations = Corporation::count();
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $tahun_masuk = $request->input('tahun_masuk', date('Y'));
        $studentYears = Student::where('tahun_masuk', $tahun_masuk)->count();

        $students = Student::select('jenis_kelamin', DB::raw('count(*) as total'))
            ->where('tahun_masuk', $tahun_masuk)
            ->groupBy('jenis_kelamin')
            ->get();

        $tahun_masuk_list = Student::select('tahun_masuk')
            ->distinct()
            ->orderBy('tahun_masuk', 'asc')
            ->pluck('tahun_masuk');

        return view('pages.admin.dashboard', compact('totalUsers', 'totalCorporations', 'totalStudents', 'totalTeachers', 'students', 'tahun_masuk', 'tahun_masuk_list', 'studentYears'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls',
        ]);

        try {
            Excel::import(new UsersImport, $request->file('excel_file'));
            return redirect()->route('admin/user.index')->with('success', 'Users imported successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin/user.index')->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role !== '') {
            $query->where('role', $request->role);
        }

        $users = $query->get();
        if ($request->wantsJson()) {
            return response()->json(['users'=>$users], 200);
        }
        return view('pages.admin.user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = User::ROLES;
        if (request() -> wantsJson()){
            return response()->json(['roles' => $roles], 200);
        }
        return view('pages.admin.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function toggleActive(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id', // Pastikan user_id ada di tabel users
        ]);

        // Cari user berdasarkan user_id
        $user = User::find($validated['user_id']);

        // Mengubah status is_active
        $user->is_active = !$user->is_active;
        $user->save();

        // Menentukan status untuk notifikasi
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';

        // Jika request berasal dari API
        if ($request->wantsJson()) {
            return response()->json([
                'message' => "Pengguna berhasil $status.",
                'user' => $user,
            ], 200);
        }

        // Jika request berasal dari non-API (web)
        return redirect()->route('admin/user.index', ['role' => $request->role])
            ->with('success', "Pengguna berhasil $status.");
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:' . implode(',', array_keys(User::ROLES)),
            'password' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        User::create($validatedData);
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data user berhasil ditambahkan'], 200);
        }
        return redirect()->route('admin/user.index')->with('success', 'User berhasil ditambahkan.');
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
        $user = User::findOrFail($id);
        $roles = User::ROLES;
        return view('pages.admin.user.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:' . implode(',', array_keys(User::ROLES)),
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        if (empty($validatedData['password'])) {
            unset($validatedData['password']);
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);
        if ($request->wantsJson()) {
            return response()->json(['message' => 'Data user berhasil diupdate', 'user'=>$user], 200);
        }

        return redirect()->route('admin/user.index', ['role' => $request->query('role')])->with('success', 'User berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Data user berhasil dihapus'], 200);
        }
        return redirect()->route('admin/user.index');
    }
}
