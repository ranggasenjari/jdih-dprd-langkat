<?php
namespace App\Models\Traits;

use App\Models\LegislationDocument;
use App\Enums\LegislationDocumentType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasLegislationDocument
{
    public function documents(): HasMany
    {
        return $this->hasMany(LegislationDocument::class);
    }

    public function masterDocument()
    {
        return $this->documents()
            ->ofType(LegislationDocumentType::MASTER)
            ->first();
    }

    public function abstractDocument()
    {
        return $this->documents()
            ->ofType(LegislationDocumentType::ABSTRACT)
            ->first();
    }

    public function attachments()
    {
        return $this->documents()
            ->ofType(LegislationDocumentType::ATTACHMENT)
            ->get();
    }

    public function coverDocument()
    {
        return $this->documents()
            ->ofType(LegislationDocumentType::COVER)
            ->first();
    }

    public function documentSource($path)
    {
        return Storage::url($path);
    }

    public function masterDocumentSource(): Attribute
    {
        $master = $this->masterDocument();

        return Attribute::make(
            get: fn ($value) => empty($master) ? null : Storage::url($master->media->path)
        );
    }

    public function abstractDocumentSource(): Attribute
    {
        $abstract = $this->abstractDocument();

        return Attribute::make(
            get: fn ($value) => empty($abstract) ? null : Storage::url($abstract->media->path)
        );
    }

    public function coverSource(): Attribute
    {
        $cover = $this->coverDocument();

        $coverUrl = asset('assets/jdih/images/placeholders/placeholder.jpg');
        if (!empty($cover)) {
            if (Storage::disk('public')->exists($cover->media->path)) $coverUrl = Storage::url($cover->media->path);
        }

        return Attribute::make(
            get: fn ($value) => $coverUrl
        );
    }

    public function coverThumbSource(): Attribute
    {
        $cover = $this->coverDocument();

        $coverThumbUrl = asset('assets/jdih/images/placeholders/placeholder.jpg');
        if (!empty($cover)) {
            $ext = substr(strchr($cover->media->path, '.'), 1);
            $thumbnail = str_replace(".{$ext}", "_md.{$ext}", $cover->media->path);
            if (Storage::disk('public')->exists($thumbnail)) $coverThumbUrl = Storage::url($thumbnail);
        }

        return Attribute::make(
            get: fn ($value) => $coverThumbUrl
        );
    }
}
