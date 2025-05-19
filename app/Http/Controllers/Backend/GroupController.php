<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Group;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller
{
   
    public function index()
{
    
    $groups = Group::paginate(10);
    return view('admin.group.index', compact('groups'));
}

    
    public function create()
    { 
        $groups = Group::whereNull('parent_id')->get(); 
        return view('admin.group.create', compact('groups')); 
    }
    public function store(Request $request)
    {
        Group::create([
            'group_name' => $request->group_name,
            'sub_group' => $request->sub_group,
            'parent_id' => $request->parent_id, 
        ]);
    
        return redirect()->route('admin.group.index')->with('success', 'Group created successfully!');
    }

    public function show($id)
   {
    $group = Group::findOrFail($id);
    return view('admin.group.show', compact('group'));
   }
    
   public function destroy($id)
   {
    $group = Group::findOrFail($id);
    $group->delete();
    return redirect()->route('admin.group.index')->with('success', 'Voucher deleted successfully!');
   }

   public function edit($id)
   {
    $group = Group::findOrFail($id); // Singular name used
    $parentGroups = Group::whereNull('parent_id')->where('id', '!=', $id)->get();

    return view('admin.group.edit', compact('group', 'parentGroups'));
   }

   

   public function update(Request $request, $id)
   {
       $group = Group::findOrFail($id);
   
       $group->group_name = $request->group_name;
       $group->sub_group = $request->sub_group;
       $group->parent_id = $request->parent_id; // Include this line
   
       $group->save();
   
       return redirect()->route('admin.group.index')->with('success', 'Group updated successfully!');
   }
   

}
    