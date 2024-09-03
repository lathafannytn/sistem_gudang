@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Edit User</h3>
    </div>
    <form id="formEditUser">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group required">
                <label for="name" class="control-label">Nama</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
            </div>
            <div class="form-group required">
                <label for="email" class="control-label">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Isi jika ingin mengubah password">
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="control-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Konfirmasi password">
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" id="btn-update" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#formEditUser').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Update User",
            text: "Apakah Anda yakin ingin mengubah user?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                let form_data = new FormData(this);
                form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('user.update', $user->id) }}',
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
                        Swal.fire('Error', 'Terjadi kesalahan pada server.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endsection
