@extends('admin.layouts.app')
@section('content')
<div class="page-content">
    <div class="container-fluid">
        <div class="row add form">
        <div class="col-12">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4>🚛 Group Details</h4>
            </div>
            <a href="{{ route('admin.group.index') }}" class="btn" id="backToListBtn"
                style="background-color: #ca2639; color: white; border: none;">
                ⬅ Back to Listing
            </a>
        </div>
        <form action="{{ route('admin.group.update', ['id' => $group->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Row 1: Group Name & Sub Group -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Group Name</label>
                        <input type="text" name="group_name" class="form-control" value="{{ $group->group_name }}" placeholder="Group">
                    </div>
                </div>
                <!-- <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Sub Group (optional)</label>
                        <input type="text" name="sub_group" class="form-control" value="{{ $group->sub_group }}" placeholder="Sub Group">
                    </div>
                </div> -->
            </div>

            <!-- Row 2: Parent Group Dropdown -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Parent Sub Group (optional)</label>
                        <select name="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach($parentGroups as $parent)
                                <option value="{{ $parent->id }}" {{ $group->parent_id == $parent->id ? 'selected' : '' }}>
                                    {{ $parent->group_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Row 3: Status Dropdown -->
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-control" required>
                            <option value="1" {{ $group->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $group->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-end">
                <button class="btn btn-primary">Save Group</button>
            </div>
        </form>
    </div>
</div>

        </div>  
    </div>
</div>
@endsection