@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
       <!-- View Ledger Details Section -->
       <div class="row ledger-view-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>📄 View Ledger Master Details</h4>
                                        <p>Review the details of the selected ledger.</p>
                                    </div>
                                    <a href="{{ route('admin.ledger_master.index') }}" class="btn backToLedgerListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
</a>
                                </div>
                                <div class="card-body">
    <p><strong>Name:</strong> <span id="viewLedgerName">{{ $ledgerMaster->ledger_name }}</span></p>

    <p><strong>Group/Subgroup:</strong> 
        <span id="viewLedgerGroup">
            {{ $ledgerMaster->group->group_name ?? 'N/A' }}
            @if($ledgerMaster->group && $ledgerMaster->group->parent)
                / {{ $ledgerMaster->group->parent->group_name }}
            @endif
        </span>
    </p>

    <p><strong>PAN:</strong> <span id="viewLedgerPAN">{{ $ledgerMaster->pan ?? 'N/A' }}</span></p>
    <p><strong>TAN:</strong> <span id="viewLedgerTAN">{{ $ledgerMaster->tan ?? 'N/A' }}</span></p>
    <p><strong>GST:</strong> <span id="viewLedgerGST">{{ $ledgerMaster->gst ?? 'N/A' }}</span></p>
</div>

                            </div>
                        </div>
                    </div>


                    
</div>
</div>
@endsection