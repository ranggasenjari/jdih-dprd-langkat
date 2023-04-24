<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Traits\TimeHelper;
use App\Models\Traits\HasPublishedAt;
use App\Models\Traits\HasLegislationDocument;
use App\Models\Traits\HasUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cookie;

class Legislation extends Model
{
    use HasFactory, SoftDeletes, TimeHelper, HasPublishedAt, HasLegislationDocument, HasUser;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'code_number',
        'number',
        'year',
        'call_number',
        'edition',
        'place',
        'location',
        'approved',
        'published',
        'publisher',
        'source',
        'subject',
        'status',
        'language',
        'author',
        'institute_id',
        'field_id',
        'signer',
        'desc',
        'isbn',
        'index_number',
        'justice',
        'user_id',
        'published_at',
        'note',
    ];

    protected $casts  = [
        'approved'     => 'date',
        'published'    => 'date',
        'published_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function relations(): HasMany
    {
        return $this->hasMany(LegislationRelationship::class);
    }

    public function scopeOfRelation($query, $type): void
    {
        $query->whereRelation('relations', 'type', $type);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(LegislationDocument::class);
    }

    public function matters(): BelongsToMany
    {
        return $this->belongsToMany(Matter::class);
    }

    public function institute(): BelongsTo
    {
        return $this->belongsTo(Institute::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function logs(): HasMany
    {
        return $this->hasMany(LegislationLog::class)->latest();
    }

    public function typeFlatButton(): Attribute
    {
        if ($this->category->type_id === 1) {
            $button = '<button type="button" class="btn btn-flat-success rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-scales m-1"></i></button>';
        } else if ($this->category->type_id === 2) {
            $button = '<button type="button" class="btn btn-flat-indigo rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-books m-1"></i></button>';
        } else if ($this->category->type_id === 3) {
            $button = '<button type="button" class="btn btn-flat-primary rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-newspaper m-1"></i></button>';
        } else if ($this->category->type_id === 4) {
            $button = '<button type="button" class="btn btn-flat-danger rounded-pill p-1 border-0" data-bs-popup="tooltip" title="' . $this->category->type->name . '">
            <i class="ph-stamp m-1"></i></button>';
        }

        return Attribute::make(
            get: fn ($value) => $button
        );
    }

    public function shortTitle(): Attribute
    {
        $shortTitle = match ($this->category->type_id) {
            1   => $this->category->name . ' Nomor ' . $this->code_number . ' Tahun ' . $this->year,
            4   => 'Putusan ' . Str::title($this->justice) . ' Nomor ' . $this->code_number,
            default => $this->title,
        };

        return Attribute::make(
            get: fn ($value) => $shortTitle
        );
    }

    public function excerpt(): Attribute
    {
        $excerpt = match ($this->category->type_id) {
            2 => '<span class="fw-semibold">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="fw-semibold">Penerbit:</span> ' . $this->publisher,
            3 => '<span class="fw-semibold">T.E.U. Orang/Badan:</span> ' . $this->author . '<br /><span class="fw-semibold">Sumber:</span> ' . $this->source,
            default => strip_tags($this->title),
        };

        return Attribute::make(
            get: fn ($value) => $excerpt
        );
    }

    public function statusBadge(): Attribute
    {
        if ($this->status == 'berlaku') {
            $statusBadge = '<span class="badge bg-success bg-opacity-20 text-success">'.Str::title($this->status).'</span>';
        } else if ($this->status == 'tidak berlaku') {
            $statusBadge = '<span class="badge bg-danger bg-opacity-20 text-danger">'.Str::title($this->status).'</span>';
        } else {
            $statusBadge = '<span class="badge bg-info bg-opacity-20 text-info">'.Str::title($this->status).'</span>';
        }

        return Attribute::make(
            get: fn ($value) => $statusBadge
        );
    }

    public function approved(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d-m-Y'),
            set: fn ($value) => Carbon::parse($value)->translatedFormat('Y-m-d'),
        );
    }

    public function published(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->translatedFormat('d-m-Y'),
            set: fn ($value) => Carbon::parse($value)->translatedFormat('Y-m-d'),
        );
    }

    public function matterString(): Attribute
    {
        $matters = $this->matters()->where('matter_id', '=', $this->id)->pluck('name');

        return Attribute::make(
            get: fn ($value) => implode(",", $matters->all())
        );
    }

    public function mattersList(): Attribute
    {
        $matters = $this->matters()->pluck('name');
        $mattersList = $matters->count() > 0 ? implode(", ", $matters->all()) : null;

        return Attribute::make(
            get: fn ($value) => $mattersList
        );
    }

    public function downloadCount(): Attribute
    {
        $count = $this->documents()->sum('download');

        return Attribute::make(
            get: fn ($value) => $count
        );
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'name', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('category', 'abbrev', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {
        if ($title = $request->title AND $title = $request->title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($type = $request->type AND $type = $request->type) {
            $query->whereRelation('category', 'type_id', $type);
        }

        if ($types = $request->types AND $types = $request->types) {
            $query->whereHas('category.type', function (Builder $q) use ($types) {
                $q->whereIn('slug', $types);
            });
        }

        if ($category = $request->category AND $category = $request->category AND !is_object($category)) {
            $query->where('category_id', $category);
        }

        if ($categories = $request->categories AND $categories = $request->categories) {
            $query->whereHas('category', function (Builder $q) use ($categories) {
                $q->whereIn('slug', $categories);
            });
        }

        if ($code_number = $request->code_number AND $code_number = $request->code_number) {
            $query->where('code_number', 'LIKE', '%' . $code_number . '%');
        }

        if ($number = $request->number AND $number = $request->number) {
            $query->where('number', $number);
        }

        if ($month = $request->month AND $month = $request->month) {
            $query->whereMonth('published', $month);
        }

        if ($year = $request->year AND $year = $request->year) {
            $query->where('year', $year);
        }

        if ($approved = $request->approved AND $approved = $request->approved) {
            $query->whereDate('approved', Carbon::parse($approved)->format('Y-m-d'));
        }

        if ($rgapproved = $request->rgapproved AND $rgapproved = $request->rgapproved) {
            $dates = explode(' - ', $rgapproved);
            $fromDate = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $toDate = Carbon::createFromFormat('d/m/Y', $dates[1]);
            $query->whereBetween('approved', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        }

        if ($published = $request->published AND $published = $request->published) {
            $query->whereDate('published', Carbon::parse($published)->format('Y-m-d'));
        }

        if ($rgpublished = $request->rgpublished AND $rgpublished = $request->rgpublished) {
            $dates = explode(' - ', $rgpublished);
            $fromDate = Carbon::createFromFormat('d/m/Y', $dates[0]);
            $toDate = Carbon::createFromFormat('d/m/Y', $dates[1]);
            $query->whereBetween('published', [Carbon::parse($fromDate)->format('Y-m-d'), Carbon::parse($toDate)->format('Y-m-d')]);
        }

        if ($place = $request->place AND $place = $request->place) {
            $query->where('place', 'LIKE', '%' . $place . '%');
        }

        if ($source = $request->source AND $source = $request->source) {
            $query->where('source', 'LIKE', '%' . $source . '%');
        }

        if ($subject = $request->subject AND $subject = $request->subject) {
            $query->where('subject', 'LIKE', '%' . $subject . '%');
        }

        if ($language = $request->language AND $language = $request->language) {
            $query->where('language', 'LIKE', '%' . $language . '%');
        }

        if ($author = $request->author AND $author = $request->author) {
            $query->where('author', 'LIKE', '%' . $author . '%');
        }

        if ($institute = $request->institute AND $institute = $request->institute) {
            $query->where('institute_id', $institute);
        }

        if ($institutes = $request->institutes AND $institutes = $request->institutes) {
            $query->whereHas('institute', function (Builder $q) use ($institutes) {
                $q->whereIn('slug', $institutes);
            });
        }

        if ($field = $request->field AND $field = $request->field) {
            $query->where('field_id', $field);
        }

        if ($fields = $request->fields AND $fields = $request->fields) {
            $query->whereHas('field', function (Builder $q) use ($fields) {
                $q->whereIn('slug', $fields);
            });
        }

        if ($signer = $request->signer AND $signer = $request->signer) {
            $query->where('signer', 'LIKE', '%' . $signer . '%');
        }

        if ($location = $request->location AND $location = $request->location) {
            $query->where('location', 'LIKE', '%' . $location . '%');
        }

        if ($status = $request->status AND $status = $request->status) {
            $query->where('status', $status);
        }

        if ($statuses = $request->statuses AND $statuses = $request->statuses) {
            $query->whereIn('status', $statuses);
        }

        if ($matter = $request->matter AND $matter = $request->matter) {
            $query->whereRelation('matters', 'id', $matter);
        }

        if ($matters = $request->matters AND $matters = $request->matters) {
            $query->whereHas('matters', function (Builder $q) use ($matters) {
                $q->whereIn('slug', $matters);
            });
        }

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->whereRelation('user', 'id', $user);
        }

        if ($request->no_master) {
            $query->whereDoesntHave('documents', function (Builder $q) {
                $q->where('type', 'master');
            });
        }

        if ($request->no_abstract) {
            $query->whereDoesntHave('documents', function (Builder $q) {
                $q->where('type', 'abstract');
            });
        }

        if ($isbn = $request->isbn AND $isbn = $request->isbn) {
            $query->where('isbn', 'LIKE', '%' . $isbn . '%');
        }

        if ($desc = $request->desc AND $desc = $request->desc) {
            $query->where('desc', 'LIKE', '%' . $desc . '%');
        }

        if ($index_number = $request->index_number AND $index_number = $request->index_number) {
            $query->where('index_number', 'LIKE', '%' . $index_number . '%');
        }

        if ($publisher = $request->publisher AND $publisher = $request->publisher) {
            $query->where('publisher', 'LIKE', '%' . $publisher . '%');
        }

        if ($edition = $request->edition AND $edition = $request->edition) {
            $query->where('edition', 'LIKE', '%' . $edition . '%');
        }

        if ($call_number = $request->call_number AND $call_number = $request->call_number) {
            $query->where('call_number', 'LIKE', '%' . $call_number . '%');
        }
    }

    public function scopeSorted($query, $request = []): void
    {
        if (isset($request['order'])) {
            if ($request['order'] === 'category') {
                $query->orderBy('category_name', $request['sort']);
            } else if ($request['order'] === 'user') {
                $query->orderBy('user_name', $request['sort']);
            } else if ($request['order'] === 'latest') {
                $query->latest();
            } else if ($request['order'] === 'latest-approved') {
                $query->orderBy('published', 'desc');
            } else if ($request['order'] === 'popular') {
                $query->orderBy('view', 'desc');
            } else if ($request['order'] === 'number-asc') {
                $query->orderBy('number', 'asc');
            } else if ($request['order'] === 'most-viewed') {
                $query->orderBy('view', 'desc');
            } else if ($request['order'] === 'rare-viewed') {
                $query->orderBy('view', 'asc');
            } else {
                $query->orderBy($request['order'], $request['sort']);
            }
        } else {
            $query->latest();
        }
    }

    public function scopeLatestApproved($query): void
    {
        $query->orderBy('published', 'desc');
    }

    public function scopeOfType($query, $typeId): void
    {
        $query->whereRelation('category', 'type_id', $typeId);
    }

    public function publisher(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value)
        );
    }

    public function place(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Str::title($value)
        );
    }

    public function incrementViewCount()
    {
        $count = $this->view;
        if (!request()->cookie($this->slug)) {
            Cookie::queue($this->slug, request()->ip(), 1440);
            $count = $this->view++;
            $this->save();
        }

        return $count;
    }
}
