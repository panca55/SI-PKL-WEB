<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/department",
     *     summary="List semua jurusan",
     *     tags={"Admin/Department"},
     *     @OA\Response(response=200, description="List jurusan")
     * )
     */
    public function index()
    {
        $departments = Department::all();
        if (request()->wantsJson()) {
            return response()->json([
                'departments' => $departments
            ], 200);
        }
        return view('pages.admin.department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/department/create",
     *     summary="Form tambah jurusan",
     *     tags={"Admin/Department"},
     *     @OA\Response(response=200, description="Form jurusan")
     * )
     */
    public function create()
    {
        return view('pages.admin.department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/admin/department",
     *     summary="Tambah jurusan baru",
     *     tags={"Admin/Department"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="nama", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Jurusan ditambah")
     * )
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
        ]);

        Department::create($validatedData);
        if ($request->wantsJson()) {
            return response()->json([
                'validatedData' => $validatedData,
                'message' => 'Department berasil ditambah'
            ], 200);
        }
        return redirect()->route('admin/department.index');
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/department/{id}",
     *     summary="Detail jurusan",
     *     tags={"Admin/Department"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detail jurusan")
     * )
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        if (request()->wantsJson()) {
            return response()->json([
                'department' => $department,
            ], 200);
        }
        return view('pages.admin.department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $department->update([
            'nama' => $request->input('nama'),
        ]);
        if ($request->wantsJson()) {
            return response()->json([
                'department' => $department,
            ], 200);
        }
        return redirect()->route('admin/department.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        if (request()->wantsJson()) {
            return response()->json([
                'department' => $department,
                'message' => 'Department berhasil dihapus',
            ], 200);
        }
        return redirect()->route('admin/department.index');
    }
}
