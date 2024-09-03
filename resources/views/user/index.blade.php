@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tabel Data User</h3>
        <div class="card-tools">
            <a href="{{ route('user.create') }}" class="btn btn-primary">Tambah User</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="userTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('user.tableDataAdmin') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'Action', name: 'Action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endsection
