@extends('layouts.app')
@section('title', 'Tambah Barang')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Form Tambah Barang</h3>
    </div>
    <form id="formTambahBarang">
        @csrf
        <div class="card-body">
            <div class="form-group required">
                <label for="kode" class="control-label">Kode</label>
                <input type="text" name="kode" class="form-control" id="kode" value="{{ $newKode }}" readonly>
            </div>
            <div class="form-group required">
                <label for="nama" class="control-label">Nama</label>
                <input type="text" name="nama" class="form-control" id="nama" placeholder="Tuliskan Nama Barang" required>
            </div>
            <div class="form-group required">
                <label for="stok" class="control-label">Stok</label>
                <input type="number" name="stok" class="form-control" id="stok" placeholder="Tuliskan Stok Barang" required>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="control-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Tuliskan Deskripsi Barang" rows="3"></textarea>
            </div>
            <div class="form-group required">
                <label for="kategori_id" class="control-label">Kategori</label>
                <select name="kategori_id" class="form-control select2bs4" id="kategori_id" style="width: 100%;" required>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group required">
                <label for="lokasi_id" class="control-label">Lokasi</label>
                <select name="lokasi_id" class="form-control select2bs4" id="lokasi_id" style="width: 100%;" required>
                    @foreach ($lokasis as $lokasi)
                        <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
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
    $('#formTambahBarang').on('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Tambah Barang",
            text: "Apakah Anda Yakin Ingin Menambahkan Barang?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                let form_data = new FormData(this);
                form_data.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: '{{ route('barang.store') }}',
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Success', response.msg, 'success').then(() => {
                                window.location.href = '{{ route('barang.index') }}';
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
