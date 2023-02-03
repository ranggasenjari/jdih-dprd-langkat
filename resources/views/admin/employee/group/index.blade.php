@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <!-- Inner container -->
        <div class="d-flex align-items-stretch align-items-lg-start flex-column flex-lg-row">

            <!-- Left content -->
            <div class="flex-1 order-2 order-lg-1">

                <div class="card">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                        @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                                    @else
                                        @php $sortState = 'asc' @endphp
                                    @endif

                                    <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.employee.group.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama</a>
                                    </th>
                                    <th class="sorting @if (!empty($sort) AND Request::get('order') == 'desc') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.employee.group.index', ['order' => 'desc', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Deskripsi</a>
                                    </th>
                                    <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'total') {{ 'sorting_' . $sort }} @endif">
                                        <a href="{{ route('admin.employee.group.index', ['order' => 'total', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Total</a>
                                    </th>
                                    <th width="1" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @forelse ($groups as $group)
                                    <tr>
                                        <td><span class="fw-semibold d-block">{{ $group->name }}</span></td>
                                        <td>{{ $group->desc }}</td>
                                        <td class="text-center"><span class="badge rounded-pill bg-indigo">{{ $group->employees->count() }}</span></td>
                                        <td class="safezone">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-link text-body p-0" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $group->id }}" data-name="{{ $group->name }}"><i class="ph-pen"></i></button>
                                                <form class="delete-form" action="{{ route('admin.employee.group.destroy', $group->id) }}" data-confirm="Apakah Anda yakin ingin menghapus grup pegawai {{ $group->name; }}?" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link text-body p-0 ms-2 delete" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                                @endforelse
                            </tbody>
                            {{ $groups->links('admin.layouts.pagination') }}
                        </table>
                    </div>
                </div>
            </div>

            <div class="sidebar sidebar-component sidebar-expand-lg bg-transparent shadow-none order-1 order-lg-2 ms-lg-3 mb-3">

                <div class="sidebar-content">
                    <div class="card">
                        <div class="sidebar-section-header border-bottom">
                            <span class="fw-semibold">Tambah Grup Pegawai</span>
                        </div>

                        <div class="sidebar-section-body">

                            <form action="{{ route('admin.employee.group.store') }}" method="post" novalidate>
                                @csrf
                                <input type="hidden" name="type" value="employee">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama:</label>
                                    <input id="name" type="text" class="form-control @if ($errors->get('name')) is-invalid @endif" name="name" value="{{ old('name') }}" placeholder="Instansi">
                                    @if ($errors->get('name') OR $errors->get('slug'))
                                        <ul class="invalid-feedback list-unstyled">
                                            @foreach ($errors->get('name') as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="desc" class="form-label">Deskripsi:</label>
                                    <textarea id="desc" rows="4" class="form-control @error('desc') is-invalid @enderror" name="desc">{{ old('desc') }}</textarea>
                                    @error('desc')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-indigo">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.employee.script')
@endsection
