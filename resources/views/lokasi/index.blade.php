@extends('layouts.app')

@section('title', 'Daftar Lokasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Lokasi</h3>
        <div class="card-tools">
            <a href="{{ route('lokasi.create') }}" class="btn btn-primary">Tambah Lokasi</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="lokasiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
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
        var table = $('#lokasiTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('lokasi.tableDataAdmin') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'nama', name: 'nama' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'Action', name: 'Action', orderable: false, searchable: false }
            ]
        });

        function deleteData(id) {
            Swal.fire({
                title: "Yakin ingin menghapus?",
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('lokasi.destroy', ':id') }}'.replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire('Dihapus!', response.msg, 'success').then(() => {
                                    table.ajax.reload(); 
                                });
                            } else {
                                Swal.fire('Error', response.msg, 'error');
                            }
                        },
                        error: function(xhr) {
                            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                        }
                    });
                }
            });
        }

        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id'); 
            deleteData(id);
        });
    });
</script>
@endsection
