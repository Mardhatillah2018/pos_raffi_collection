@extends('layouts.main')

@section('content')

<div class="max-w-5xl mx-auto mt-2 bg-white p-6 rounded shadow">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold fs-4">Daftar User</h2>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalUser">
            + Tambah User
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table id="datatable" class="w-full border border-gray-300 text-left">
        <thead class="text-xs text-black-700 uppercase bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">No</th>
                <th class="px-4 py-2 border">Nama</th>
                <th class="px-4 py-2 border">Email</th>
                <th class="px-4 py-2 border">Role</th>
                <th class="px-4 py-2 border">Kode Cabang</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $index => $user)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                    <td class="px-4 py-2">{{ $user->nama }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                    <td class="px-4 py-2">{{ $user->kode_cabang ?? '-' }}</td>
                     <td class="text-center">
                            <button class="btn btn-sm btn-primary me-1">
                                <i class="material-icons-round fs-5">edit</i>
                            </button>
                            <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="material-icons-round fs-5">delete</i>

                                </button>
                            </form>
                        </td>
                </tr>
            @empty
                <tr>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2">-</td>
                    <td class="px-4 py-2 text-center text-gray-500">Belum ada user</td>
                </tr>

            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('modals')
  @include('user.modal-create')
@endpush
