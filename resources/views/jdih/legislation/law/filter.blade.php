<!-- Filter -->
<div class="card shadow mb-4">
    <div class="sidebar-section-header pb-0">
        <h5 class="mb-0">Filter</h5>
    </div>

    <form class="filter-form"
        @isset($category)
            action="{{ route('legislation.law.category', ['category' => $category->slug]) }}"
        @else
            action="{{ route('legislation.law.index') }}"
        @endisset
        method="get">

        <!-- Sidebar search -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Kata Kunci</span>
                <div class="ms-auto">
                    <a href="#sidebar-search" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="sidebar-search">
                <div class="sidebar-section-body">
                    <div class="form-control-feedback form-control-feedback-end">
                        <input id="title" type="search" name="title" autofocus class="form-control form-control-danger" placeholder="Contoh: Pembentukan fraksi" value="{{ Request::get('title') }}">
                        <div class="form-control-feedback-icon">
                            <i class="ph-magnifying-glass opacity-50"></i>
                        </div>
                    </div>
                    <div class="form-text text-muted">Tekan Enter untuk mencari</div>
                </div>
            </div>
        </div>
        <!-- /sidebar search -->

        <!-- Categories filter -->
        @empty($category)
            <div class="sidebar-section">
                <div class="sidebar-section-header border-bottom">
                    <span class="fw-semibold">Jenis / Bentuk</span>
                    <div class="ms-auto">
                        <a href="#categories" class="text-reset" data-bs-toggle="collapse">
                            <i class="ph-caret-down collapsible-indicator"></i>
                        </a>
                    </div>
                </div>

                <div class="collapse show" id="categories">
                    <div class="sidebar-section-body">
                        @foreach ($categories as $key => $value)
                            @if ($loop->iteration === 6 AND !Request::get('categories') AND $categories->count() > 5)
                                <div id="categories-hidden" style="display: none">
                            @endif
                            <label class="form-check mb-2">
                                <input type="checkbox" name="categories[]" @checked(Request::get('categories') AND in_array($key, Request::get('categories'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                                <span class="form-check-label">{{ Str::title($value) }}</span>
                            </label>
                            @if ($loop->last AND !Request::get('categories') AND $categories->count() > 5)
                                </div>
                            @endif
                        @endforeach
                        @if (empty(Request::get('categories')) AND $categories->count() > 5)
                            <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="categories-hidden">Lihat semua</a>
                        @endif
                    </div>
                </div>
            </div>
        @endempty
        <!-- /categories options -->

        <!-- Status options -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Status</span>
                <div class="ms-auto">
                    <a href="#status" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="status">
                <div class="sidebar-section-body">
                    @foreach ($lawStatusOptions as $status)                        
                        <label class="form-check mb-2">
                            <input type="checkbox" name="statuses[]" @checked(Request::get('statuses') AND in_array($status->value, Request::get('statuses'))) class="form-check-input form-check-input-danger" value="{{ $status->value }}">
                            <span class="form-check-label">{{ $status->label() }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /status options -->

        <!-- Number and Year search -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Nomor Peraturan</span>
                <div class="ms-auto">
                    <a href="#number-year" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="number-year">
                <div class="sidebar-section-body">
                    <div class="mb-3">
                        <label class="form-label">Nomor:</label>
                        <input id="code_number" type="search" name="code_number" class="form-control" placeholder="Contoh: 3" value="{{ Request::get('code_number') }}">
                    </div>
                    <label class="form-label">Tahun: <output id="value"></output></label>
                    <input id="year" type="number" name="year" class="form-control" placeholder="Contoh: {{ now()->year }}" value="{{ Request::get('year') }}">
                </div>
            </div>
        </div>
        <!-- /number and year search -->

        <!-- Laws date -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Tanggal</span>
                <div class="ms-auto">
                    <a href="#laws-date" class="text-reset" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse show" id="laws-date">
                <div class="sidebar-section-body">
                    <div class="mb-3">
                        <label class="form-label">Ditetapkan:</label>
                        <div class="input-group">
                            <input type="text" name="rgapproved" class="form-control daterange-datemenu" placeholder="31/12/2024 - 31/01/2025" value="{{ Request::get('rgapproved') }}">
                            <span class="input-group-text"><i class="ph-calendar"></i></span>
                        </div>
                    </div>

                    <label class="form-label">Diundangkan:</label>
                    <div class="input-group">
                        <input type="text" name="rgpublished" class="form-control daterange-datemenu" placeholder="31/01/2025 - 20/02/2025" value="{{ Request::get('rgpublished') }}">
                        <span class="input-group-text"><i class="ph-calendar"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <!-- /laws date -->

        <!-- Fields filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Bidang Hukum</span>
                <div class="ms-auto">
                    <a href="#fields" class="text-reset @empty(Request::get('fields')) collapsed @endempty" data-bs-toggle="collapse" aria-expanded="false">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse @if(Request::get('fields')) show @endif" id="fields">
                <div class="sidebar-section-body">
                    @foreach ($fields as $key => $value)
                        @if ($loop->iteration === 6 AND !Request::get('fields') AND $fields->count() > 5)
                            <div id="fields-hidden" style="display: none">
                        @endif
                        <label class="form-check mb-2">
                            <input type="checkbox" name="fields[]" @checked(Request::get('fields') AND in_array($key, Request::get('fields'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                            <span class="form-check-label">{{ Str::title($value) }}</span>
                        </label>
                        @if ($loop->last AND !Request::get('fields') AND $fields->count() > 5)
                            </div>
                        @endif
                    @endforeach
                    @if (empty(Request::get('fields')) AND $fields->count() > 5)
                        <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="fields-hidden">Lihat semua</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /fields options -->

        <!-- Matters filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Urusan Pemerintahan</span>
                <div class="ms-auto">
                    <a href="#matters" class="text-reset @empty(Request::get('matters')) collapsed @endempty" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse @if(Request::get('matters')) show @endif" id="matters">
                <div class="sidebar-section-body">
                    @foreach ($matters as $key => $value)
                        @if ($loop->iteration === 6 AND !Request::get('matters') AND $matters->count() > 5)
                            <div id="matters-hidden" style="display: none">
                        @endif
                        <label class="form-check mb-2">
                            <input type="checkbox" name="matters[]" @checked(Request::get('matters') AND in_array($key, Request::get('matters'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                            <span class="form-check-label">{{ Str::title($value) }}</span>
                        </label>
                        @if ($loop->last AND !Request::get('matters') AND $matters->count() > 5)
                            </div>
                        @endif
                    @endforeach
                    @if(empty(Request::get('matters')) AND $matters->count() > 5)
                        <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="matters-hidden">Lihat semua</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /matters options -->

        <!-- Institutes filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Pemrakarsa</span>
                <div class="ms-auto">
                    <a href="#institutes" class="text-reset @empty(Request::get('institutes')) collapsed @endempty" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse @if(Request::get('institutes')) show @endif" id="institutes">
                <div class="sidebar-section-body">
                    @foreach ($institutes as $key => $value)
                        @if ($loop->iteration === 6 AND !Request::get('institutes') AND $institutes->count() > 5)
                            <div id="institutes-hidden" style="display: none">
                        @endif
                        <label class="form-check mb-2">
                            <input type="checkbox" name="institutes[]" @checked(Request::get('institutes') AND in_array($key, Request::get('institutes'))) class="form-check-input form-check-input-danger" value="{{ $key }}">
                            <span class="form-check-label">{{ Str::title($value) }}</span>
                        </label>
                        @if ($loop->last AND !Request::get('institutes') AND $institutes->count() > 5)
                            </div>
                        @endif
                    @endforeach
                    @if(empty(Request::get('institutes')) AND $institutes->count() > 5)
                        <a role="button" class="link-danger fs-sm options-hide-toggle" data-target="institutes-hidden">Lihat semua</a>
                    @endif
                </div>
            </div>
        </div>
        <!-- /institute options -->

        <!-- Other filter -->
        <div class="sidebar-section">
            <div class="sidebar-section-header border-bottom">
                <span class="fw-semibold">Filter Lainnya</span>
                <div class="ms-auto">
                    <a href="#others" class="text-reset collapsed" data-bs-toggle="collapse">
                        <i class="ph-caret-down collapsible-indicator"></i>
                    </a>
                </div>
            </div>

            <div class="collapse" id="others">
                <div class="sidebar-section-body">
                    <div class="mb-3">
                        <label class="form-label">Subjek:</label>
                        <input id="subject" type="search" name="subject" class="form-control" placeholder="Contoh: RETRIBUSI" value="{{ Request::get('subject') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sumber:</label>
                        <input id="source" type="search" name="source" class="form-control" placeholder="Contoh: BD KABUPATEN LANGKAT 2022" value="{{ Request::get('source') }}">
                    </div>
                    <label class="form-label">Penandatangan:</label>
                    <input id="author" type="search" name="author" class="form-control" placeholder="Contoh: Faisal Hasrimy" value="{{ Request::get('author') }}">
                </div>
            </div>
        </div>
        <!-- /other filter -->
    </form>

</div>
<!-- /filter -->
