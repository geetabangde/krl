@extends('admin.layouts.app')
@section('title', 'Voucher List | KRL')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Permission for Voucher Edit</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Voucher List</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Voucher List Card -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="40%">Voucher Type</th>
                                        <th width="20%">From</th>
                                        <th width="20%">To</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $vouchers = [
                                            'Payment', 'Receipt', 'Journal', 'Contra',
                                            'Sales', 'Purchase', 'Expense', 'Credit Note', 'Debit Note'
                                        ];
                                    @endphp

                                    @foreach($vouchers as $voucher)
                                    <tr>
                                        <td><strong>{{ $voucher }}</strong></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary btn-edit"
                                                data-voucher="{{ $voucher }}" data-type="from"
                                                data-current="{{ $voucherPermissions[$voucher]['from'] ?? '' }}">
                                                <i class="bx bx-edit"></i> Edit
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-primary btn-edit"
                                                data-voucher="{{ $voucher }}" data-type="to"
                                                data-current="{{ $voucherPermissions[$voucher]['to'] ?? '' }}">
                                                <i class="bx bx-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit Modal -->
<div class="modal fade" id="editVoucherModal" tabindex="-1" aria-labelledby="editVoucherModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="voucherForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVoucherModalLabel">Edit Voucher Permission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="voucherName">
                    <input type="hidden" id="voucherType">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Select Groups</label>
                        <div id="groupCheckboxes">
                            @foreach($groups as $group)
                                <div class="form-check mt-2">
                                    <input class="form-check-input main-group" type="checkbox" value="{{ $group->id }}" id="group_{{ $group->id }}">
                                    <label class="form-check-label fw-semibold" for="group_{{ $group->id }}">
                                        📁 {{ $group->group_name }}
                                    </label>

                                    {{-- Subgroups --}}
                                    @php
                                        $subGroups = \App\Models\Group::where('parent_id', $group->id)->get();
                                    @endphp
                                    @if($subGroups->count() > 0)
                                        <div class="ms-4 mt-1">
                                            @foreach($subGroups as $sub)
                                                <div class="form-check">
                                                    <input class="form-check-input subgroup" type="checkbox" value="{{ $sub->id }}" id="group_{{ $sub->id }}" data-parent="{{ $group->id }}">
                                                    <label class="form-check-label" for="group_{{ $sub->id }}">
                                                        {{ $sub->group_name }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // Modal open
    document.querySelectorAll(".btn-edit").forEach(btn => {
        btn.addEventListener("click", function() {
            const voucher = this.dataset.voucher;
            const type = this.dataset.type;
            const current = this.dataset.current;

            document.getElementById("voucherName").value = voucher;
            document.getElementById("voucherType").value = type;

            document.querySelectorAll("#groupCheckboxes input").forEach(cb => cb.checked = false);

            if (current) {
                current.split(',').forEach(id => {
                    const cb = document.getElementById("group_" + id);
                    if (cb) cb.checked = true;
                });
            }

            const modal = new bootstrap.Modal(document.getElementById("editVoucherModal"));
            modal.show();
        });
    });

    // Parent-child checkbox relationship
    // document.querySelectorAll(".main-group").forEach(group => {
    //     group.addEventListener("change", function() {
    //         const groupId = this.value;
    //         document.querySelectorAll(`.subgroup[data-parent='${groupId}']`).forEach(sub => {
    //             sub.checked = this.checked;
    //         });
    //     });
    // });

    // If subgroup checked, parent auto-check
    // document.querySelectorAll(".subgroup").forEach(sub => {
    //     sub.addEventListener("change", function() {
    //         const parent = document.getElementById("group_" + this.dataset.parent);
    //         if (this.checked) {
    //             parent.checked = true;
    //         }
    //     });
    // });

    // Save
    document.getElementById("voucherForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const voucher_type = document.getElementById("voucherName").value;
        const permission_type = document.getElementById("voucherType").value;

        const group_id = Array.from(document.querySelectorAll("#groupCheckboxes input:checked")).map(el => el.value);

        if (group_id.length === 0) {
            alert("Please select at least one group or subgroup");
            return;
        }

        fetch("{{ route('admin.voucherList.store') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ voucher_type, permission_type, group_id })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                bootstrap.Modal.getInstance(document.getElementById("editVoucherModal")).hide();
            } else {
                alert("Error saving permission!");
            }
        })
        .catch(console.error);
    });
});
</script>



@endsection



