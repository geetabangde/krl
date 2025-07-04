

@extends('admin.layouts.app')
@section('title', 'warehouse | KRL')
@section('content')
            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Warehouse</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show auto-dismiss" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show auto-dismiss" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Warehouse</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Warehouse Listing Page -->
                    <div class="row listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">🏢 Warehouse Listing</h4>
                                        <p class="card-title-desc">
                                            View, edit, or delete warehouse details below.
                                        </p>
                                    </div>
                                    @if (hasAdminPermission('create warehouse'))
                                    <button class="btn" id="addWarehouseBtn"
                                        style="background-color: #ca2639; color: white; border: none;"
                                        data-bs-toggle="modal" data-bs-target="#addWarehouseModal">
                                        <i class="fas fa-plus"></i> Add Warehouse
                                    </button>
                                    @endif
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Warhouse ID</th>
                                                <th>Name</th>
                                                <th>Address</th>
                                                <th>Incharge</th>
                                            @if (hasAdminPermission('edit warehouse') || hasAdminPermission('delete warehouse') || hasAdminPermission('view warehouse') )
                                            <th>Action</th>@endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($warehouses as $warehouse)
                            
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>WH##{{$warehouse->id}}</td>
                                                <td>{{$warehouse->warehouse_name}}</td>
                                                <td>{{$warehouse->address}}</td>
                                                <td>{{$warehouse->incharge}}</td>
                                                @if (hasAdminPermission('edit warehouse') || hasAdminPermission('delete warehouse') || hasAdminPermission('view warehouse') )
                                                <td>
                                                    @if (hasAdminPermission('view warehouse'))
                                                <button class="btn btn-sm btn-light view-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#viewWarehouseModal"
                                                        data-name="{{ $warehouse->warehouse_name }}"
                                                        data-address="{{ $warehouse->address }}"
                                                        data-incharge="{{ $warehouse->incharge }}">
                                                    <i class="fas fa-eye text-primary"></i>
                                                </button>

                                                    @endif
                                                    @if (hasAdminPermission('edit warehouse'))
                                                    <button class="btn btn-sm btn-light edit-btn edit-warehouse-btn"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editWarehouseModal"
                                                            data-id="{{ $warehouse->id }}"
                                                            data-name="{{ $warehouse->warehouse_name }}"
                                                            data-address="{{ $warehouse->address }}"
                                                            data-incharge="{{ $warehouse->incharge }}">
                                                        <i class="fas fa-pen text-warning"></i>
                                                    </button>
                                                        @endif
                                                    @if (hasAdminPermission('delete warehouse'))
                                                   
                                                     <button class="btn btn-sm btn-light delete-btn" data-bs-toggle="tooltip" 
                                                    title="delete warehouse"><a
                                                        href="{{ route('admin.warehouse.delete', $warehouse->id) }}"  onclick="return confirm('Are you sure you want to delete this warehouse record?')"> <i
                                                            class="fas fa-trash text-danger"></i>
                                                    </a>
                                                </button>
                                                        @endif
                                                </td>
                                                @endif
                                            </tr>
                                            @endforeach
                                
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Warehouse Modal -->
                    <div class="modal fade" id="viewWarehouseModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Warehouse Details</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>🏭 Name:</strong> <span id="viewwarehouse_name"></span></p>
                                    <p><strong>📍 Address:</strong> <span id="viewaddress"></span></p>
                                    <p><strong>👨‍💼 Incharge:</strong> <span id="incharge"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Add Warehouse Modal -->
                    <div class="modal fade" id="addWarehouseModal" tabindex="-1"
                        aria-labelledby="addWarehouseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addWarehouseModalLabel">🏢 Add Warehouse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('admin.warehouse.store')}}" method="post">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">🏭 Warehouse Name</label>
                                                <input type="text" class="form-control" id="inputWarehouseName"
                                                    placeholder="Enter warehouse name" name="warehouse_name" required>
                                                    @error('warehouse_name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">📍 Address</label>
                                                <input type="text" class="form-control" id="inputAddress"
                                                    placeholder="Enter address" name="address" required>
                                                    @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">👨‍💼 Incharge</label>
                                                <input type="text" class="form-control" id="inputIncharge"
                                                    placeholder="Enter incharge name" name="incharge"required >
                                                    @error('incharge')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" >Add
                                                Warehouse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Warehouse Modal -->
                    <div class="modal fade" id="editWarehouseModal" tabindex="-1"
                        aria-labelledby="editWarehouseModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editWarehouseModalLabel">✏️ Edit Warehouse</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" action="" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">🏭 Warehouse Name</label>
                                                <input type="text" class="form-control" id="editWarehouseName" name="warehouse_name" required>
                                                @error('warehouse_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">📍 Address</label>
                                                <input type="text" class="form-control" id="editAddress" name="address" required>
                                                @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">👨‍💼 Incharge</label>
                                                <input type="text" class="form-control" id="editIncharge" name="incharge" required>
                                                @error('incharge')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary" id="updateWarehouse">Update
                                                Warehouse</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->


    

    <!-- JAVASCRIPT -->
  
  <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-btn").forEach(button => {
        button.addEventListener("click", function () {
            // Set modal content using data attributes
            document.getElementById("viewwarehouse_name").textContent = this.dataset.name || 'N/A';
            document.getElementById("viewaddress").textContent = this.dataset.address || 'N/A';
            document.getElementById("incharge").textContent = this.dataset.incharge || 'N/A';

            // DO NOT manually call .show() since Bootstrap handles it
        });
    });
});
</script>


   <script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-warehouse-btn").forEach(button => {
        button.addEventListener("click", function () {
            // Use data-* attributes for reliability
            document.getElementById("editWarehouseName").value = this.dataset.name || '';
            document.getElementById("editAddress").value = this.dataset.address || '';
            document.getElementById("editIncharge").value = this.dataset.incharge || '';

            // Set form action
            let form = document.getElementById("editForm");
            form.action = `/admin/warehouses/${this.dataset.id}`;
        });
    });
});
</script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Select all edit buttons
                document.querySelectorAll('.edit-warehouse-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        // Get the warehouse ID from data-id
                        const warehouseId = this.getAttribute('data-id');
                        
                        // Construct the new action URL
                        const actionUrl = `/admin/warehouse/update/${warehouseId}`;
                        
                        // Set the form action in the modal
                        const editForm = document.querySelector('#editWarehouseModal form');
                        if (editForm) {
                            editForm.action = actionUrl;
                        }
                    });
                });
            });
            </script>
   

    <!-- Datatable init js -->
  
@endsection