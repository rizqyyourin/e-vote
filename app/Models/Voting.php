<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'slug',
        'title',
        'description',
        'status',
        'starts_at',
        'ends_at',
        'top_results',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = self::generateUniqueSlug();
            }
        });
    }

    public static function generateUniqueSlug(): string
    {
        do {
            $slug = bin2hex(random_bytes(12)); // 24-character random hex string
        } while (self::where('slug', $slug)->exists());

        return $slug;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
        ];
    }

    /**
     * Get the admin who created this voting
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get all candidates for this voting
     */
    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class);
    }

    /**
     * Get all votes for this voting
     */
    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    /**
     * Check if voting is active
     */
    public function isActive(): bool
    {
        if ($this->status !== 'active') {
            return false;
        }

        // If no start_at, voting is active when status is active
        if (!$this->starts_at) {
            return !$this->ends_at || $this->ends_at > now();
        }

        // If start_at exists, check if it's passed and end_at hasn't passed
        return $this->starts_at <= now() && (!$this->ends_at || $this->ends_at > now());
    }

    /**
     * Check if voting has started
     */
    public function hasStarted(): bool
    {
        return $this->starts_at && $this->starts_at <= now();
    }

    /**
     * Check if voting has finished
     */
    public function hasFinished(): bool
    {
        return $this->ends_at && $this->ends_at <= now();
    }

    /**
     * Get vote count per candidate
     */
    public function getVoteCount(): array
    {
        return $this->candidates()
            ->withCount('votes')
            ->get()
            ->map(fn ($candidate) => [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'vote_count' => $candidate->votes_count,
            ])
            ->sortByDesc('vote_count')
            ->toArray();
    }

    /**
     * Get top results
     */
    public function getTopResults(): array
    {
        return array_slice($this->getVoteCount(), 0, $this->top_results);
    }

    /**
     * Get total voters for this voting
     */
    public function getTotalVoters(): int
    {
        return $this->votes()->count();
    }
}
