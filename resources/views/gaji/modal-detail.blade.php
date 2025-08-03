@foreach($gajis as $gaji)
<div class="modal fade" id="detailModal{{ $gaji->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $gaji->id }}" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title fw-semibold" id="detailModalLabel{{ $gaji->id }}">
          <i class="bi bi-person-badge me-2"></i>Detail Gaji Karyawan
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body px-4 py-3">
        <table class="table table-sm align-middle">
          <tbody>
            <tr>
              <th class="text-nowrap w-50">Nama Karyawan</th>
              <td>: {{ $gaji->karyawan->nama }}</td>
            </tr>
            <tr>
              <th>Cabang</th>
              <td>: {{ $gaji->cabang->nama_cabang ?? '-' }}</td>
            </tr>
            <tr>
              <th>Periode</th>
              <td>: {{ \Carbon\Carbon::parse($gaji->periode)->locale('id')->translatedFormat('F Y') }}</td>
            </tr>
            <tr>
              <th>Jenis Gaji</th>
              <td>: {{ ucfirst($gaji->jenis_gaji) }}</td>
            </tr>
            <tr>
              <th>Tanggal Dibayar</th>
              <td>: {{ $gaji->tanggal_dibayar ? \Carbon\Carbon::parse($gaji->tanggal_dibayar)->format('d-m-Y') : '-' }}</td>
            </tr>
            <tr>
              <th>Gaji Pokok</th>
              <td>: <strong>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</strong></td>
            </tr>
            <tr>
              <th>Bonus</th>
              <td>: Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</td>
            </tr>
            <tr class="table-success fw-bold">
              <th>Jumlah Dibayar</th>
              <td>: Rp {{ number_format($gaji->jumlah_dibayar, 0, ',', '.') }}</td>
            </tr>
            <tr>
              <th>Status</th>
              <td>:
                @if ($gaji->status == 'dibayar')
                  <span class="badge bg-success">Dibayar</span>
                @else
                  <span class="badge bg-warning text-dark">Pending</span>
                @endif
              </td>
            </tr>
            <tr>
              <th>Keterangan</th>
              <td>: {{ $gaji->keterangan ?? '-' }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer bg-light py-2 px-4">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
@endforeach
