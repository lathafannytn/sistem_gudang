@extends('layouts.app')

@section('title', 'Data Mutasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tabel Data Mutasi</h3>
        <div class="card-tools">
            <a href="{{ route('mutasi.create') }}" class="btn btn-primary">Tambah Mutasi</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="mutasiTable" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Mutasi</th>
                        <th>Jumlah</th>
                        <th>User</th>
                        <th>Barang</th>
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
    $('#mutasiTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('mutasi.tableDataAdmin') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'tanggal', name: 'tanggal' },
            { data: 'jenis_mutasi', name: 'jenis_mutasi' },
            { data: 'jumlah', name: 'jumlah' },
            { data: 'user', name: 'user.name' },
            { data: 'barang', name: 'barang.nama' },
            { data: 'Action', name: 'Action', orderable: false, searchable: false }
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'pdfHtml5',
                text: 'Download PDF',
                className: 'btn btn-danger',
                exportOptions: {
                    columns: ':visible:not(:last-child)'
                }
            },

            {
                extend: 'pdfHtml5',
                text: 'Download PDF',
                className: 'btn btn-danger',
                filename: 'LATHAFANNY-IDGROW', 
                exportOptions: {
                    columns: ':visible:not(:last-child)' 
                },
                customize: function (doc) {
                    doc.content.unshift({
                        text: 'ID-GROW',
                        alignment: 'center',
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 20]
                    });

                    doc.styles.tableHeader = {
                        bold: true,
                        fontSize: 12,
                        color: 'black',
                        fillColor: '#f2f2f2',
                        alignment: 'center'
                    };

                    doc.defaultStyle = {
                        fontSize: 10
                    };

                    doc.pageMargins = [20, 20, 20, 20];
                }
            }

        ]
    });

    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
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
                    url: '{{ route('mutasi.destroy', ':id') }}'.replace(':id', id),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Dihapus!', response.msg, 'success').then(() => {
                                $('#mutasiTable').DataTable().ajax.reload();
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
    });
});


</script>
@endsection
