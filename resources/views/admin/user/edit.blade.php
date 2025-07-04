
@extends('admin.layouts.app')
@section('title', 'Edit User | KRL')
@section('content')
<div class="page-content">
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Edit User</h4>
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
                     <li class="breadcrumb-item"><a href="{{ route('admin.user.index') }}">Users</a></li>
                     <li class="breadcrumb-item active">Edit</li>
                  </ol>
               </div>
            </div>
         </div>
      </div>
      <!-- end page title -->
      <div class="row listing-form">
         <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                  <div>
                     <h4 class="card-title">🛞 Edit User</h4>
                     <p class="card-title-desc">
                        Update user details below. Fields marked with <span class="required"></span> are required.
                     </p>
                  </div>
               </div>
               <div class="card-body">
                  <form action="{{ route('admin.user.update',$user->id) }}" method="POST" class="needs-validation" novalidate  enctype="multipart/form-data">
                     @csrf
                     <div class="modal-body">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="name" class="form-label"> Name<span class="required"></span></label>
                                 <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Enter User Name" value="{{ old('name', $user->name) }}" required>
                                 @error('name')
                                 <small class="invalid-name text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                           
                           
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="email" class="form-label">Email<span class="required"></span></label>
                                 <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter User Email" value="{{ old('email', $user->email) }}" required>
                                 @error('email')
                                 <small class="invalid-email text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                           <div class="col-md-6 form-group">
                              <label for="role" class="form-label">User Role<span class="required"></span></label>
                              <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                 <option value="">Select Role</option>
                                 @foreach ($roles as $role )
                                 <option value="{{ $role->id }}" {{ $user->role ? 'selected' : '' }}>
                                 {{ $role->name }}
                                 </option>
                                 @endforeach
                              </select>
                              @error('role')
                              <small class="invalid-role text-danger">{{ $message }}</small>
                              @enderror
                           </div>
                           <div class="col-md-5 mb-3 form-group mt-4">
                              <label for="password_switch">Update Password</label>
                              <div class="form-check form-switch custom-switch-v1 float-end">
                                 <input type="checkbox" name="password_switch" class="form-check-input" value="on" id="password_switch" {{ old('password_switch') == 'on' ? 'checked' : '' }}>
                                 <label class="form-check-label" for="password_switch"></label>
                              </div>
                           </div>
                           <div class="col-md-6 ps_div {{ old('password_switch') == 'on' ? '' : 'd-none' }}">
                              <div class="form-group">
                                 <label for="password" class="form-label">Password<span class="required"></span></label>
                                 <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter New Password" minlength="6">
                                 @error('password')
                                 <small class="invalid-password text-danger">{{ $message }}</small>
                                 @enderror
                              </div>
                           </div>
                         
                           <!-- Official Email -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">📧 Email ID</label>
                              <input type="email" class="form-control @error('email') is-invalid @enderror"
                                 name="email" id="editEmail" value="{{ $user->email }}" placeholder="Enter email"
                                 required>
                              @error('email')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Emergency Contact Number -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">📱 Contact Number</label>
                              <input type="text"
                                 class="form-control @error('phone_number') is-invalid @enderror"
                                 name="phone_number"  value="{{ $user->phone_number }}"
                                 placeholder="Enter contact number" required  maxlength="10">
                              {{-- <input value="{{ $user->phone_number }}"> --}}
                              @error('phone_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Contact Number -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">📞 Emergency Contact Number</label>
                              <input type="number"
                                 class="form-control @error('emergency_contact_number') is-invalid @enderror"
                                 name="emergency_contact_number" id="editEmergencyContact"
                                 value="{{ $user->emergency_contact_number }}"
                                 placeholder="Enter emergency contact number" required minlength="10"
                                 maxlength="10">
                              @error('emergency_contact_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">💼 Designation (Job Title)</label>
                              <input type="text" class="form-control @error('designation') is-invalid @enderror"
                                 name="designation" id="editDesignation" value="{{ $user->designation }}"
                                 placeholder="Enter job title" required>
                              @error('editDesignation')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🏢 Department</label>
                              <select class="form-select @error('department') is-invalid @enderror"
                                 name="department" id="editDepartment" required>
                              <option value="HR" {{ (old('department', $user->department) == 'HR') ? 'selected' : '' }}>HR</option>
                              <option value="Manager" {{ (old('department', $user->department) == 'Manager') ? 'selected' : '' }}>Manager</option>
                              <option value="Accounts" {{ (old('department', $user->department) == 'Accounts') ? 'selected' : '' }}>Accounts</option>
                              <option value="IT" {{ (old('department', $user->department) == 'IT') ? 'selected' : '' }}>IT</option>
                              <option value="Operations" {{ (old('department', $user->department) == 'Operations') ? 'selected' : '' }}>Operations</option>
                              </select>
                              @error('department')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 mb-3">
                              <label class="form-label">📅 Date of Joining</label>
                              <input type="date"
                                 class="form-control @error('date_of_joining') is-invalid @enderror"
                                 name="date_of_joining" id="editDOJ" value="{{ $user->date_of_joining }}"
                                 required>
                              @error('date_of_joining')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Residential Address -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🏠 Residential Address</label>
                              <input type="text" class="form-control @error('address') is-invalid @enderror"
                                 name="address" id="editAddress" value="{{ $user->address }}"
                                 placeholder="Enter address" required>
                              @error('address')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- State -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🗺️ State</label>
                              <select class="form-control @error('state') is-invalid @enderror" name="state" id="editState" required>
                                 <option value="">Select State</option>
                                 <option value="Delhi" {{ old('state', $user->state) == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                                 <option value="Maharashtra" {{ old('state', $user->state) == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                                 <option value="Uttar Pradesh" {{ old('state', $user->state) == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                                 <option value="Karnataka" {{ old('state', $user->state) == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                                 <option value="Tamil Nadu" {{ old('state', $user->state) == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                                 <option value="Rajasthan" {{ old('state', $user->state) == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                                 <option value="Gujarat" {{ old('state', $user->state) == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                                 <!-- aur bhi states add kar sakte ho -->
                              </select>
                              @error('state')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Postal Code -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">📮 Postal Code</label>
                              <input type="number" class="form-control @error('pin_code') is-invalid @enderror"
                                 name="pin_code" id="editPinCode" value="{{ $user->pin_code }}"
                                 placeholder="Enter postal code" required>
                              @error('pin_code')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Aadhaar Number -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🆔 Aadhaar Number</label>
                              <input type="text"
                                 class="form-control @error('aadhaar_number') is-invalid @enderror"
                                 name="aadhaar_number" id="editAadhaar" value="{{ $user->aadhaar_number }}"
                                 placeholder="Enter Aadhaar number" required>
                              @error('aadhaar_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- PAN Number -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">💳 PAN Card Number</label>
                              <input type="text" class="form-control @error('pan_number') is-invalid @enderror"
                                 name="pan_number" id="editPAN" value="{{ $user->pan_number }}"
                                 placeholder="Enter PAN number" required
                                 oninput="this.value = this.value.toUpperCase()">
                              @error('pan_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Bank Account Number -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🏦 Bank Account Number</label>
                              <input type="text"
                                 class="form-control @error('bank_account_number') is-invalid @enderror"
                                 name="bank_account_number" id="editAccountNumber"
                                 value="{{ $user->bank_account_number }}" placeholder="Enter bank account number"
                                 required>
                              @error('bank_account_number')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- IFSC Code -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label">🏛️ Bank IFSC Code</label>
                              <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror"
                                 name="ifsc_code" id="editIFSC" value="{{ $user->ifsc_code }}"
                                 placeholder="Enter IFSC code" oninput="this.value = this.value.toUpperCase()"
                                 required>
                              @error('ifsc_code')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           {{-- salary --}}
                           <div class="col-md-6 mb-3">
                              <label class="form-label">💰  Salary</label>
                              <input type="number" class="form-control @error('salary') is-invalid @enderror"
                                 name="salary" id="salary" value="{{ $user->salary }}"
                                 placeholder="Enter Your Selary" 
                                 required>
                              @error('salary')
                              <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                           </div>
                           <!-- Status -->
                           <div class="col-md-6 mb-3">
                              <label class="form-label d-block">📌 Status</label>
                              <div class="btn-group" role="group" aria-label="Status toggle">
                                 <input type="radio" class="btn-check" name="status" id="status_active"
                                 value="active" autocomplete="off" 
                                 {{ old('status', $user->status) == 'active' ? 'checked' : '' }}>
                                 <label class="btn btn-outline-success" for="status_active">Active</label>
                                 <input type="radio" class="btn-check" name="status" id="status_inactive"
                                 value="inactive" autocomplete="off" 
                                 {{ old('status', $user->status) == 'inactive' ? 'checked' : '' }}>
                                 <label class="btn btn-outline-danger" for="status_inactive">Inactive</label>
                              </div>
                              @error('status')
                              <div class="text-danger mt-1">{{ $message }}</div>
                              @enderror
                           </div>
                           <div class="col-md-6 mb-3">
                                <label class="form-label">📸 Employee Photo</label>
                                
                                <input type="file" name="employee_photo" class="form-control">

                                <input type="hidden" name="old_employee_photo" value="{{ $user->employee_photo }}">

                                @if($user->employee_photo)
                                    <img src="{{ asset('uploads/' . $user->employee_photo) }}" height="50">
                                @endif


                                @error('employee_photo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                     </div>
                     <div class="modal-footer">
                        {{-- <a href="{{ route('admin.user.index') }}" class="btn btn-secondary">Cancel</a> --}}
                        <button type="submit" class="btn btn-primary">Update</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
   // Toggle password field visibility
   document.getElementById('password_switch').addEventListener('change', function () {
       document.querySelector('.ps_div').classList.toggle('d-none', !this.checked);
   });
   
   // Bootstrap form validation
   (function () {
       'use strict';
       const form = document.querySelector('.needs-validation');
       form.addEventListener('submit', function (event) {
           if (!form.checkValidity()) {
               event.preventDefault();
               event.stopPropagation();
           }
           form.classList.add('was-validated');
       }, false);
   })();
</script>
@endsection