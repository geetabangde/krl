@extends('admin.layouts.app')
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Add Group Form -->
            <div class="row group-add-form" >
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4>📁 Add Group</h4>
                                        <p>Enter details for the new group below.</p>
                                    </div>
                                    <a href="{{ route('admin.group.index') }}" class="btn backToGroupListBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        ⬅ Back
                                    </a>
                                </div>
                                <form method="POST" action="{{ route('admin.group.store') }}">
    @csrf
    <div class="card-body">
        <div class="row">
            {{-- Category Title as Group Name --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Category Title (Main Group)</label>
                    <input type="text" class="form-control" name="group_name" placeholder="Enter category title" required>
                </div>
            </div>

            {{-- Parent Group Dropdown as Sub Group --}}
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">Parent Sub Group (Optional)</label>
                    <select name="parent_id" class="form-control">
                        <option value="">None (Create Main Group)</option>
                        @foreach ($groups as $group)
                            <option value="{{ $group->id }}">{{ $group->group_name }}</option>
                        @endforeach
                    </select>
                    <small class="text-muted">Select None to create a parent category</small>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button class="btn btn-primary">Save Group</button>
        </div>
    </div>
</form>

                            </div>
                        </div>
                    </div>
        </div>
    </div>


@endsection