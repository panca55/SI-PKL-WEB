<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Mayor;
use Illuminate\Http\Request;

class MayorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mayors = Mayor::with('department')->get();
        if (request()->wantsJson()) 
        {
            return response()->json(['mayors' => $mayors], 200);
        }
        return view('pages.admin.mayor.index', compact('mayors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('pages.admin.mayor.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'department_id' => 'required',
            'nama' => 'required',
        ]);
        Mayor::create($validatedData);
        if (request()->wantsJson()) {
            return response()->json(['validatedData' => $validatedData], 200);
        }
        return redirect()->route('admin/mayor.index');
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
        $mayor = Mayor::findOrFail($id);
        $departments = Department::all();
        return view('pages.admin.mayor.edit', compact('mayor', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mayor $mayor)
    {
        $mayor->update([
            'deparment_id' => $request->input('deparment_id'),
            'nama' => $request->input('nama'),
        ]);
        if ($request->wantsJson()) {
            return response()->json(['mayor' => $mayor,'message'=>'Data berhasil diperbarui'], 200);
        }
        return redirect()->route('admin/mayor.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mayor $mayor)
    {
        $mayor->delete();
        if (request()->wantsJson()) {
            return response()->json(['mayor' => $mayor,'message'=>'Data berhasil dihapus'], 200);
        }
        return redirect()->route('admin/mayor.index');
    }
}
