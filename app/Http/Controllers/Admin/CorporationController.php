<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CorporationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/admin/corporation",
     *     summary="List semua perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Response(response=200, description="List perusahaan")
     * )
     */
    public function index()
    {
        $corporations = Corporation::with('user')->get();
        if (request()->wantsJson()) {
            return response()->json(
                [
                    'corporations' => $corporations,
                ],
                200
            );
        }
        return view('pages.admin.corporation.index', compact('corporations'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * @OA\Get(
     *     path="/admin/corporation/create",
     *     summary="Form tambah perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Response(response=200, description="Form perusahaan")
     * )
     */
    public function create()
    {
        $users = User::where('role', 'PERUSAHAAN')->get();
        $days = Corporation::DAYS;
        if (request()->wantsJson()) {
            return response()->json([
                'users' => $users,
                'days' => $days
            ], 201);
        }
        return view('pages.admin.corporation.create', compact('users', 'days'));
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     * @OA\Post(
     *     path="/admin/corporation",
     *     summary="Tambah perusahaan baru",
     *     tags={"Admin/Corporation"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="user_id", type="integer"),
     *                 @OA\Property(property="nama", type="string"),
     *                 @OA\Property(property="foto", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Perusahaan ditambah")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $corporation = new Corporation;
        $corporation->user_id = $request->user_id;
        $corporation->nama = $request->nama;
        $corporation->slug = $request->slug;
        $corporation->quota = $request->quota;
        $corporation->mulai_hari_kerja = $request->mulai_hari_kerja;
        $corporation->akhir_hari_kerja = $request->akhir_hari_kerja;
        $corporation->jam_mulai = $request->jam_mulai;
        $corporation->jam_berakhir = $request->jam_berakhir;
        $corporation->alamat = $request->alamat;
        $corporation->hp = $request->hp;
        $corporation->foto = $request->foto;

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $corporation->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/corporations-images', $filename);
            $corporation->foto = $filename;
        }

        $corporation->save();
        if ($request->wantsJson()) {
            return response()->json([
                'corporations' => $corporation,
            ], 200);
        }

        return redirect()->route('admin/corporation.index')->with('success', 'Data Perusahaan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/corporation/{id}",
     *     summary="Detail perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Detail perusahaan")
     * )
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /**
     * @OA\Get(
     *     path="/admin/corporation/{id}/edit",
     *     summary="Form edit perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Form edit perusahaan")
     * )
     */
    public function edit($id)
    {
        $corporation = Corporation::findOrFail($id);
        $days = Corporation::DAYS;
        if (request()->wantsJson()) {
            return response()->json([
                'corporations' => $corporation,
                'days' => $days,
                'message' => 'Data berhasil diedit',
            ], 200);
        }
        return view('pages.admin.corporation.edit', compact('corporation', 'days'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * @OA\Put(
     *     path="/admin/corporation/{id}",
     *     summary="Update perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="nama", type="string"),
     *                 @OA\Property(property="foto", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=200, description="Perusahaan diupdate")
     * )
     */
    public function update(Request $request, $id)
    {
        $corporation = Corporation::findOrFail($id);

        $corporation->nama = $request->nama;
        $corporation->slug = $request->slug;
        $corporation->quota = $request->quota;
        $corporation->mulai_hari_kerja = $request->mulai_hari_kerja;
        $corporation->akhir_hari_kerja = $request->akhir_hari_kerja;
        $corporation->jam_mulai = $request->jam_mulai;
        $corporation->jam_berakhir = $request->jam_berakhir;
        $corporation->alamat = $request->alamat;
        $corporation->hp = $request->hp;
        $corporation->foto = $request->hp;

        if ($request->hasFile('foto')) {
            if ($corporation->foto) {
                Storage::delete($corporation->foto);
            }
            $file = $request->file('foto');
            $cleanName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $corporation->nama);
            $filename = $cleanName . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/corporations-images', $filename);
            $corporation->foto = $filename;
        } else {
            $corporation->foto = $request->oldImage;
        }
        $corporation->save();
        if ($request->wantsJson()) {
            return response()->json([
                'corporations' => $corporation,
                'message' => 'Data perusahaan berhasil diperbarui'
            ], 200);
        }

        return redirect()->route('admin/corporation.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     * @OA\Delete(
     *     path="/admin/corporation/{id}",
     *     summary="Hapus perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Perusahaan dihapus")
     * )
     */
    public function destroy(Corporation $corporation)
    {
        // Delete related records first to avoid foreign key constraints
        $corporation->instructor()->delete();
        $corporation->jobmarket()->delete();
        $corporation->internship()->delete();
        $corporation->feedback()->delete();

        if ($corporation->foto) {
            Storage::delete($corporation->foto);
        }

        Log::info('Deleting corporation: ' . $corporation->id);
        Log::info('Corporation exists: ' . $corporation->exists);
        try {
            $result = DB::table('corporations')->where('id', $corporation->id)->delete();
            Log::info('Delete result: ' . $result);
        } catch (\Exception $e) {
            Log::error('Delete failed: ' . $e->getMessage());
            $result = false;
        }

        if (request()->wantsJson()) {
            return response()->json([
                'message' => 'Data perusahaan berhasil dihapus',
                'deleted' => $result,
            ], 200);
        }
        return redirect()->route('admin/corporation.index')->with('success', 'Data perusahaan berhasil dihapus.');
    }

    /**
     * @OA\Get(
     *     path="/corporation/checkSlug",
     *     summary="Cek slug perusahaan",
     *     tags={"Admin/Corporation"},
     *     @OA\Parameter(name="nama", in="query", required=true, @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="Slug perusahaan")
     * )
     */
    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Corporation::class, 'slug', $request->nama);
        if ($request->wantsJson()) {
            return response()->json([
                'Cek Slug' => $slug,
            ], 200);
        }
        return response()->json(['slug' => $slug]);
    }
}
