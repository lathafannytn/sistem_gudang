@extends('layouts.app')

@section('title', 'Tambah Mutasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Mutasi</h3>
    </div>
    <form id="formTambahMutasi">
        @csrf
        <div class="card-body">
            <div class="form-group required">
                <label for="tanggal" class="control-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal" readonly required>
            </div>
            <div class="form-group required">
                <label for="jenis_mutasi" class="control-label">Jenis Mutasi</label>
                <select name="jenis_mutasi" class="form-control" id="jenis_mutasi" required>
                    <option value="Penambahan Stok">Penambahan Stok</option>
                    <option value="Pengurangan Stok">Pengurangan Stok</option>
                </select>
            </div>
            <div class="form-group required">
                <label for="jumlah" class="control-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" id="jumlah" required>
            </div>
            <div class="form-group required">
                <label for="barangs_id" class="control-label">Barang</label>
                <select name="barangs_id" class="form-control" id="barangs_id" required>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="user_name" class="control-label">User</label>
                <input type="text" class="form-control" id="user_name" value="{{ Auth::user()->name }}" readonly>
                <input type="hidden" name="users_id" value="{{ Auth::id() }}">
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
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('tanggal').value = today;

    $('#formTambahMutasi').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Tambah Mutasi",
            text: "Apakah Anda yakin ingin menambahkan mutasi?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                let form_data = new FormData(this);
                form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('mutasi.store') }}',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.msg, 'success').then(() => {
                                window.location.href = '{{ route('mutasi.index') }}';
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
