<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\LedgerMaster;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ledgerMasterController extends Controller
{
    public function index()
{ 
    $ledgermaster = LedgerMaster::latest()->get(); // Use latest() method correctly
    return view('admin.ledger_master.index', compact('ledgermaster'));
}

  
    public function create()
    {    $groups = Group::all();
        return view('admin.ledger_master.create', compact('groups')); // 🚀 Ensure You Have This View
    }

    public function store(Request $request)
    {
        $ledgerMaster = LedgerMaster::create([
            'ledger_name' => $request->ledger_name,
            'group_id' => $request->group_id,  // The group ID is passed from the form/input
            'pan' => $request->pan,
            'tan' => $request->tan,
            'gst' => $request->gst,
        ]);

        // Return a response indicating success
        return redirect()->route('admin.ledger_master.index')->with('success', 'ledger_master created successfully!');
        
    }

    public function edit($id)
   {
    $ledgerMaster = LedgerMaster::findOrFail($id); 
    $groups = Group::with('parent')->get(); // load parent relationship
    return view('admin.ledger_master.edit', compact('ledgerMaster','groups'));
   }

   public function update(Request $request, $id)
  {
    $ledger = LedgerMaster::findOrFail($id);

    $ledger->update([
        'ledger_name' => $request->ledger_name,
        'group_id' => $request->group_id,
        'pan' => $request->pan,
        'tan' => $request->tan,
        'gst' => $request->gst,
    ]);

    return redirect()->route('admin.ledger_master.index')
                     ->with('success', 'Ledger updated successfully.');
   }

   public function show($id)
   {
    $ledgerMaster = LedgerMaster::findOrFail($id);
    return view('admin.ledger_master.show', compact('ledgerMaster'));
   }
    
   public function destroy($id)
   {
    $ledgerMaster = LedgerMaster::findOrFail($id);
    $ledgerMaster->delete();
    return redirect()->route('admin.ledger_master.index')->with('success', 'ledger_master deleted successfully!');
   }


    
    
}
  

 
