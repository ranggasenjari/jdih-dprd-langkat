<?php

namespace App\Models;

use App\Models\Traits\TimeHelper;
use App\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class LegislationLog extends Model
{
    use HasFactory, TimeHelper, HasUser;

    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'legislation_id',
        'user_id',
        'message',
    ];

    public function legislation(): BelongsTo
    {
        return $this->belongsTo(Legislation::class)->withTrashed();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $request): void
    {
        if (isset($request['search']) AND $search = $request['search']) {
            $query->where(function($q) use ($search) {
                $q->where('message', 'LIKE', '%' . $search . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $search . '%');
            });
        }
    }

    public function scopeFilter($query, $request): void
    {
        if ($message = $request->message AND $message = $request->message) {
            $query->where(function($q) use ($message) {
                $q->where('message', 'LIKE', '%' . $message . '%')
                ->orWhereRelation('legislation', 'title', 'LIKE', '%' . $message . '%');
            });
        }

        if ($month = $request->month AND $month = $request->month) {
            $query->whereMonth('created_at', $month);
        }

        if ($year = $request->year AND $year = $request->year) {
            $query->whereYear('created_at', $year);
        }

        if ($created_at = $request->created_at AND $created_at = $request->created_at) {
            $query->whereDate('created_at', Carbon::parse($created_at)->format('Y-m-d'));
        }

        if ($user = $request->user AND $user = $request->user) {
            $query->where('user_id', '=', $user);
        }
    }
}
