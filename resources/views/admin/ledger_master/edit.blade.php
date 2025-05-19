@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
     <div class="row ledger-add-form">
     <form action="{{ route('admin.ledger_master.update', $ledgerMaster->id) }}" method="POST">
    @csrf
  

    <div class="row ledger-add-form">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>📒 Edit Ledger Master</h4>
                        <p>Update the details below.</p>
                    </div>
                    <a href="{{ route('admin.ledger_master.index') }}" class="btn"
                        style="background-color: #ca2639; color: white;">
                        ⬅ Back
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Name -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" name="ledger_name" value="{{ $ledgerMaster->ledger_name }}"  class="form-control" placeholder="Enter name">
                            </div>
                        </div>
                        <!-- Group/Subgroup -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Group/Subgroup</label>
                                <select name="group_id" class="form-control" required>
                                    <option value="">Select Group</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->id }}" 
                                            {{ old('group_id', $ledgerMaster->group_id) == $group->id ? 'selected' : '' }}>
                                            {{ $group->group_name }} 
                                            @if ($group->parent) 
                                                ({{ $group->parent->group_name }}) 
                                            @else 
                                                
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- PAN -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">PAN</label>
                                <input type="text" name="pan" value="{{ $ledgerMaster->pan }}"  class="form-control" placeholder="ABCDE1234F">
                            </div>
                        </div>
                        <!-- TAN -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">TAN</label>
                                <input type="text" name="tan" value="{{ $ledgerMaster->tan }}"  class="form-control" placeholder="TAN12345B">
                            </div>
                        </div>
                        <!-- GST -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">GST</label>
                                <input type="text" name="gst" value="{{ $ledgerMaster->gst }}"  class="form-control" placeholder="22ABCDE1234F1Z5">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Update Ledger</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

    </div>         
   </div>
</div>

@endsection