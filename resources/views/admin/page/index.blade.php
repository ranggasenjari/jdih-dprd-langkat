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
                        <form action="{{ route('admin.page.index') }}" method="get">
                            <input type="search" name="search" class="form-control rounded-pill" placeholder="Cari judul, narasi..." @if (Request::get('search')) value="{{ Request::get('search') }}" @endif autofocus>
                            <div class="form-control-feedback-icon">
                                <i class="ph-magnifying-glass text-muted"></i>
                            </div>
                        </form>
                    </div>
                </div>

                @include('admin.page.feature')

            </div>

            <div id="filter-options" @empty (Request::get('filter')) style="display: none" @endempty>

                @include('admin.page.filter')

            </div>

            @isset ($tabFilters)
                <div class="navbar navbar-expand-lg border-bottom py-2">
                    <div class="container-fluid">
                        <ul class="nav navbar-nav flex-row flex-fill">
                            @foreach ($tabFilters as $key => $value)
                                @php $active = ((empty(Request::get('tab')) AND $key === 'total') OR Request::get('tab') == $key) ? ' active' : '' @endphp
                                <li class="nav-item me-1">
                                    <a href="{{ route('admin.page.index', ['tab' => $key] + Request::all()) }}" class="navbar-nav-link rounded{{ $active }}">
                                        <span class="d-lg-inline-block ms-2">
                                            {{ Str::ucfirst($key) }}
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
                                        <a href="{{ route('admin.page.index', ['limit' => 25] + Request::all()) }}" class="dropdown-item" data-rows="25">25</a>
                                        <a href="{{ route('admin.page.index', ['limit' => 50] + Request::all()) }}" class="dropdown-item" data-rows="50">50</a>
                                        <a href="{{ route('admin.page.index', ['limit' => 100] + Request::all()) }}" class="dropdown-item" data-rows="100">100</a>
                                        <a href="{{ route('admin.page.index', ['limit' => 200] + Request::all()) }}" class="dropdown-item" data-rows="200">200</a>
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
                            <th width="1" class="text-center">Sampul</th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'title') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.page.index', ['order' => 'title', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Judul</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'taxonomy_id') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.page.index', ['order' => 'taxonomy_id', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Kategori</a>
                            </th>
                            <th class="text-center sorting @if (!empty($sort) AND Request::get('order') == 'user') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.page.index', ['order' => 'user', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Operator</a>
                            </th>
                            <th class="sorting @if (!empty($sort) AND Request::get('order') == 'published_at') {{ 'sorting_' . $sort }} @endif">
                                <a href="{{ route('admin.page.index', ['order' => 'published_at', 'sort' => $sortState] + Request::all()) }}" class="text-dark d-block">Publikasi</a>
                            </th>
                            <th width="1" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pages as $post)
                            <tr id="{{ $post->id }}" class="item" data-id="{{ $post->id }}">
                                @cannot('isAuthor')
                                    <td><input type="checkbox" class="checkbox" data-item="{{ $post->id }}"></td>
                                @endcannot
                                <td class="safezone text-center">
                                    <img src="@if($post->cover){{ $post->cover->thumbSource }}@endif" class="img-preview rounded">
                                </td>
                                <td>
                                    <span class="fw-semibold d-block">{{ $post->title }}</span>
                                    <span class="text-muted fs-sm">{!! Str::limit(strip_tags($post->body), 150) !!}</span>
                                </td>
                                <td>{{ $post->taxonomy->name ?? '-'; }}</td>
                                <td class="text-center">
                                    <img src="{{ $post->userPictureUrl($post->user->picture, $post->user->name) }}" alt="{{ $post->user->name }}" class="rounded-circle" width="32" height="32" data-bs-popup="tooltip" title="{{ $post->user->name }}">
                                </td>
                                <td>
                                    <span class="d-block">{!! $post->publicationLabel() !!}</span>
                                    <abbr class="fs-sm" data-bs-popup="tooltip" title="{{ $post->dateFormatted($post->published_at, true) }}">{{ $post->dateFormatted($post->published_at) }}</abbr>
                                </td>
                                <td class="safezone">
                                    <div class="d-inline-flex">
                                        <a href="{{ route('admin.page.show', $post->id) }}" class="text-body mx-1" data-bs-popup="tooltip" title="Lihat"><i class="ph-eye"></i></a>
                                        @if ($onlyTrashed)
                                            @can('restore', $post)
                                                <form action="{{ route('admin.page.restore', $post->id) }}" method="POST">
                                                    @method('PUT')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body mx-1" data-bs-popup="tooltip" title="Kembalikan"><i class="ph-arrow-arc-left"></i></button>
                                                </form>
                                            @endcan

                                            @can('forceDelete', $post)
                                                <form class="delete-form" action="{{ route('admin.page.force-destroy', $post->id) }}" data-confirm="Apakah Anda yakin menghapus berita {{ $post->title }}?" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body mx-1" data-bs-popup="tooltip" title="Hapus"><i class="ph-x"></i></button>
                                                </form>
                                            @endcan
                                        @else
                                            @can('update', $post)
                                                <a href="{{ route('admin.page.edit', $post->id) }}" class="text-body mx-1" data-bs-popup="tooltip" title="Ubah"><i class="ph-pen"></i></a>
                                            @endcan

                                            @can('delete', $post)
                                                <form action="{{ route('admin.page.destroy', $post->id) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button type="submit" class="btn btn-link p-0 text-body mx-1" data-bs-popup="tooltip" title="Buang"><i class="ph-trash"></i></button>
                                                </form>
                                            @endcan
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="table-warning"><td colspan="100" class="text-center text-warning">Tidak ada data</td></tr>
                        @endforelse
                    </tbody>

                    {{ $pages->links('admin.layouts.pagination') }}

                </table>
            </div>
        </div>

    </div>
    <!-- /content area -->

@endsection

@section('script')
    @include('admin.page.script')
@endsection
