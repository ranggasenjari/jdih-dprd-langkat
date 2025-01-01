<!-- Footer -->
<section class="bg-dark text-light">
    <div class="container py-5" style="background-image: url({{ asset('assets/jdih/images/backgrounds/langkat-map.png') }}); background-position:center; background-repeat: no-repeat">
        <div class="content-wrapper">
            <div class="content py-4">
                <div class="row gx-5">
                    <div class="col-lg-4 fs-md">
                        <div class="d-flex mb-3 align-items-center">
                            <img src="{{ $appLogoUrl }}" alt="{{ $appName }}" class="me-2" height="42">
                            <h4 class="fw-bold mb-0">{!! $appName !!}</h4>
                        </div>
                        {!! $welcome->excerpt !!}
                        <a href="https://play.google.com/store/apps/details?id=id.go.langkatkab.jdih_dprd.twa" target="_blank">
                        <img width="230" class="rounded img-fluid mt-2" src="{{ asset('assets/admin/images/logo-playstore.png') }}">
                        </a>
                    </div>
                    <div class="col-lg-2">
                        <h4 class="fw-bold">Navigasi</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="text-light">Beranda</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Produk Hukum</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Berita</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Profil</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Galeri</a></li>
                            <li class="mb-2"><a href="#" class="text-light">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4 class="fw-bold">Kontak Kami</h4>
                        <dl class="row mb-0">
                            <dt class="col-sm-1"><i class="ph-phone"></i></dt>
                            <dd class="col-sm-11 mb-2">{{ $phone }}</dd>

                            <dt class="col-sm-1"><i class="ph-house"></i></dt>
                            <dd class="col-sm-11 mb-2">
								{{ $fullAddress }}
                            </dd>

                            <dt class="col-sm-1"><i class="ph-envelope"></i></dt>
                            <dd class="col-sm-11 mb-2">{{ $email }}</dd>

                            <dt class="col-sm-1"><i class="ph-globe"></i></dt>
                            <dd class="col-sm-11 mb-2">{{ $appUrl }}</dd>

						</dl>
                        <hr>
                        <ul class="list-inline list-inline-condensed">
                            @isset($facebook)
                                <li class="list-inline-item">
                                    <a href="{{ $facebook }}" class="text-light" title="Facebook"><i class="ph-facebook-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($twitter)
                                <li class="list-inline-item">
                                    <a href="{{ $twitter }}" class="text-light" title="Twitter"><i class="ph-twitter-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($instagram)
                                <li class="list-inline-item">
                                    <a href="{{ $instagram }}" class="text-light" title="Instagram"><i class="ph-instagram-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($tiktok)
                                <li class="list-inline-item">
                                    <a href="{{ $tiktok }}" class="text-light" title="TikTok"><i class="ph-tiktok-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset

                            @isset($youtube)
                                <li class="list-inline-item">
                                    <a href="{{ $youtube }}" class="text-light" title="YouTube"><i class="ph-youtube-logo ph-2x" aria-hidden="true"></i></a>
                                </li>
                            @endisset
                        </ul>
                    </div>
                    <div class="col-lg-3">
                        <h4 class="fw-bold">Statistik Pengunjung</h4>
                        <ul class="list list-unstyled mb-0">
							<li class="d-flex">
                                <span class="me-auto">Hari ini</span>
                                <label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">{{ $todayVisitor }}</label>
                            </li>
                            <li class="d-flex">
                                <span class="me-auto">Kemarin</span>
                                <label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">{{ $yesterdayVisitor }}</label>
                            </li>
							<li class="d-flex">
                                <span class="me-auto">Minggu lalu</span>
                                <label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">{{ $lastWeekVisitor }}</label>
                            </li>
							<li class="d-flex">
                                <span class="me-auto">Bulan lalu</span>
                                <label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">{{ $lastMonthVisitor }}</label>
                            </li>
							<li class="d-flex">
                                <span class="me-auto">Total</span>
                                <label class="badge bg-light bg-opacity-20 text-reset rounded-pill pull-end">{{ $allVisitor }}</label>
                            </li>
						</ul>
                        <hr>
                        <h5 class="fw-bold">Bagaimana JDIH {{ $company }}?</h5>
                        <a href="{{ route('questionner') }}" target="_blank" class="btn btn-outline-yellow btn-icon">
                            <i class="ph-pencil-line ms-lg-1"></i>
                            <span class="d-none d-lg-inline-block ms-2 me-1">Ikuti Survei IKM</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <hr class="m-0">
</section>
<div class="navbar navbar-sm navbar-dark navbar-expand-xl navbar-footer">
    <div class="container px-lg-3">
        <span class="navbar-text d-block d-xl-inline-block">&copy; {{ now()->year }} <a href="{{ $appUrl }}">{{ strip_tags($appName) . ' ' . config('app.version') }}</a> oleh <a href="{{ $companyUrl }}" target="_blank">{{ $company }}</a></span>
        <ul class="navbar-nav ms-xl-auto">
            <li class="nav-item"><a href="{{ route('policy', 'syarat-dan-ketentuan') }}" class="navbar-nav-link rounded">Syarat dan Ketentuan</a></li>
            <li class="nav-item"><a href="{{ route('policy', 'privasi') }}" class="navbar-nav-link rounded">Privasi</a></li>
        </ul>
    </div>
