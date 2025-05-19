@extends('admin.layouts.app')
@section('title', 'Order | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Pod Documents</h4>
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item active">Pod Documents</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <div class="row add-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4>🚚 Add Pod Documents</h4>
                     <p class="mb-0">Fill in the required details for shipment and delivery.</p>
                  </div>
               </div>
               <form action="{{ route('admin.consignments.uploadMultiplePod') }}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="card-body">
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


                     <div class="row">
                        @csrf
                        <div class="col-md-6">
                           <label for="pod_file" class="form-label">POD File (pdf, jpg, png)</label>
                           
                           <input type="file" name="pod_files[]" id="pod_file"
                              class="form-control" required
                              accept=".pdf,.jpg,.jpeg,.png" multiple required>
                           <small class="text-muted">
                           Filename must start with <code>POD_</code>, e.g.
                           <code>POD_LR-1234567.pdf</code>
                           </small>
                        </div>
                        <div class="row">
                           <!-- Submit Button -->
                           <div class="row mt-4 mb-4">
                              <div class="col-12 text-center">
                                 <button type="submit" class="btn btn-primary">
                                 <i class="fas fa-save"></i> Upload POD
                                 </button>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

@endsection