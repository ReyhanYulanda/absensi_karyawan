<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Http\Request;

class AbsensiExport implements FromView
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $absensi = Absensi::with('user')
            ->when($this->request->user_id, fn($q) => $q->where('user_id', $this->request->user_id))
            ->when($this->request->date_only, fn($q) => 
                $q->whereDate('time', $this->request->date_only))
            ->when(!$this->request->date_only && $this->request->start_date, fn($q) => 
                $q->whereDate('time', '>=', $this->request->start_date))
            ->when(!$this->request->date_only && $this->request->end_date, fn($q) => 
                $q->whereDate('time', '<=', $this->request->end_date))
            ->when(!$this->request->date_only && !$this->request->start_date && !$this->request->end_date, fn($q) => 
                $q->whereDate('time', now()->timezone('Asia/Makassar')->toDateString()))
            ->latest()
            ->get();

        return view('admin.exportAbsensi', compact('absensi'));
    }
}
