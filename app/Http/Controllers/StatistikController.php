<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\BukuTamu;
use Illuminate\Http\Request;

class StatistikController extends Controller
{
    public function index()
    {
        $totalTamu = BukuTamu::count();
        $tamuHariIni = BukuTamu::whereDate('created_at', Carbon::today())->count();
        $tamuMingguIni = BukuTamu::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $tamuBulanIni = BukuTamu::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
            
        $recentTamu = BukuTamu::latest()
            ->take(10)
            ->get();

        return view('admin.statistik', compact(
            'totalTamu',
            'tamuHariIni',
            'tamuMingguIni',
            'tamuBulanIni',
            'recentTamu'
        ));
    }

    public function filterDate(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $tamu = BukuTamu::whereBetween('created_at', [$startDate." 00:00:00", $endDate." 23:59:59"])
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'tamu' => $tamu
        ]);
    }

    public function filter(Request $request)
    {
        $status = $request->status;
        
        $query = BukuTamu::query();
        
        if ($status) {
            $query->where('status', $status);
        }
        
        $tamu = $query->latest()->get();
        
        return response()->json([
            'success' => true,
            'tamu' => $tamu
        ]);
    }

    public function detail($id)
    {
        $tamu = BukuTamu::findOrFail($id);
        return view('admin.tamu.detail', compact('tamu'));
    }

    public function print($id)
    {
        $tamu = BukuTamu::findOrFail($id);
        return view('admin.tamu.print', compact('tamu'));
    }

    public function export()
    {
        return back()->with('error', 'Fitur export akan segera tersedia!');
    }
}
