<div class="ms-sm-auto my-sm-auto">
    <div class="d-flex justify-content-center">
        <button type="button" id="filter" class="btn btn-light me-2"><i class="ph-faders-horizontal me-2"></i>Filter</button>
        <div id="bulk-actions" class="btn-group me-2" style="display: none">
            <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown"><span id="count-selected" class="badge bg-yellow rounded-pill me-2 text-black">0</span>Aksi</button>
            <div class="dropdown-menu dropdown-menu-right">
                @if (Request::get('tab') != 'trash')
                    <div class="dropdown-submenu dropdown-submenu-start">
                        <a href="#" class="dropdown-item">Publikasi</a>
                        <div class="dropdown-menu">
                            <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="publication" data-val="draft">Draf</a>
                            <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="publication" data-val="publish">Terbit</a>
                        </div>
                    </div>
                    @if ($taxonomies->isNotEmpty())                 
                        <div class="dropdown-submenu dropdown-submenu-start">
                            <a href="#" class="dropdown-item">Kategori</a>
                            <div class="dropdown-menu">
                                @foreach ($taxonomies as $key => $value)
                                    <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="taxonomy" data-val="{{ $key }}">{{ Str::title($value) }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if ($authors->isNotEmpty())                 
                        <div class="dropdown-submenu dropdown-submenu-start">
                            <a href="#" class="dropdown-item">Penulis</a>
                            <div class="dropdown-menu">
                                @foreach ($authors as $key => $value)
                                    <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="author" data-val="{{ $key }}">{{ $value }}</a>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="author" data-val="null">Tidak Ada</a>
                            </div>
                        </div>
                    @endif
                @endif
                <div class="dropdown-divider"></div>
                @if (Request::get('tab') == 'sampah')
                    <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-confirm="Apakah Anda yakin menghapus halaman?" data-action="delete">Hapus</a>
                @else
                    <a href="#" class="dropdown-item trigger" data-route="/admin/page/trigger" data-action="trash">Buang</a>
                @endif
            </div>
        </div>
        <a href="{{ route('admin.page.create') }}" class="btn btn-indigo"><i class="ph-plus me-2"></i>Tambah</a>
    </div>
</div>
