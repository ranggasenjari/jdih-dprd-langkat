@extends('jdih.layouts.app')

@section('title', 'Produk Hukum | ' . strip_tags($appName))
@section('content')

<!-- Page title -->
<section class="bg-dark bg-opacity-3 mb-4">
    <div class="page-content container py-3 px-0">
        <div class="content-wrapper">
            <div class="content">
                <div class="page-header page-header-content d-lg-flex">
                    <div class="page-title">
                        <h2 class="fw-bold mb-0">Produk Hukum</h2>
                    </div>

                    <div class="mb-3 my-lg-auto ms-lg-auto">
                        <div class="breadcrumb">
                            <a href="{{ route('homepage') }}" class="breadcrumb-item text-body"><i class="ph-house"></i></a>
                            <span class="breadcrumb-item active">Produk Hukum</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /page title -->

<!-- Page container -->
<div class="page-content container">
    @if (!$isMobile)
        @include('jdih.legislation.leftbar')
    @endif
    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Content area -->
        <main class="content ms-lg-3">

            <section class="d-flex align-items-center mb-3">
                <p class="mb-0">
                    Menampilkan

                    @isset ($legislation)
                        <span class="fw-semibold">{{ $legislations->firstItem() }}</span>
                        sampai
                        <span class="fw-semibold">{{ $legislations->lastItem() }}</span>
                        dari
                    @endisset

                    <span class="fw-semibold">{{ number_format($legislations->total(), 0, ',', '.') }}</span>
                    produk hukum
                    @if (Request::get('title'))
                        untuk
                        <span class="fw-semibold">"{{ Request::get('title') }}"</span>
                    @endif
                </p>
                <div class="ms-auto my-auto">
                    <span class="d-inline-block me-2">Urutkan</span>
                    <div class="btn-group">
                        <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                            @if(Request::get('order'))
                                {{ $orderOptions[Request::get('order')] }}
                            @else
                                {{ head($orderOptions) }}
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach ($orderOptions as $key => $value)
                                <a href="{{ route('legislation.index', ['order' => $key] + Request::query()) }}"
                                    class="dropdown-item @if(Request::get('order') === $key OR (empty(Request::get('order')) AND $loop->first)) active @endif">
                                    {{ $value }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

            @forelse ($legislations as $legislation)
                <article class="card card-body shadow mb-4">
                    <div class="d-sm-flex align-items-sm-start">

                        <a href="{{ route('legislation.'.$legislation->category->type->route.'.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="d-block me-sm-3 mb-3 mb-sm-0">
                            <img @isset ($legislation->masterDocumentSource) data-pdf-thumbnail-file="{{ $legislation->masterDocumentSource }}" @endisset src="{{ $legislation->coverThumbSource }}" alt="{{ $legislation->title }}" class="w-100 w-lg-120px shadow">
                        </a>

                        <div class="flex-fill">
                            <a href="{{ route('legislation.'.$legislation->category->type->route.'.category', $legislation->category->slug) }}"
                                class="badge bg-indigo bg-opacity-10 text-indigo rounded-pill mb-1">
                                {{ $legislation->category->name }}
                            </a>
                            <h4 class="mb-1">
                                <a href="{{ route('legislation.'.$legislation->category->type->route.'.show', ['category' => $legislation->category->slug, 'legislation' => $legislation->slug]) }}" class="text-body">{!! Str::highlightPhrase($legislation->shortTitle, Request::get('title')) !!}</a>
                            </h4>

                            <ul class="list-inline list-inline-bullet text-muted mb-3">
                                <li class="list-inline-item"><i class="ph-calendar-blank me-2"></i>{{ $legislation->dateFormatted($legislation->published_at) }}</li>
                                <li class="list-inline-item"><i class="ph-eye me-2"></i>{{ $legislation->view }}</li>
                                <li class="list-inline-item"><i class="ph-download me-2"></i>{{ $legislation->documents->sum('download') }}</li>
                                <!-- <li class="list-inline-item"><i class="ph-heart text-pink me-2"></i>12</li> -->
                            </ul>

                            <p class="fs-lg mb-0">{!! Str::highlightPhrase($legislation->excerpt, Request::get('title')) !!}</p>

                            @if ($legislation->category->type->id == 1)
                                <ul class="list-inline list-inline-bullet mb-0 mt-2">
                                    <li class="list-inline-item"><span class="fw-semibold">Status: </span>{!! $legislation->statusBadge !!}</li>
                                    <li class="list-inline-item"><span class="fw-semibold">Ditetapkan: </span>{{ $legislation->dateFormatted($legislation->approved) }}</li>
                                    <li class="list-inline-item"><span class="fw-semibold">Diundangkan: </span>{{ $legislation->dateFormatted($legislation->published) }}</li>
                                </ul>
                            @endif
                        </div>

                    </div>
                </article>

                @include('jdih.legislation.banner')

            @empty

                @include('jdih.layouts.not-found')

            @endforelse

            {{ $legislations->links('jdih.layouts.pagination') }}

        </main>
        <!-- /content area -->

    </div>
    <!-- /main content -->

</div>
<!-- /page container -->

@endsection

@section('script')
    @include('jdih.legislation.script')
@endsection
