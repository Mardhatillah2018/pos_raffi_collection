<div class="modal fade" id="modalKasHarian" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header bg-success text-white">
            <h5 class="modal-title">Tambah Kas Harian</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form action="{{ route('kas-harian.store') }}" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row g-3">
                    <!-- Kolom Kiri -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tanggal" class="form-label" style="color: black; font-weight: semibold;">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="saldo_awal" class="form-label" style="color: black; font-weight: semibold;">Saldo Awal</label>
                            <input type="number" name="saldo_awal" id="saldo_awal"
                                class="form-control" min="0"
                                value="{{ $saldoAwal }}" readonly>
                        </div>


                        <div class="mb-3">
                            <label for="total_penjualan" class="form-label" style="color: black; font-weight: semibold;">Total Penjualan</label>
                            <input type="number" name="total_penjualan" id="total_penjualan"
                                class="form-control" min="0"
                                value="{{ $totalPenjualan }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="total_pengeluaran" class="form-label" style="color: black; font-weight: semibold;">Total Pengeluaran</label>
                            <input type="number" name="total_pengeluaran" id="total_pengeluaran"
                                class="form-control" min="0"
                                value="{{ $totalPengeluaran }}" required>
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="setor" class="form-label" style="color: black; font-weight: semibold;">Setoran</label>
                            <input type="number" name="setor" id="setor" class="form-control" min="0" placeholder="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="saldo_akhir" class="form-label" style="color: black; font-weight: semibold;">Saldo Akhir</label>
                            <input type="number" name="saldo_akhir" id="saldo_akhir" class="form-control" min="0" value="0" required>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label" style="color: black; font-weight: semibold;">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Tambahkan catatan jika perlu..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
  </div>
</div>

@push('scripts')

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const saldoAwal = document.getElementById("saldo_awal");
        const totalPenjualan = document.getElementById("total_penjualan");
        const totalPengeluaran = document.getElementById("total_pengeluaran");
        const setor = document.getElementById("setor");
        const saldoAkhir = document.getElementById("saldo_akhir");

        function hitungSaldoAkhir() {
            let awal = parseFloat(saldoAwal.value) || 0;
            let penjualan = parseFloat(totalPenjualan.value) || 0;
            let pengeluaran = parseFloat(totalPengeluaran.value) || 0;
            let setoran = parseFloat(setor.value) || 0;

            let hasil = awal + penjualan - pengeluaran - setoran;
            saldoAkhir.value = hasil;
        }

        // Jalankan saat input berubah
        saldoAwal.addEventListener("input", hitungSaldoAkhir);
        totalPenjualan.addEventListener("input", hitungSaldoAkhir);
        totalPengeluaran.addEventListener("input", hitungSaldoAkhir);
        setor.addEventListener("input", hitungSaldoAkhir);

        // Jalankan sekali waktu modal ditampilkan
        document.getElementById("modalKasHarian").addEventListener("shown.bs.modal", hitungSaldoAkhir);
    });
</script>

@endpush
