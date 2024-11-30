@extends('kerangka.master')

@section('title', 'Daftar Produk')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (session('success'))
            <div class="bs-toast toast fade show bg-success" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <i class="bx bx-bell me-2"></i>
                    <div class="me-auto fw-semibold">Supplier</div>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('success') }}
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                    var toastList = toastElList.map(function(toastEl) {
                        return new bootstrap.Toast(toastEl, { delay: 3000 });
                    });
                    toastList.forEach(toast => toast.show());
                });
            </script>
        @endif

        <h4 class="fw-bold py-3 mb-4 text-center">Daftar Produk</h4>
        <hr>

        <a href="{{ route('suppliers.create') }}" class="btn btn-primary mb-3">Tambah Produk</a>

        <div class="card shadow-sm border-light">
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Supplier</th>
                            <th>Kontak</th>
                            <th>Alamat</th>
                           
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $supplier->nama_supplier }}</td>
                                <td>{{ $supplier->kontak }}</td>
                                <td>{{ $supplier->alamat }}</td>
                             
                                <td>
                                    <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection