<?php

namespace App\Http\Controllers\Corporation;

use Carbon\Carbon;
use App\Models\JobMarket;
use App\Models\Corporation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class BursaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();
        $jobs = JobMarket::where('corporation_id', $corporation->id)->get();
        if(request()->wantsJson()){
            return response()->json(['jobs'=>$jobs]);
        }
        return view('pages.corporation.bursa.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $works = JobMarket::WORKS;
        return view('pages.corporation.bursa.create', compact('works'));
    }

    public function toggleActive(JobMarket $job)
    {
        // Mengubah status
        $job->status = !$job->status;
        $job->save();

        // Mengirimkan pesan sukses
        $message = $job->status ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('corporation/bursa.index')->with('success', "Lowongan berhasil $message.");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();
        $currentDate = Carbon::now()->toDateString();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = $currentDate . '_' . $corporation->nama . '.' . $extension;
            $path = $file->storeAs('public/foto-bursa-kerja', $filename);
        }
        $jobData = [
            'corporation_id' => $corporation->id,
            'judul' => $request->judul,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'persyaratan' => $request->persyaratan,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'lokasi' => $request->lokasi,
            'rentang_gaji' => $request->rentang_gaji,
            'batas_pengiriman' => $request->batas_pengiriman,
            'contact_email' => $request->contact_email,
            'foto' => $filename,
            'status' => true,
        ];

        JobMarket::create($jobData);
        if($request->wantsJson()){
            return response()->json(['message' =>'Lowongan berhasil disimpan']);
        }
        return redirect()->route('corporation/bursa.index')->with('success', 'Lowongan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $job = JobMarket::findOrFail($id);
        return view('pages.corporation.bursa.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $job = JobMarket::findOrFail($id);
        $works = JobMarket::WORKS;
        return view('pages.corporation.bursa.edit', compact('job', 'works'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $corporation = Corporation::where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'judul' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5120',
        ]);

        $job = JobMarket::findOrFail($id);

        // Cek apakah ada file gambar yang diupload
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = now()->format('Y-m-d') . '_' . $corporation->nama . '.' . $extension;
            $path = $file->storeAs('public/foto-bursa-kerja', $filename);

            if ($job->foto) {
                Storage::delete('public/foto-bursa-kerja/' . $job->foto);
            }
            $job->foto = $filename;
        }

        $job->judul = $request->input('judul');
        $job->slug = $request->input('slug');
        $job->deskripsi = $request->input('deskripsi');
        $job->persyaratan = $request->input('persyaratan');
        $job->jenis_pekerjaan = $request->input('jenis_pekerjaan');
        $job->rentang_gaji = $request->input('rentang_gaji');
        $job->batas_pengiriman = $request->input('batas_pengiriman');
        $job->contact_email = $request->input('contact_email');
        // Simpan perubahan ke database
        $job->save();
        if($request->wantsJson()){
            return response()->json(['message'=>'Lowongan berhasil diupdate','job'=>$job]);
        }

        return redirect()->route('corporation/bursa.index')->with('success', 'Lowongan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $job = JobMarket::findOrFail($id);

        if ($job->foto) {
            Storage::delete($job->foto);
        }

        $job->delete();
        if(request()->wantsJson()){
            return response()->json(['message'=>'Data lowongan berhasil dihapus']);
        }

        return redirect()->route('corporation/bursa.index')->with('success', 'Data Lowongan berhasil dihapus.');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(JobMarket::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }
}
