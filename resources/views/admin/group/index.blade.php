@extends('admin.layouts.app')
@section('content')
<div class="page-content">
<div class="container-fluid">
  <!-- start page title -->
  <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0 font-size-18">Group</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Group</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Group Listing Page -->
                    <div class="row group-listing-form">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">📁 Group List</h4>
                                        <p class="card-title-desc">View, edit, or delete group details below.</p>
                                    </div>
                                     <a href="{{ route('admin.group.create') }}" class="btn" id="addGroupBtn"
                                        style="background-color: #ca2639; color: white; border: none;">
                                        <i class="fas fa-plus"></i> Add
                                    </a>
                                </div>
                                <div class="card-body">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Group Name</th>
                                                <th>Parent Group</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                                @foreach($groups as $index => $group)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $group->group_name }}</td>
                                                    <td>{{ $group->parent->group_name ?? '-' }}</td>
                                                    <td>
                                                        @if($group->status == 1)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <a href="{{ route('admin.group.view', $group->id) }}" class="btn btn-sm btn-light view-group-btn">
                                                                <i class="fas fa-eye text-primary"></i>
                                                            </a>

                                                            <a href="{{ route('admin.group.edit', $group->id) }}" class="btn btn-sm btn-light edit-btn">
                                                                <i class="fas fa-pen text-warning"></i>
                                                            </a>

                                                            <a href="{{ route('admin.group.delete', $group->id) }}" class="btn btn-sm btn-light delete-btn" onclick="return confirm('Are you sure to delete this group?')">
                                                                <i class="fas fa-trash text-danger"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                        </tbody>

                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
      </div> <!-- container-fluid -->
</div>
            <!-- End Page-content -->

@endsection
