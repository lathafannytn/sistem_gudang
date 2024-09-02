@extends('layouts.app')

@section('title', 'Ubah Mutasi')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Ubah Mutasi</h3>
    </div>
    <form id="formUbahMutasi">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group required">
                <label for="tanggal" class="control-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" id="tanggal" value="{{ $mutasi->tanggal }}" required>
            </div>
            <div class="form-group required">
                <label for="jenis_mutasi" class="control-label">Jenis Mutasi</label>
                <select name="jenis_mutasi" class="form-control" id="jenis_mutasi" required>
                    <option value="Penambahan Stok" {{ $mutasi->jenis_mutasi == 'Penambahan Stok' ? 'selected' : '' }}>Penambahan Stok</option>
                    <option value="Pengurangan Stok" {{ $mutasi->jenis_mutasi == 'Pengurangan Stok' ? 'selected' : '' }}>Pengurangan Stok</option>
                </select>
            </div>
            <div class="form-group required">
                <label for="jumlah" class="control-label">Jumlah</label>
                <input type="number" name="jumlah" class="form-control" id="jumlah" value="{{ $mutasi->jumlah }}" required>
            </div>
            <div class="form-group required">
                <label for="barangs_id" class="control-label">Barang</label>
                <select name="barangs_id" class="form-control" id="barangs_id" required>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ $barang->id == $mutasi->barangs_id ? 'selected' : '' }}>{{ $barang->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="users_id" class="control-label">User</label>
                <select name="users_id" class="form-control" id="users_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $user->id == $mutasi->users_id ? 'selected' : '' }}>{{ $user->nama }}</option>
                    @endforeach
                </select>
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
$('#formUbahMutasi').on('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: "Ubah Mutasi",
        text: "Apakah Anda yakin ingin mengubah mutasi?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            let form_data = new FormData(this);
            form_data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('mutasi.update', $mutasi->id) }}',
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
</script>
@endsection
