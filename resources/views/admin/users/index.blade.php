@extends('admin.layouts.app')
@section('content')
   <div class="page-content">
      <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
          <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
               <h4 class="mb-sm-0 font-size-18">Ledger Master</h4>
               <div class="page-title-right">
                 <ol class="breadcrumb m-0">
                   <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                   <li class="breadcrumb-item active">Ledger Master</li>
                 </ol>
               </div>
            </div>
          </div>
        </div>
        <!-- end page title -->
        <!-- Customer Listing Page -->
        <div class="row listing-form">
          <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                 <div>
                   <h4 class="card-title">🧑‍💼 Ledger Master List</h4>
                   <p class="card-title-desc">View, edit, or delete customer details below.</p>
                 </div>
                 @if (hasAdminPermission('create customer'))
                <button class="btn" id="addCustomerBtn"
                  style="background-color: #ca2639; color: white; border: none;">
                  <i class="fas fa-plus"></i> Add Ledger Master
                </button>
              @endif
               </div>
               <div class="card-body">
                 <table id="" class="table table-bordered dt-responsive nowrap w-100">
                   <thead>
                     <tr>
                        <th>#</th>
                        <th>Ledger Name</th>
                        <th>Group Name</th>
                        <th>PAN Number</th>
                        <th>TAN Number</th>
                        <th class="w-25">Location</th>
                        @if (hasAdminPermission('edit customer') || hasAdminPermission('delete customer') || hasAdminPermission('view customer'))
                     <th>Actions</th>
                   @endif
                     </tr>
                   </thead>
                   <tbody>
                     @foreach($users as $user)
                    <tr class="customer-row"
                        data-id="{{ $user->id }}"
                        data-address='@json($user->address)'
                        data-group-id="{{ $user->group_id }}"
                        data-deductor="{{ $user->deductor }}"
                        data-email="{{ $user->email }}"
                        data-pan="{{ $user->pan_number }}"
                        data-tan="{{ $user->tan_number }}"
                        data-bank-name="{{ $user->bank_name }}"
                        data-account-holder-name="{{ $user->account_holder_name }}"
                        data-account-number="{{ $user->account_number }}"
                        data-branch="{{ $user->branch }}"
                        data-ifsc-code="{{ $user->ifsc_code }}"
                        data-account-type="{{ $user->account_type }}"
                    >

                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                         {{ $user->group->group_name ?? 'No Group' }}
                         {{ $user->group && $user->group->parent ? $user->group->parent->group_name : '' }}
                        </td>
                        <td>{{ $user->pan_number }}</td>
                        <td>{{ $user->tan_number }}</td>
                        <td class="w-25">
                         @php
                        $addresses = $user->address;
                     @endphp
                         @if (!empty($addresses) && is_array($addresses))
                          @foreach ($addresses as $address)
                        <div class="text-wrap">
                         <p>
                          <strong>{{ $address['city'] ?? '' }},</strong><br>
                          <span>
                           {{ $address['gstin'] ?? '' }},
                           {{ $address['billing_address'] ?? '' }},
                           {{ $address['consignment_address'] ?? '' }},
                           {{ $address['mobile_number'] ?? '' }},
                           {{ $address['email'] ?? '' }},
                           {{ $address['poc'] ?? '' }}
                          </span>
                         </p>
                        </div>
                        @endforeach
                     @else
                       <p>No Address Available</p>
                     @endif
                        </td>
                        @if (hasAdminPermission('edit customer') || hasAdminPermission('delete customer') || hasAdminPermission('view customer'))
                     <td class="text-center">
                       <div class="d-flex align-items-center gap-2">
                        @if (hasAdminPermission('view customer'))
                     <button class="btn btn-sm btn-light view-btn" data-bs-toggle="tooltip"
                       title="View Customer">
                       <i class="fas fa-eye text-primary"></i>
                     </button>
                     @endif
                        @if (hasAdminPermission('edit customer'))
                    <button class="btn btn-sm btn-light edit-btn" data-bs-toggle="tooltip" title="Edit Customer">
                      <i class="fas fa-pen text-warning"></i>
                    </button>
                     @endif
                        @if (hasAdminPermission('delete customer'))
                     <button class="btn btn-sm btn-light delete-btn" data-id="{{ $user->id }}"
                       data-bs-toggle="modal" data-bs-target="#deleteUserModal" title="Delete Customer"
                       data-bs-toggle="tooltip">
                       <i class="fas fa-trash text-danger"></i>
                     </button>
                     @endif
                       </div>
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
        <!-- Customer Details Add Form -->
        <div class="row add-form">
          <div class="col-12">
            <div class="card">
               <div class="card-header d-flex justify-content-between align-items-center">
                 <div>
                   <h4>🧑‍💼 Add Ledger Master Details</h4>
                   <p>Enter the required details for the Ledger Master.</p>
                 </div>
                 <button class="btn" id="backToListBtn" style="background-color: #ca2639; color: white; border: none;">
                   ⬅ Back to Listing
                 </button>
               </div>
               <form action="{{ route('admin.users.store') }}" method="POST">
                 @csrf
                 <div class="card-body">
                   <div class="row">
                     <!-- Customer Details -->
                     <div class="col-md-6">
                        <h5>👤 Ledger Master Information</h5>
                        <div class="mb-3">
                          <label class="form-label">Ledger Master Name</label>
                          <input type="text" name="name" class="form-control" placeholder="Enter customer name">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Email</label>
                          <input type="text" name="email" class="form-control" placeholder="Enter Email">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Password</label>
                          <input type="password" name="password" class="form-control"
                            placeholder="Enter Your Password">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">Pan Number</label>
                          <input type="text" name="pan_number" class="form-control" placeholder="Enter pan number">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Tan Number</label>
                          <input type="text" name="tan_number" class="form-control" placeholder="Enter Tan Number">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Name Of Deductor</label>
                          <input type="text" name="deductor" class="form-control" placeholder="Enter Name Deductor">
                        </div>
                        <div class="mb-3">
                          <label class="form-label">Group/Subgroup</label>
                          <select name="group_id" class="form-control" required>
                            <option value="">Select Group</option>
                            @foreach ($groups as $group)
                        <option value="{{ $group->id }}"> {{ $group->group_name }}
                          {{ $group->parent->group_name ?? '' }}</option>
                      @endforeach
                          </select>
                        </div>
                        <h5>🏦 Bank Details</h5>

                        <div class="mb-3">
                          <label class="form-label">🏦 Bank Name</label>
                          <input type="text" name="bank_name" class="form-control" required
                            placeholder="Enter Bank Name">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">👤 Account Holder Name</label>
                          <input type="text" name="account_holder_name" class="form-control" required
                            placeholder="Enter Account Holder Name">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">💳 Account Number</label>
                          <input type="text" name="account_number" class="form-control" required
                            placeholder="Enter Account Number">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">🔢 IFSC Code</label>
                          <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" required
                            placeholder="Enter IFSC Code" oninput="this.value = this.value.toUpperCase()">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">🏢 Branch</label>
                          <input type="text" name="branch" class="form-control" required
                            placeholder="Enter Branch Name">
                        </div>

                        <div class="mb-3">
                          <label class="form-label">📂 Account Type</label>
                          <select name="account_type" class="form-control" required>
                            <option value="">Select Account Type</option>
                            <option value="savings">💰 Savings</option>
                            <option value="current">🏦 Current</option>
                          </select>
                        </div>

                     </div>
                     <!-- Address & GST -->
                     <div class="col-md-6">
                        <h5>🏠 Location</h5>
                        <!-- Address Section -->
                        <div id="addressContainer">
                          <div class="mb-3 address-group">
                            <label for="state" class="form-label">State</label>
                          <select class="form-control" id="state" name="address[0][state]">
                            <option value="">Select State</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Assam">Assam</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="Goa">Goa</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Ladakh">Ladakh</option>
                            <option value="Puducherry">Puducherry</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and
                              Daman and Diu</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                          </select>
                          <BR>
                            <input type="text" name="address[0][city]" class="form-control mb-2"
                              placeholder="Location" required>
                            <input type="text" name="address[0][gstin]" class="form-control mb-2"
                              placeholder="GSTIN" required>
                            <input type="text" name="address[0][billing_address]" class="form-control mb-2"
                              placeholder="Billing Address" required>
                            <input type="text" name="address[0][consignment_address]" class="form-control mb-2"
                              placeholder="Consignment Address1" required>
                              <input type="text" name="address[0][consignment_address2]" class="form-control mb-2"
                              placeholder="Consignment Address 2" required>
                            <input type="text" name="address[0][mobile_number]" class="form-control mb-2"
                              placeholder="Mobile Number" required>
                            <input type="text" name="address[0][email]" class="form-control mb-2"
                              placeholder="Email" required>
                            <input type="text" name="address[0][poc]" class="form-control mb-2"
                              placeholder="Point Of Contact" required>
                            <button type="button" class="btn btn-success" onclick="addAddress()">➕ Add
                              More</button>
                          </div>
                        </div>
                     </div>
                   </div>
                   <div class="row">
                     <!-- Submit Button -->
                     <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Save Ledger Master</button>
                     </div>
                   </div>
                 </div>
               </form>
            </div>
          </div>
        </div>
        <!-- View Customer Details Section -->

        <div class="row view-form" style="display: none;">
          <div class="col-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                  <h4>📑 Customer Details View</h4>
                  <p>Review full details of the customer.</p>
                </div>
                <button class="btn" id="backToListFromCustomerView"
                  style="background-color: #ca2639; color: white; border: none;">
                  ⬅ Back to Listing
                </button>
              </div>

              <div class="card-body">
                <!-- ✅ Main 2 Column Grid -->
                <div class="row">
                  <!-- LEFT COLUMN -->
                  <div class="col-md-6">
                    <p>👤 <strong>Customer Name:</strong> <span id="viewCustomerName"></span></p>
                    <p>🗂️ <strong>Group Name:</strong> <span id="viewCustomerGroup"></span></p>
                    <p>✅ <strong>Deductor:</strong> <span id="viewCustomerDeductor"></span></p>
                    <p>📄 <strong>PAN Number:</strong> <span id="viewCustomerPAN"></span></p>
                    <p>🪪 <strong>TAN Number:</strong> <span id="viewCustomerTAN"></span></p>
                    <p>✉️ <strong>Email:</strong> <span id="viewCustomerEmail"></span></p>
                  </div>

                  <!-- RIGHT COLUMN -->
                  <div class="col-md-6">
                    <h6>🏦 <strong>Bank Details</strong></h6>
                    <p>🏛️ <strong>Bank Name:</strong> <span id="viewBankName"></span></p>
                    <p>👥 <strong>Account Holder:</strong> <span id="viewAccountHolderName"></span></p>
                    <p>🔢 <strong>Account Number:</strong> <span id="viewAccountNumber"></span></p>
                    <p>🏬 <strong>Branch:</strong> <span id="viewBranch"></span></p>
                    <p>🆔 <strong>IFSC Code:</strong> <span id="viewIFSC"></span></p>
                    <p>📑 <strong>Account Type:</strong> <span id="viewAccountType"></span></p>
                  </div>
                </div>

                <!-- ✅ Addresses Block -->
                <hr>
                <h6>🏠 <strong>Addresses</strong></h6>
                <div id="viewCustomerAddresses"></div>
              </div>
            </div>
          </div>
        </div>



      <!-- container-fluid -->
   </div>
   <!-- edit -->
   <!-- edit modal -->
   <!-- Edit Customer Modal -->
   <div class="modal fade" id="editCustomerModal" tabindex="-1" aria-labelledby="editCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-between align-items-center">
        <div>
          <h5 class="modal-title" id="editCustomerModalLabel">🧑‍💼 Edit Ledger Master Details</h5>
          <p>Update the details for the Ledger Master.</p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      @if(isset($user))
      <form id="editCustomerForm" method="POST" action="">
        @csrf
        <input type="hidden" id="editCustomerId" name="id" value="{{ $user->id }}">

        <div class="modal-body">
          <div class="row">
            <!-- Ledger Master Info -->
            <div class="col-md-6">
              <h5>👤 Ledger Master Information</h5>

              <div class="mb-3">
                <label for="editCustomerName" class="form-label">Ledger Master Name</label>
                <input type="text" class="form-control" id="editCustomerName" name="name" value="{{ $user->name ?? '' }}">
              </div>

              <div class="mb-3">
                <label for="editEmailName" class="form-label">Ledger Email</label>
                <input type="email" class="form-control" id="editEmailName" name="email" value="{{ $user->email ?? '' }}">
              </div>

              <div class="mb-3">
                <label for="editCustomerPan" class="form-label">PAN Number</label>
                <input type="text" class="form-control" id="editCustomerPan" name="pan_number" value="{{ $user->pan_number ?? '' }}" placeholder="Enter PAN Number">
              </div>

              <div class="mb-3">
                <label for="editCustomerTan" class="form-label">TAN Number</label>
                <input type="text" class="form-control" id="editCustomerTan" name="tan_number" value="{{ $user->tan_number ?? '' }}" placeholder="Enter TAN Number">
              </div>

              <div class="mb-3">
                <label for="editCustomerDeductor" class="form-label">Deductor</label>
                <input type="text" class="form-control" id="editCustomerDeductor" name="deductor" value="{{ $user->deductor ?? '' }}" placeholder="Enter Deductor">
              </div>

              <div class="mb-3">
                <label class="form-label">Group/Subgroup</label>
                <select name="group_id" class="form-control" required>
                  <option value="">Select Group</option>
                  @foreach ($groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id', $user->group_id) == $group->id ? 'selected' : '' }}>
                      {{ $group->group_name }} @if ($group->parent) ({{ $group->parent->group_name }}) @endif
                    </option>
                  @endforeach
                </select>
              </div>

              <h5>🏦 Bank Details</h5>

              <div class="mb-3">
                <label class="form-label">🏦 Bank Name</label>
                <input type="text" id="editbank_name" name="bank_name" class="form-control" value="{{ $user->bank_name ?? '' }}" placeholder="Enter Bank Name">
              </div>

              <div class="mb-3">
                <label class="form-label">👤 Account Holder Name</label>
                <input type="text" id="editaccount_holder_name" name="account_holder_name" class="form-control" value="{{ $user->account_holder_name ?? '' }}" placeholder="Enter Account Holder Name">
              </div>

              <div class="mb-3">
                <label class="form-label">💳 Account Number</label>
                <input type="text" name="account_number" class="form-control" value="{{ $user->account_number ?? '' }}" placeholder="Enter Account Number">
              </div>

              <div class="mb-3">
                <label class="form-label">🔢 IFSC Code</label>
                <input type="text" name="ifsc_code" id="ifsc_code" class="form-control" value="{{ $user->ifsc_code ?? '' }}" placeholder="Enter IFSC Code" oninput="this.value = this.value.toUpperCase()">
              </div>

              <div class="mb-3">
                <label class="form-label">🏢 Branch</label>
                <input type="text" name="branch" class="form-control" value="{{ $user->branch ?? '' }}" placeholder="Enter Branch Name">
              </div>

              <div class="mb-3">
                <label class="form-label">📂 Account Type</label>
                <select name="account_type" class="form-control">
                  <option value="">Select Account Type</option>
                  <option value="savings" {{ old('account_type', $user->account_type) == 'savings' ? 'selected' : '' }}>💰 Savings</option>
                  <option value="current" {{ old('account_type', $user->account_type) == 'current' ? 'selected' : '' }}>🏦 Current</option>
                </select>
              </div>
            </div>

            <!-- Addresses -->
            <div class="col-md-6">
              <h5>🏠 Addresses</h5>
              <div id="edit-address-container">
                @php $addresses = old('address', $user->address ?? []); @endphp
                @foreach ($addresses as $index => $address)
                  <div class="address-block border p-3 mb-3" data-index="{{ $index }}">
                    <h6>Address</h6>
                    <div class="mb-3">
                      <label class="form-label">State</label>
                     <select class="form-control" name="address[{{ $index }}][state]">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">City</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][city]" value="{{ $address['city'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">GSTIN</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][gstin]" value="{{ $address['gstin'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Billing Address</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][billing_address]" value="{{ $address['billing_address'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Consignment Address</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][consignment_address]" value="{{ $address['consignment_address'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Consignment Address 2</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][consignment_address2]" value="{{ $address['consignment_address2'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Mobile Number</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][mobile_number]" value="{{ $address['mobile_number'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Point Of Contact</label>
                      <input type="text" class="form-control" name="address[{{ $index }}][poc]" value="{{ $address['poc'] ?? '' }}">
                    </div>

                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" class="form-control" name="address[{{ $index }}][email]" value="{{ $address['email'] ?? '' }}">
                    </div>

                    <button type="button" class="btn btn-danger btn-sm remove-address-btn mt-2">Remove</button>
                  </div>
                @endforeach
              </div>

              <button type="button" class="btn btn-sm btn-secondary mt-2" id="EditAddresstBtn">Add More</button>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Ledger Master</button>
        </div>
      </form>
      @endif
    </div>
  </div>
</div>

   <!-- edit modal -->
   <!-- Delete Confirmation Modal -->
   <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteUserLabel">Delete User</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            Are you sure you want to delete this user?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
          </div>
        </div>
      </div>
   </div>
 <script>
document.addEventListener("DOMContentLoaded", function () {
  let editAddressIndex = 0;

  // ✅ Function to generate Address Block
  function generateAddressHTML(index, address = {}) {
    return `
      <div class="address-block border p-3 mb-3" data-index="${index}">
        <h6>Address</h6>
        <div class="mb-3">
          <label class="form-label">State</label>
          <select class="form-control" name="address[${index}][state]">
          
                          <option value="">Select State</option>
                          <option value="Madhya Pradesh" {{ $address['state'] == 'Madhya Pradesh' ? 'selected' : '' }}>Madhya Pradesh</option>
                          <option value="Uttar Pradesh" {{ $address['state'] == 'Uttar Pradesh' ? 'selected' : '' }}>Uttar Pradesh</option>
                          <option value="Maharashtra" {{ $address['state'] == 'Maharashtra' ? 'selected' : '' }}>Maharashtra</option>
                          <option value="Rajasthan" {{ $address['state'] == 'Rajasthan' ? 'selected' : '' }}>Rajasthan</option>
                          <option value="Gujarat" {{ $address['state'] == 'Gujarat' ? 'selected' : '' }}>Gujarat</option>
                          <option value="Delhi" {{ $address['state'] == 'Delhi' ? 'selected' : '' }}>Delhi</option>
                          <option value="Punjab" {{ $address['state'] == 'Punjab' ? 'selected' : '' }}>Punjab</option>
                          <option value="Haryana" {{ $address['state'] == 'Haryana' ? 'selected' : '' }}>Haryana</option>
                          <option value="Karnataka" {{ $address['state'] == 'Karnataka' ? 'selected' : '' }}>Karnataka</option>
                          <option value="Tamil Nadu" {{ $address['state'] == 'Tamil Nadu' ? 'selected' : '' }}>Tamil Nadu</option>
                          <option value="Kerala" {{ $address['state'] == 'Kerala' ? 'selected' : '' }}>Kerala</option>
                          <option value="Bihar" {{ $address['state'] == 'Bihar' ? 'selected' : '' }}>Bihar</option>
                          <option value="Jharkhand" {{ $address['state'] == 'Jharkhand' ? 'selected' : '' }}>Jharkhand</option>
                          <option value="West Bengal" {{ $address['state'] == 'West Bengal' ? 'selected' : '' }}>West Bengal</option>
                          <option value="Andhra Pradesh" {{ $address['state'] == 'Andhra Pradesh' ? 'selected' : '' }}>Andhra Pradesh</option>
                          <option value="Telangana" {{ $address['state'] == 'Telangana' ? 'selected' : '' }}>Telangana</option>
                          <option value="Odisha" {{ $address['state'] == 'Odisha' ? 'selected' : '' }}>Odisha</option>
                          <option value="Chhattisgarh" {{ $address['state'] == 'Chhattisgarh' ? 'selected' : '' }}>Chhattisgarh</option>
                          <option value="Assam" {{ $address['state'] == 'Assam' ? 'selected' : '' }}>Assam</option>
                          <option value="Himachal Pradesh" {{ $address['state'] == 'Himachal Pradesh' ? 'selected' : '' }}>Himachal Pradesh</option>
                          <option value="Uttarakhand" {{ $address['state'] == 'Uttarakhand' ? 'selected' : '' }}>Uttarakhand</option>
                          <option value="Goa" {{ $address['state'] == 'Goa' ? 'selected' : '' }}>Goa</option>
                          <option value="Tripura" {{ $address['state'] == 'Tripura' ? 'selected' : '' }}>Tripura</option>
                          <option value="Meghalaya" {{ $address['state'] == 'Meghalaya' ? 'selected' : '' }}>Meghalaya</option>
                          <option value="Manipur" {{ $address['state'] == 'Manipur' ? 'selected' : '' }}>Manipur</option>
                          <option value="Nagaland" {{ $address['state'] == 'Nagaland' ? 'selected' : '' }}>Nagaland</option>
                          <option value="Mizoram" {{ $address['state'] == 'Mizoram' ? 'selected' : '' }}>Mizoram</option>
                          <option value="Sikkim" {{ $address['state'] == 'Sikkim' ? 'selected' : '' }}>Sikkim</option>
                          <option value="Arunachal Pradesh" {{ $address['state'] == 'Arunachal Pradesh' ? 'selected' : '' }}>Arunachal Pradesh</option>
                          <option value="Jammu and Kashmir" {{ $address['state'] == 'Jammu and Kashmir' ? 'selected' : '' }}>Jammu and Kashmir</option>
                          <option value="Ladakh" {{ $address['state'] == 'Ladakh' ? 'selected' : '' }}>Ladakh</option>
                          <option value="Puducherry" {{ $address['state'] == 'Puducherry' ? 'selected' : '' }}>Puducherry</option>
                          <option value="Chandigarh" {{ $address['state'] == 'Chandigarh' ? 'selected' : '' }}>Chandigarh</option>
                          <option value="Andaman and Nicobar Islands" {{ $address['state'] == 'Andaman and Nicobar Islands' ? 'selected' : '' }}>Andaman and Nicobar Islands</option>
                          <option value="Dadra and Nagar Haveli and Daman and Diu" {{ $address['state'] == 'Dadra and Nagar Haveli and Daman and Diu' ? 'selected' : '' }}>Dadra and Nagar Haveli and Daman and Diu</option>
                          <option value="Lakshadweep" {{ $address['state'] == 'Lakshadweep' ? 'selected' : '' }}>Lakshadweep</option>
                        </select>

        </div>
        <div class="mb-3">
          <label class="form-label">City</label>
          <input type="text" class="form-control" name="address[${index}][city]" value="${address.city || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">GSTIN</label>
          <input type="text" class="form-control" name="address[${index}][gstin]" value="${address.gstin || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Billing Address</label>
          <input type="text" class="form-control" name="address[${index}][billing_address]" value="${address.billing_address || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Consignment Address</label>
          <input type="text" class="form-control" name="address[${index}][consignment_address]" value="${address.consignment_address || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Consignment Address2</label>
          <input type="text" class="form-control" name="address[${index}][consignment_address2]" value="${address.consignment_address2 || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Mobile Number</label>
          <input type="text" class="form-control" name="address[${index}][mobile_number]" value="${address.mobile_number || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Point Of Contact</label>
          <input type="text" class="form-control" name="address[${index}][poc]" value="${address.poc || ''}">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="address[${index}][email]" value="${address.email || ''}">
        </div>
        <button type="button" class="btn btn-danger btn-sm remove-address-btn mt-2">Remove</button>
      </div>
    `;
  }

  // ✅ Attach edit button logic
  document.querySelectorAll(".edit-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = this.closest("tr");

      // 📌 Get main fields
      const customerId = row.children[0].innerText.trim();
      const customerName = row.children[1].innerText.trim();
      const panNumber = row.getAttribute("data-pan") || "";
      const tanNumber = row.getAttribute("data-tan") || "";
      const email = row.getAttribute("data-email") || "";
      const groupId = row.getAttribute("data-group-id") || "";
      const deductor = row.getAttribute("data-deductor") || "";

      // ✅ BANK DETAILS (make sure your <tr> has these attributes!)
      const accountNumber = row.getAttribute("data-account-number") || "";
      const accountHolderName = row.getAttribute("data-account-holder-name") || "";
      const bankName = row.getAttribute("data-bank-name") || "";
      const branch = row.getAttribute("data-branch") || "";
      const ifscCode = row.getAttribute("data-ifsc-code") || "";
      const accountType = row.getAttribute("data-account-type") || "";

      const addressJSON = row.getAttribute("data-address") || "[]";

      // ✅ Fill modal fields
      document.getElementById("editCustomerId").value = customerId;
      document.getElementById("editCustomerName").value = customerName;
      document.getElementById("editCustomerPan").value = panNumber;
      document.getElementById("editCustomerTan").value = tanNumber;
      document.getElementById("editEmailName").value = email;
      document.getElementById("editCustomerDeductor").value = deductor;
      document.querySelector("select[name='group_id']").value = groupId;

      // ✅ Bank Details fields
      document.getElementById("editbank_name").value = bankName;
      document.getElementById("editaccount_holder_name").value = accountHolderName;
      document.querySelector("input[name='account_number']").value = accountNumber;
      document.getElementById("ifsc_code").value = ifscCode;
      document.querySelector("input[name='branch']").value = branch;
      document.querySelector("select[name='account_type']").value = accountType;

      // ✅ Clear old addresses
      const container = document.getElementById("edit-address-container");
      container.innerHTML = '';
      editAddressIndex = 0;

      // ✅ Add addresses
      try {
        const addresses = JSON.parse(addressJSON);
        if (Array.isArray(addresses)) {
          addresses.forEach((address, index) => {
            container.insertAdjacentHTML("beforeend", generateAddressHTML(index, address));
            editAddressIndex++;
          });
        }
      } catch (e) {
        console.error("Invalid address JSON", e);
      }

      // ✅ Set form action
      const updateUrl = "{{ route('admin.users.update', ':id') }}".replace(":id", customerId);
      document.getElementById("editCustomerForm").setAttribute("action", updateUrl);

      // ✅ Show modal
      const modal = new bootstrap.Modal(document.getElementById("editCustomerModal"), {
        keyboard: false
      });
      modal.show();
    });
  });

  // ✅ Remove Address
  document.getElementById("edit-address-container").addEventListener("click", function (e) {
    if (e.target.classList.contains("remove-address-btn")) {
      e.target.closest(".address-block").remove();
    }
  });

  // ✅ Add More Address
  document.getElementById("EditAddresstBtn").addEventListener("click", function () {
    const container = document.getElementById("edit-address-container");
    container.insertAdjacentHTML("beforeend", generateAddressHTML(editAddressIndex));
    editAddressIndex++;
  });
});
</script>



   <!-- edit -->

 <script>
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".view-btn").forEach(function (btn) {
    btn.addEventListener("click", function () {
      const row = this.closest("tr");

      // Basic Info
      const customerName = row.children[1].innerText.trim();
      const groupName = row.children[2].innerText.trim();
      const panNumber = row.getAttribute("data-pan") || '';
      const tanNumber = row.getAttribute("data-tan") || '';
      const email = row.getAttribute("data-email") || '';
      const deductor = row.getAttribute("data-deductor") || '';

      // Bank Details
      const accountNumber = row.getAttribute("data-account-number") || '';
      const accountHolderName = row.getAttribute("data-account-holder-name") || '';
      const bankName = row.getAttribute("data-bank-name") || '';
      const branch = row.getAttribute("data-branch") || '';
      const ifscCode = row.getAttribute("data-ifsc-code") || '';
      const accountType = row.getAttribute("data-account-type") || '';

      // Addresses
      let addressHTML = '';
      const addressJSON = row.getAttribute("data-address") || "[]";
      try {
        const addresses = JSON.parse(addressJSON);
        if (Array.isArray(addresses) && addresses.length > 0) {
          addresses.forEach((addr, idx) => {
            addressHTML += `
              <div class="border p-2 mb-2">
                <strong>Address ${idx + 1}</strong><br>
                <b>State:</b> ${addr.state || ''} <br>
                <b>City:</b> ${addr.city || ''} <br>
                <b>GSTIN:</b> ${addr.gstin || ''} <br>
                <b>Billing Address:</b> ${addr.billing_address || ''} <br>
                <b>Consignment Address:</b> ${addr.consignment_address || ''} <br>
                <b>Consignment Address2:</b> ${addr.consignment_address2 || ''} <br>
                <b>Mobile:</b> ${addr.mobile_number || ''} <br>
                <b>POC:</b> ${addr.poc || ''} <br>
                <b>Email:</b> ${addr.email || ''} <br>
              </div>
            `;
          });
        } else {
          addressHTML = "<p>No addresses available.</p>";
        }
      } catch (e) {
        addressHTML = "<p>Invalid address data.</p>";
      }

      // Fill View
      document.getElementById("viewCustomerName").innerText = customerName;
      document.getElementById("viewCustomerGroup").innerText = groupName;
      document.getElementById("viewCustomerDeductor").innerText = deductor;
      document.getElementById("viewCustomerPAN").innerText = panNumber;
      document.getElementById("viewCustomerTAN").innerText = tanNumber;
      document.getElementById("viewCustomerEmail").innerText = email;

      document.getElementById("viewBankName").innerText = bankName;
      document.getElementById("viewAccountHolderName").innerText = accountHolderName;
      document.getElementById("viewAccountNumber").innerText = accountNumber;
      document.getElementById("viewBranch").innerText = branch;
      document.getElementById("viewIFSC").innerText = ifscCode;
      document.getElementById("viewAccountType").innerText = accountType;

      document.getElementById("viewCustomerAddresses").innerHTML = addressHTML;

      // Show View, Hide List
      document.querySelector(".listing-form").style.display = "none";
      document.querySelector(".view-form").style.display = "block";
    });
  });

  // Back Button
  document.getElementById("backToListFromCustomerView").addEventListener("click", function () {
    document.querySelector(".view-form").style.display = "none";
    document.querySelector(".listing-form").style.display = "block";
  });
});
</script>

   <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Get references to sections
        const listingForm = document.querySelector(".listing-form");
        const addForm = document.querySelector(".add-form");
        const viewForm = document.querySelector(".view-form");

        // Get references to buttons
        const addCustomerBtn = document.getElementById("addCustomerBtn");
        const backToListBtn = document.getElementById("backToListBtn");
        const backToListFromCustomerView = document.getElementById("backToListFromCustomerView");

        // Get all view buttons
        const viewButtons = document.querySelectorAll(".view-btn");

        // Default: Show only the listing page
        addForm.style.display = "none";
        viewForm.style.display = "none";

        // Open Add Customer Form
        addCustomerBtn.addEventListener("click", function () {
          listingForm.style.display = "none";
          addForm.style.display = "block";
        });

        // Go Back to Customer Listing from Add Form
        backToListBtn.addEventListener("click", function () {
          addForm.style.display = "none";
          listingForm.style.display = "block";
        });

        // Open View Customer Details Page
        viewButtons.forEach(button => {
          button.addEventListener("click", function () {
            const row = this.closest(".customer-row"); // Get the row

            document.getElementById("viewCustomerName").textContent = row.children[1].textContent;
            document.getElementById("viewCustomerPhone").textContent = row.children[2].textContent;
            document.getElementById("viewCustomerEmail").textContent = row.children[3].textContent;
            document.getElementById("viewCustomerGST").textContent = row.children[4].textContent;


            listingForm.style.display = "none";
            viewForm.style.display = "block";
          });
        });

        // Go Back to Customer Listing from View Page
        backToListFromCustomerView.addEventListener("click", function () {
          viewForm.style.display = "none";
          listingForm.style.display = "block";
        });
      });
   </script>
   <script>
      let addressIndex = 1;

      function addAddress() {
        let container = document.getElementById("addressContainer");
        let div = document.createElement("div");
        div.classList.add("mb-3", "address-group");
        div.innerHTML = `
         <label for="state" class="form-label">State</label>
                          <select class="form-control" id="state" name="address[${addressIndex}][state]">
                            <option value="">Select State</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="West Bengal">West Bengal</option>
                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Assam">Assam</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="Goa">Goa</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Ladakh">Ladakh</option>
                            <option value="Puducherry">Puducherry</option>
                            <option value="Chandigarh">Chandigarh</option>
                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                            <option value="Dadra and Nagar Haveli and Daman and Diu">Dadra and Nagar Haveli and
                              Daman and Diu</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                          </select>
                          <br>
               <input type="text" name="address[${addressIndex}][city]" class="form-control mb-2" placeholder="Location" required>
               <input type="text" name="address[${addressIndex}][gstin]" class="form-control mb-2" placeholder="GSTIN" required>
               <input type="text" name="address[${addressIndex}][billing_address]" class="form-control mb-2" placeholder="Billing Address" required>
               <input type="text" name="address[${addressIndex}][consignment_address]" class="form-control mb-2" placeholder="Consignment Address"required>
               <input type="text" name="address[${addressIndex}][consignment_address2]" class="form-control mb-2" placeholder="Consignment Address"required>
               <input type="text" name="address[${addressIndex}][mobile_number]" class="form-control mb-2" placeholder="Mobile Number" required>
               <input type="text" name="address[${addressIndex}][email]" class="form-control mb-2"  placeholder="Email" required>
               <input type="text" name="address[${addressIndex}][poc]" class="form-control mb-2" placeholder="Point Of Contact" required>
               <button type="button" class="btn btn-danger" onclick="removeElement(this)">❌ Remove</button>
            `;
        container.appendChild(div);
        addressIndex++;
      }

      function removeElement(btn) {
        btn.parentElement.remove();
      }


   </script>
   <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
   <script>
      $(document).ready(function () {
        let deleteId = null;

        // Open Delete Modal & Get ID
        $('.delete-btn').on('click', function () {
          deleteId = $(this).data('id');
        });

        // Confirm Delete


        $('#confirmDelete').on('click', function () {
          $.ajax({
            url: `/admin/users/delete/${deleteId}`,
            type: 'DELETE',
            data: {
               _token: '{{ csrf_token() }}'
            },
            success: function (response) {
               alert('Users deleted successfully!');
               location.reload();
            },
            error: function (error) {
               alert('Error deleting user.');
            }
          });
        });
      });
   </script>
   <!-- delete -->
@endsection