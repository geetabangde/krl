@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <!-- View Group Details -->
            <div class="row group-view-form">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>📄 View Group Details</h4>
                                <p>Below are the details of the selected group.</p>
                            </div>
                            <a href="{{ route('admin.group.index') }}" class="btn backToGroupListBtn"
                                style="background-color: #ca2639; color: white; border: none;">
                                ⬅ Back
                            </a>
                        </div>
                        <div class="card-body">
                            <p><strong>Group Name:</strong> <span id="viewGroupName">{{ $group->group_name }}</span></p>
                            <p><strong>Sub Group:</strong> <span id="viewSubGroupName">{{ $group->parent->group_name ?? 'No Parent' }}</span></p>
                        </div>
                    </div>
                </div>
            </div>              
    </div>
</div>
@endsection