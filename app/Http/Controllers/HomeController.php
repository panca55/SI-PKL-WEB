<?php

namespace App\Http\Controllers;

use App\Models\Corporation;
use App\Models\Feedback;
use App\Models\JobMarket;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function mitra()
    {
        $corporations = Corporation::paginate(6);
        return view('pages.frontend.mitra.index', compact('corporations'));
    }


    public function detailPerusahaan($slug)
    {
        $corporation = Corporation::where('slug', $slug)->firstOrFail();
        $feedbacks = Feedback::where('corporation_id', $corporation->id)->get();
        return view('pages.frontend.mitra.detail-perusahaan', compact('corporation', 'feedbacks'));
    }

    public function bursaKerja()
    {
        $jobs = JobMarket::paginate(6);
        return view('pages.frontend.mitra.bursa', compact('jobs'));
    }

    public function detailBursa($slug)
    {
        $job = JobMarket::where('slug', $slug)->firstOrFail();
        return view('pages.frontend.mitra.detail-bursa', compact('job'));
    }
}
