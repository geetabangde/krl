@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Vehicle Details Page -->
        <div class="view-vehicle-form">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h4>🚗 Vehicle Details View</h4>
                        <p class="mb-0">View details for the vehicle.</p>
                    </div>
                    <a href="{{ route('admin.vehicles.index') }}" class="btn" id="backToListBtn"
                        style="background-color: #ca2639; color: white; border: none;">
                        ⬅ Back to Listing
                    </a>
                </div>
                <div class="card-body">
                    <h4>🚘 Vehicle Information</h4>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>🚗 Vehicle Type:</strong> {{ $vehicle->vehicle_type }}</div>
                        <div class="col-md-4"><strong>🔢 Vehicle Number:</strong> {{ $vehicle->vehicle_no }}</div>
                        <div class="col-md-4"><strong>📞 Registered Mobile Number:</strong> {{ $vehicle->registered_mobile_number }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>⚖️ GVW:</strong> {{ $vehicle->gvw ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>📦 Payload:</strong> {{ $vehicle->payload ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🔧 Chassis Number:</strong> {{ $vehicle->chassis_number ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4"><strong>🛠️ Engine Number:</strong> {{ $vehicle->engine_number ?? 'N/A' }}</div>
                        <div class="col-md-4"><strong>🚪 Number of Tyres:</strong> {{ $vehicle->number_of_tyres ?? 'N/A' }}</div>
                    </div>

                    <hr class="my-4">

                    <h4>📁 Vehicle Documents</h4>
                    @php
                        $documents = [
                            'rc_document_file' => ['label' => '📄 RC', 'valid_from' => $vehicle->rc_valid_from, 'valid_till' => $vehicle->rc_valid_till],
                            'fitness_certificate' => ['label' => '🏋️ Fitness Certificate', 'valid_from' => null, 'valid_till' => $vehicle->fitness_valid_till],
                            'insurance_document' => ['label' => '🛡️ Insurance', 'valid_from' => $vehicle->insurance_valid_from, 'valid_till' => $vehicle->insurance_valid_till],
                            'authorization_permit' => ['label' => '📝 Authorization Permit', 'valid_from' => $vehicle->auth_permit_valid_from, 'valid_till' => $vehicle->auth_permit_valid_till],
                            'national_permit' => ['label' => '🌐 National Permit', 'valid_from' => $vehicle->national_permit_valid_from, 'valid_till' => $vehicle->national_permit_valid_till],
                            'tax_document' => ['label' => '💰 Tax Document', 'valid_from' => $vehicle->tax_valid_from, 'valid_till' => $vehicle->tax_valid_till],
                        ];
                    @endphp

                    <div class="row">
                        @foreach($documents as $field => $doc)
                            @if(!empty($vehicle->$field))
                                <div class="col-md-4 mb-3">
                                    <div class="border rounded p-3 h-100">
                                        <p><strong>{{ $doc['label'] }}:</strong></p>
                                        <p><strong>Valid From:</strong> {{ $doc['valid_from'] ? \Carbon\Carbon::parse($doc['valid_from'])->format('d-m-Y') : 'N/A' }}</p>
                                        <p><strong>Valid Till:</strong> {{ $doc['valid_till'] ? \Carbon\Carbon::parse($doc['valid_till'])->format('d-m-Y') : 'N/A' }}</p>
                                     
                                     <button type="button" class="btn btn-outline-info openImageModal w-100"
                                        data-image="{!! asset('storage/' . $vehicle->$field) !!}" data-bs-toggle="modal"
                                        data-bs-target="#imageModal">
                                        📷 View {{ $doc['label'] }}
                                    </button>
                                       
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Optional Image Modal --}}
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Document Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="modalImage" src="" alt="Document" class="img-fluid" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
   $(document).on('click', '.openImageModal', function () {
    const imageUrl = $(this).attr('data-image'); // or use .attr() instead of .data()
    console.log("Image to load:", imageUrl);
    $('#modalImage').attr('src', imageUrl);
});
</script>
@endsection
