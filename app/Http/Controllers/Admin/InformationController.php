<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Information;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v1;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $informations = Information::all();
        if (request()->wantsJson()) {
            return response()->json(['informations' => $informations], 200);
        }
        return view('pages.admin.information.index', compact('informations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.information.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'isi' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_berakhir' => 'required',
        ]);
        Information::create($validatedData);
        if (request()->wantsJson()) {
            return response()->json(['validatedData' => $validatedData], 200);
        }
        return redirect()->route('admin/information.index')->with('success', 'Infromasi berhasil ditambahkan.');
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
    public function edit(Information $information)
    {
        return view('pages.admin.information.edit', compact('information'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $information = Information::findOrFail($id);

        $information->nama = $request->input('nama');
        $information->isi = $request->input('isi');
        $information->tanggal_mulai = $request->input('tanggal_mulai');
        $information->tanggal_berakhir = $request->input('tanggal_berakhir');

        $information->save();
        if ($request->wantsJson()) {
            return response()->json(['id'=>$id,'information' => $information,'message'=>'Informasi Berhasil diperbaharui'], 200);
        }

        return redirect()->route('admin/information.index')->with('success', 'Informasi berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Information $information)
    {
        $information->delete();
        if (request()->wantsJson()) {
            return response()->json(['information' => $information], 200);
        }
        return redirect()->route('admin/information.index')->with('success', 'Informasi berhasil dihapus.');
    }
}
