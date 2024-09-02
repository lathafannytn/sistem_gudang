@extends('layouts.app')

@section('title', 'Data Barang')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Tabel Data Barang</h3>
            <div class="card-tools">
                <a href="{{ route('barang.create') }}" class="btn btn-primary">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Kategori</th>
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
    $('#example1').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('barang.tableDataAdmin') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false }, 
            { data: 'Kode', name: 'Kode' }, 
            { data: 'Nama', name: 'Nama' },  
            { data: 'Stok', name: 'Stok' },
            { data: 'Deskripsi', name: 'Deskripsi' },
            { data: 'Kategori', name: 'Kategori' },
            { data: 'Lokasi', name: 'Lokasi' },
            { data: 'Action', name: 'Action', orderable: false, searchable: false }
        ]
    });

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
                url: '{{ route('barang.destroy', ':id') }}'.replace(':id', id),
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire('Dihapus!', response.msg, 'success').then(() => {
                            $('#example1').DataTable().ajax.reload();
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
</script>
@endsection
