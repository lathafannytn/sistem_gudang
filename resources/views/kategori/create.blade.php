@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Kategori</h3>
    </div>
    <form id="formTambahKategori" method="POST" action="{{ route('kategori.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Kategori" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#formTambahKategori').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize(); 

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.msg,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = "{{ route('kategori.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.msg
                        });
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan pada server. Silakan coba lagi.'
                    });
                }
            });
        });
    });
</script>
@endsection
