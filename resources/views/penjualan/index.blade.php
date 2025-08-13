@extends('layouts.main')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-gradient-dark fw-bold">
            <h6 class="mb-0" style="color: white">Daftar Penjualan</h6>
        </div>

        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center px-3 py-2 mb-0">
                <div>
                    <button class="btn btn-sm" style="background-color: white; border: 1px solid #a20f0f; color: #a20f0f;" data-bs-toggle="modal" data-bs-target="#modalCetak">
                        <i class="bi bi-printer me-1" style="color: #a20f0f; font-size: 0.9rem;"></i>
                        Laporan Penjualan
                    </button>
                </div>
                @if (Auth::user()->role === 'admin_cabang')
                    <div>
                        <a href="{{ route('penjualan.create') }}" class="btn btn-primary btn-sm">
                            + Tambah Penjualan
                        </a>
                    </div>
                @endif
            </div>

            {{-- modal cetak --}}
            <div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <form action="{{ route('penjualan.cetakLaporan') }}" method="GET" target="_blank">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold" id="modalCetakLabel">Cetak Laporan Penjualan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="tanggal_mulai" class="form-label" style="color: black; font-weight: semibold;">Dari Tanggal</label>
                                    <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control flatpickr" placeholder="dari tanggal ..." required>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_sampai" class="form-label" style="color: black; font-weight: semibold;">Sampai Tanggal</label>
                                    <input type="text" name="tanggal_sampai" id="tanggal_sampai" class="form-control flatpickr" placeholder="sampai tanggal ..." required>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-printer me-1"></i> Cetak Laporan
                                </button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table table-hover align-items-center mb-0">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>No Struk</th>
                            <th>Tanggal</th>
                            <th>Total Harga</th>
                            <th>Total Qty</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($penjualans as $index => $penjualan)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">{{ $penjualan->no_struk }}</td>
                                <td class="text-center">{{ $penjualan->tanggal_penjualan }}</td>
                                <td class="text-end">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $penjualan->detailPenjualans->sum('qty') }}</td>
                                <td class="text-center">{{ $penjualan->user->nama ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                        <a href="{{ route('penjualan.detail', $penjualan->id) }}"
                                            class="btn btn-info btn-sm d-flex align-items-center px-2 py-1"
                                            title="Detail">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">info</i>
                                            <span class="text-white fw-semibold small">Detail</span>
                                        </a>


                                        <a href="{{ route('penjualan.cetakStruk', $penjualan->id) }}"
                                            class="btn btn-secondary btn-sm d-flex align-items-center px-2 py-1"
                                            title="Cetak Struk" target="_blank">
                                            <i class="material-icons-round text-white me-1" style="font-size: 16px;">print</i>
                                            <span class="text-white fw-semibold small">Struk</span>
                                        </a>

                                        {{-- <form action="#" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus penjualan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-danger btn-sm d-flex align-items-center px-2 py-1"
                                                title="Hapus">
                                                <i class="material-icons-round text-white me-1" style="font-size: 16px;">delete</i>
                                                <span class="text-white fw-semibold small">Hapus</span>
                                            </button>
                                        </form> --}}

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                                <td class="text-center">-</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: '{{ session('error') }}',
            showConfirmButton: true,
        });
    @endif
    @if(session('sukses_penjualan'))
    Swal.fire({
        title: 'Penjualan Berhasil!',
        text: 'Apa yang ingin Anda lakukan selanjutnya?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Cetak Struk',
        cancelButtonText: 'Lihat Penjualan',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.open('{{ route('penjualan.cetakStruk', session('penjualan_id')) }}', '_blank');
        }
    });
    @endif

    document.addEventListener('DOMContentLoaded', function () {
        const form   = document.querySelector('#modalCetak form');
        const start  = document.getElementById('tanggal_mulai');
        const end    = document.getElementById('tanggal_sampai');

        const fpStart = flatpickr(start, {
            dateFormat: 'Y-m-d',
            maxDate: "today",
            onChange: function (_, dateStr) {
                end._flatpickr.set('minDate', dateStr || null);
                validate();
            }
        });

        const fpEnd = flatpickr(end, {
            dateFormat: 'Y-m-d',
            maxDate: "today",
            onChange: function (_, dateStr) {
                start._flatpickr.set('maxDate', dateStr || null);
                validate();
            }
        });

        function setInvalid(el, msg) {
            el.classList.add('is-invalid');
            const fb = el.nextElementSibling;
            if (fb && fb.classList.contains('invalid-feedback')) {
                fb.textContent = msg || 'Wajib diisi.';
                fb.style.display = 'block';
            }
        }

        function clearInvalid(el) {
            el.classList.remove('is-invalid');
            const fb = el.nextElementSibling;
            if (fb && fb.classList.contains('invalid-feedback')) {
                fb.textContent = '';
                fb.style.display = 'none';
            }
        }

        function validate() {
            let ok = true;
            clearInvalid(start);
            clearInvalid(end);

            if (!start.value) { setInvalid(start, 'Pilih tanggal mulai.'); ok = false; }
            if (!end.value)   { setInvalid(end,   'Pilih tanggal sampai.'); ok = false; }

            if (ok && end.value < start.value) {
                setInvalid(end, 'Tanggal sampai tidak boleh sebelum tanggal mulai.');
                ok = false;
            }
            return ok;
        }

        form.addEventListener('submit', function (e) {
            if (!validate()) {
                e.preventDefault();
            }
        });
    });


</script>
@endpush
