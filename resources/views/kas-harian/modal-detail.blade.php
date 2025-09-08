@foreach($kasHarians as $kas)
<div class="modal fade" id="detailKas{{ $kas->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-3">

        {{-- Header --}}
        <div class="modal-header bg-info text-white">
            <h5 class="modal-title fw-semibold text-white">
                <i class="fas fa-info-circle me-2"></i> Detail Kas Harian
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        {{-- Body --}}
        <div class="modal-body">
            <table class="table table-bordered table-striped align-middle">
                <tr>
                    <th class="w-25">Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($kas->tanggal)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <th>Saldo Awal</th>
                    <td>Rp {{ number_format($kas->saldo_awal,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Total Penjualan</th>
                    <td>Rp {{ number_format($kas->total_penjualan,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Total Pengeluaran</th>
                    <td>Rp {{ number_format($kas->total_pengeluaran ?? 0,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Setoran</th>
                    <td>Rp {{ number_format($kas->setor,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Saldo Akhir</th>
                    <td>Rp {{ number_format($kas->saldo_akhir,0,',','.') }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $kas->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if ($kas->status == 'pending')
                            <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                        @elseif ($kas->status == 'approved')
                            <span class="badge bg-success px-3 py-2">Approved</span>
                        @else
                            <span class="badge bg-danger px-3 py-2">Rejected</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>

    </div>
  </div>
</div>
@endforeach