</div>
<!-- /footer -->

<!-- Search modal -->
<div id="search-modal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg" style="margin-top: 25vh">
        <div class="modal-content">

            <form class="search-form" action="{{ route('legislation.index') }}" method="get">
                <div class="navbar-search flex-fill position-relative m-0">
                    <div class="form-control-feedback form-control-lg form-control-feedback-start flex-grow-1">
                        <input id="search-dropdown" name="title" type="text" autocomplete="off" autofocus class="form-control form-control-lg border-0 py-3" placeholder="Cari Peraturan, Monografi, Artikel atau Putusan..." data-bs-toggle="dropdown" value="{{ Request::get('title') }}">
                        <div class="form-control-feedback-icon pt-3">
                            <i class="ph-magnifying-glass"></i>
                        </div>
                        <div id="search-dropdown-results" class="dropdown-menu w-100" data-color-theme="light"></div>
                    </div>
                    <div class="position-static">
                        <a href="#" class="navbar-nav-link align-items-center justify-content-center w-40px h-32px position-absolute end-0 top-50 translate-middle-y p-0 me-1" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                            <i class="ph-faders-horizontal"></i>
                        </a>

                        <div id="filter-dropdown-container" class="dropdown-menu w-100 p-4 dropdown-menu-end start-5">
                            <div class="d-flex align-items-center mb-3">
                                <h6 class="mb-0">Filter Pencarian Produk Hukum</h6>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="type" class="d-block form-label">Tipe</label>
                                    <select id="type" name="types[]" class="form-select select">
                                        <option value="">Pilih Tipe</option>
                                        @foreach ($types as $key => $value)
                                            <option value="{{ $key }}">{{ Str::title($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label class="form-label">Jenis / Bentuk</label>
                                    <select name="category" id="category" class="form-select select-search">
                                        <option value="">Pilih Jenis</option>
                                        @foreach ($allCategories as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="code_number" class="form-label">Nomor</label>
                                    <input type="text" name="code_number" id="code_number" class="form-control" placeholder="Contoh: 12">
                                </div>
                                <div class="col">
                                    <label for="year" class="d-block form-label">Tahun</label>
                                    <input type="number" name="year" id="year" class="form-control" placeholder="Contoh: 2022">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="field" class="d-block form-label">Bidang Hukum</label>
                                    <select name="fields[]" id="field" class="form-select select-search">
                                        <option value="">Pilih Bidang Hukum</option>
                                        @foreach ($fields as $key => $value)
                                            <option value="{{ $key }}">{{ Str::title($value) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="mt-2">
										<label class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input form-check-input-danger" name="status[]" value="berlaku">
											<span class="form-check-label">Berlaku</span>
										</label>

										<label class="form-check form-check-inline">
											<input type="checkbox" class="form-check-input form-check-input-danger" name="status[]" value="tidak berlaku">
											<span class="form-check-label">Tidak Berlaku</span>
										</label>
									</div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <label for="author" class="d-block form-label">T.E.U. Orang / Badan</label>
                                    <input type="text" name="author" id="author" class="form-control" placeholder="Contoh: Langkat">
                                </div>
                                <div class="col">
                                    <label for="subject" class="form-label">Subjek</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Contoh: PUNGUTAN LIAR">
                                </div>
                            </div>

                            <div class="d-flex flex-row-reverse">
                                <button type="submit" class="btn btn-danger fw-bold px-3">Filter</button>
                                <button type="reset" class="btn btn-outline-danger fw-bold me-2 reset px-3">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- /search modal -->

<!-- Popup Banner modal -->
@if(isset($popupBanner) AND $popupBanner->count() > 0)
    <div id="popup-banner" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <a href="{{ $popupBanner->url }}" target="_blank"><img src="{{ $popupBanner->image->source }}" class="img-fluid rounded"></a>
            </div>
        </div>
    </div>
@endif
<!-- /popup banner modal -->

<script>
    if (typeof navigator.serviceWorker !== 'undefined') {
        navigator.serviceWorker.register("{{ asset('assets/admin/js/pwabuilder-sw.js') }}")
    }
</script>
<script>
    const el = document.getElementById('popup-banner');
    if (el) {
        const popupBanner = new bootstrap.Modal(document.getElementById('popup-banner'), {});
        setTimeout(() => {
            popupBanner.show();
        }, 3000);
    }

    const searchModal = document.getElementById('search-modal');
    searchModal.addEventListener('shown.bs.modal', event => {
        document.getElementById('search-dropdown').focus();
    })

    $(document).on('click', '.reset', function() {
        $('.select-search').val(null).trigger('change');
        $('.select').val(null).trigger('change');
    })

    $(".search-form").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true;
    });
</script>
