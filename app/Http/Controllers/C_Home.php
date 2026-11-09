<?php

namespace App\Http\Controllers;

use App\Models\M_Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class C_Home extends Controller
{
    private M_Invoice $M_Invoice;

    public function __construct()
    {
        $this->M_Invoice = new M_Invoice();
    }

    public function index(): View
    {
        return view('v_home', [
            'totalDosen' => DB::table('tb_dosen')->count(),
            'totalMahasiswa' => DB::table('tb_mahasiswa')->count(),
            'totalUsers' => DB::table('users')->count(),
            'totalInvoice' => DB::table('tb_invoice')->count(),
        ]);
    }

    public function about(): View
    {
        return view('v_about');
    }

    public function invoice(Request $request): View
    {
        $invoices = $this->M_Invoice->allInvoices();
        $selectedNo = (string) $request->query('no', '');
        $invoice = $selectedNo !== ''
            ? $this->M_Invoice->findInvoice($selectedNo)
            : $invoices->first();

        if ($selectedNo !== '' && ! $invoice) {
            abort(404);
        }

        return view('v_invoice', [
            'invoices' => $invoices,
            'invoice' => $invoice,
        ]);
    }
}
