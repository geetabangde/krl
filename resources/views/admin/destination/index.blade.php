@extends('admin.layouts.app')
@section('title', 'Package Type | KRL')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Destination</h4>
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
                                <li class="breadcrumb-item active">Destination</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <!-- Tyre Listing Page -->
            <div class="row listing-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>

                                <h4 class="card-title">🛞 Destination Listing</h4>
                                <p class="card-title-desc">
                                    View, edit, or delete Destination details below. This table supports search,
                                    sorting, and pagination via DataTables.
                                </p>
                            </div>
                            @if (hasAdminPermission('create  destination'))
                            <button class="btn" id="addTyreBtn"
                                style="background-color: #ca2639; color: white; border: none;">
                                <i class="fas fa-plus"></i> Add Destination
                            </button>
                            @endif
                        </div>
                        <div class="card-body">
                            <table id=""  class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Destination </th>
                                @if (hasAdminPermission('edit destination') || hasAdminPermission('delete destination')|| hasAdminPermission('view destination'))
                                        <th>Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tyres as $tyre)
                                    <td>{{ $loop->iteration  }}</td>
                                     <td>{{ $tyre->destination }}</td>
                                @if (hasAdminPermission('edit destination') || hasAdminPermission('delete destination')|| hasAdminPermission('view destination'))

                                          <td>

                                            @if (hasAdminPermission('view destination'))
                                                <button class="btn btn-sm btn-light view-btn"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewTyreModal"
                                                    data-package_type="{{ $tyre->destination }}"
                                                    onclick="viewTyreData(this)">
                                                    <i class="fas fa-eye text-primary"></i>
                                                </button>
                                                @endif
                                                @if (hasAdminPermission('edit destination'))
                                                <button class="btn btn-sm btn-light edit-btn"
                                                    data-id="{{ $tyre->id }}"
                                                    data-name="{{ $tyre->destination }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#updateTyreModal">
                                                    <i class="fas fa-pen text-warning"></i>
                                                </button>
                                                @endif
                                                @if (hasAdminPermission('delete destination'))
                                                <button class="btn btn-sm btn-light delete-btn"><a
                                                        href="{{ route('admin.destination.delete', $tyre->id) }}"  onclick="return confirm('Are you sure you want to delete this tyre record?')"> <i
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
            
            {{-- view model --}}
            <div class="modal fade" id="viewTyreModal" tabindex="-1" aria-labelledby="viewTyreModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewTyreModalLabel">Destination</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p><strong>🏢 Destination:</strong> <span id="viewCompany"></span></p>
                            
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Tyre Modal -->
            <div class="modal fade" id="addTyreModal" tabindex="-1" aria-labelledby="addTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addTyreModalLabel">🛞 Add Destination</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                              <form action="{{ route('admin.destination.store') }}" method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🏢 Destination</label>
                                        <input type="text" class="form-control" id="inputCompany"
                                            placeholder="Enter destination" name="destination" required>
                                        @error('destination')
                                            <span style="color: red;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Add
                                    Destination</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- //update tyre model --}}
            <div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
            
                        <div class="modal-header">
                            <h5 class="modal-title">🛞 Edit Destination</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
            
                        <div class="modal-body">
                            <form id="editForm"  method="post" action="">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <input type="hidden" id="editid">
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">🏢 Destination</label>
                                        <input type="text" class="form-control" placeholder="Enter destination"
                                            id="editCompany" name="destination" required>
                                        @error('destination')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    
                                    
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Update Destination</button>
                                    
                                </div>
                            </form>
                        </div>
            
                    </div>
                </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="updateTyreModal" tabindex="-1" aria-labelledby="updateTyreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
              
                    <div class="modal-header">
                      <h5 class="modal-title">🛞 Update Destination</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
              
                    <div class="modal-body">
                        <p><strong>🏢 Name:</strong> <span id="viewCompany"></span></p>
                        
                    </div>
              
                  </div>
                </div>
              </div>
        </div>
    </div>
    <!-- end main content-->

    </div>
   
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Event delegation from document since child rows are dynamically inserted
            document.addEventListener('click', function (e) {
                // Check if the clicked element or its parent has class 'edit-btn'
                const btn = e.target.closest('.edit-btn');
                if (!btn) return;
     
                const tyreData = {
                    id: btn.dataset.id,
                    name: btn.dataset.name,
                    
                };
    
                // console.log("Clicked row data:", tyreData);
    
                // Fill modal fields
                $('#editid').val(tyreData.id);
                $('#editCompany').val(tyreData.name);
                 

                let form = document.getElementById('editForm');
                form.action = `/admin/destination/update/${tyreData.id}`;
                // Show modal
                $('#updateTyreModal').modal('show');
            });
        });
    </script>
   
               <!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Apna custom jQuery script -->
<script>
    function viewTyreData(button) {
      document.getElementById("viewCompany").textContent = button.dataset.package_type;
      
    }
  </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function getHealthBadgeClass(health) {
                switch (health) {
                    case "New":
                        return "bg-success text-white"; // Green
                    case "Good":
                        return "bg-primary text-white"; // Blue
                    case "Worn Out":
                        return "bg-warning text-dark"; // Yellow
                    case "Needs Replacement":
                        return "bg-danger text-white"; // Red
                    default:
                        return "bg-secondary text-white"; // Gray (default)
                }
            }
            // Attach existing buttons on page load
            document.querySelectorAll(".view-btn").forEach(attachViewEvent);
            document.querySelectorAll(".delete-btn").forEach(attachDeleteEvent);
        });
           
       
    </script>
    {{-- open model add and update --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addTyreBtn").addEventListener("click", function () {
            var addTyreModal = new bootstrap.Modal(document.getElementById("addTyreModal"));
            addTyreModal.show();
        });
        document.getElementById("updateTyreBtn").addEventListener("click", function () {
                var updateTyreBtnTyreModal = new bootstrap.Modal(document.getElementById("updateTyreModal"));
                updateTyreModal.show();
            });  
    });
</script>

@endsection