@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah User</h3>
    </div>
    <form id="formTambahUser">
        @csrf
        <div class="card-body">
            <div class="form-group required">
                <label for="name" class="control-label">Nama</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="form-group required">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            
            <div class="form-group required">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="form-group required">
                <label for="password_confirmation" class="control-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" required>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" id="btn-simpan" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#formTambahUser').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Tambah User",
            text: "Apakah Anda yakin ingin menambahkan user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                let form_data = new FormData(this);
                form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('user.store') }}',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.msg, 'success').then(() => {
                                window.location.href = '{{ route('user.index') }}';
                            });
                        } else {
                            Swal.fire('Error', response.msg, 'error');
                        }
                    },
                    error: function(xhr) {
                        // Handle server-side validation errors
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessage = 'Terjadi kesalahan validasi:\n\n';
                            for (let field in errors) {
                                errorMessage += `${errors[field][0]}\n`;
                            }
                            Swal.fire('Error', errorMessage, 'error');
                        } else {
                            Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                        }
                    }
                });
            }
        });
    });
});
</script>
@endsection
