@extends('layouts.app')

@section('title', 'Ubah Kategori')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Ubah Kategori</h3>
    </div>
    <form id="formUbahKategori" method="POST" action="{{ route('kategori.update', $kategori->id) }}">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="nama">Nama Kategori</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ $kategori->nama }}" placeholder="Nama Kategori" required>
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
        $('#formUbahKategori').on('submit', function(e) {
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
