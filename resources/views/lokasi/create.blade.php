@extends('layouts.app')

@section('title', 'Tambah Lokasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Lokasi</h3>
    </div>
    <form id="formTambahLokasi" method="POST" action="{{ route('lokasi.store') }}">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Lokasi</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Lokasi" required>
            </div>
            <div class="form-group">
                <label for="lokasi">Detail Lokasi</label>
                <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Detail Lokasi">
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
        $('#formTambahLokasi').on('submit', function(e) {
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
                            window.location.href = "{{ route('lokasi.index') }}";
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
