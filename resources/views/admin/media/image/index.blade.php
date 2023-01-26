@extends('admin.layouts.app')

@section('title', $pageTitle)
@section('content')

    <!-- Content area -->
    <div class="content pt-0">

        @include('admin.layouts.message')

        <div class="card">
            <div class="card-header card-header d-sm-flex py-sm-0">
                <div class="py-sm-3 mb-sm-0 mb-3">
                    <div class="form-control-feedback form-control-feedback-end">
                        <form action="{{ route('admin.media.image.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari nama berkas, keterangan..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.media.feature', ['type' => 'gambar'])

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('admin.media.image.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
                                        <span class="d-lg-inline-block ms-2">
                                            {{ Str::title($key) }}
                                            <span class="badge bg-indigo rounded-pill ms-auto ms-lg-2">{{ number_format($value, 0, ',', '.') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                        <div class="navbar-collapse collapse" id="profile_nav">
                            <ul class="navbar-nav ms-lg-auto mt-2 mt-lg-0">
                                <li class="nav-item dropdown ms-lg-1">
                                    <a href="#" class="navbar-nav-link rounded dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="ph-list-dashes"></i>
                                        <span class="d-none d-lg-inline-block ms-2">
                                            @if (!empty(Request::get('limit')) AND $limit = Request::get('limit'))
                                                {{ $limit }}
                                            @else
                                                25
                                            @endif
                                        </span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="{{ route('admin.media.image.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('admin.media.image.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('admin.media.image.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('admin.media.image.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
                                    </div>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
            @endisset

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            @if (!empty(Request::get('sort')) AND $sort = Request::get('sort'))
                                @php $sortState = ($sort == 'asc') ? 'desc' : 'asc' @endphp
                            @else
                                @php $sortState = 'asc' @endphp
                            @endif
                            
                            @cannot('isAuthor')                                
                                <th width="1"><input type="checkbox" /></th>
                            @endcannot
                            <th width="1" class="text-center">Gambar</th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'name') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.media.image.index', ['order' => 'name', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Nama Berkas</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'size') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.media.image.index', ['order' => 'size', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Ukuran</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'user') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.media.image.index', ['order' => 'user', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Pengunggah</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'created_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.media.image.index', ['order' => 'created_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Publikasi</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @forelse ($images as $image)
                            <tr>
                                @cannot('isAuthor')                                    
                                    <td><input type="checkbox" class="checkbox" data-item="{{ $image->id }}"></td>
                                @endcannot
                                <td class="safezone text-center"><img src="{{ $image->mediaThumbUrl }}" class="img-preview rounded"></td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $image->name }}</span>
                                    @if (!empty($image->caption))
                                       <span class="text-muted">{!! $image->caption !!}</span>
                                    @endif
                                </td>
                                <td>{{ $image->size() }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="{{ $image->userPictureUrl($image->user->picture, $image->user->name) }}" alt="{{ $image->user->name }}" class="rounded-circle" width="32" height="32">
                                        </div>
                                        {{ $image->user->name }}
                                    </div>
                                </td>
                                <td>
                                    <span class="d-block">{!! $image->publicationLabel() !!}</span>
                                    <abbr class="fs-sm" data-bs-popup="tooltip" title="{{ $image->dateFormatted($image->published_at, true) }}">{{ $image->dateFormatted($image->published_at) }}</abbr>
                                </td>
                                <td class="safezone">
                                    <div class="d-inline-flex">
                                        <a href="{{ $image->mediaUrl }}" class="text-body mx-1" data-lightbox="lightbox" data-bs-popup="tooltip" title="Pratinjau"><i class="ph-eye"></i></a>

                                        @can('update', $image)
                                            <button type="button" class="btn btn-link text-body p-0 mx-1" data-bs-popup="tooltip" title="Ubah" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="{{ $image->id }}" data-route="image"><i class="ph-pen"></i></button>
                                        @endcan

                                        @can('delete', $image)
                                            <form class="delete-form" action="{{ route('admin.media.image.destroy', $image->id) }}" data-confirm="Apakah Anda yakin ingin  menghapus gambar?" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-link text-body p-0 mx-1 delete" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $images->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('modal')
    @include('admin.media.image.create')
    @include('admin.layouts.modal')
@endsection

@section('script')
    @include('admin.media.script')
@endsection
