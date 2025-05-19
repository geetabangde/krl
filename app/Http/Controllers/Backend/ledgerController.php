<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\LedgerMaster;
use App\Models\Group;
use App\Models\Voucher;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ledgerController extends Controller
{
    public function index()
   {
    $vouchers = Voucher::with(['fromLedger.group', 'toLedger.group'])->get();
    return view('admin.ledger.index', compact('vouchers'));
   }


    public function create()
    {
        return view('admin.ledger_master.create'); // 🚀 Ensure You Have This View
    }
}
  

 
