<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Laravel\Scout\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ShardingService;

class Post extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'title', 'body', 'user_id',
    ];

    protected $shardingService;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->shardingService = app(ShardingService::class);
    }

    public function getConnectionName()
    {
        // Bypass sharding logic during seeding
        if (app()->runningInConsole()) {
            return $this->connection;
        }

        // Check if user_id is set before determining the connection name
        if (isset($this->user_id)) {
            return $this->shardingService->getShardConnection($this->user_id)->getName();
        }

        // Default to the current connection if user_id is not set
        return $this->connection;
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $shardingService = app(ShardingService::class);
            $shardingService->ensureUserExists($post->user_id);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }

    public function searchableAs()
    {
        return 'posts_index';
    }

    public static function search($query = '', $callback = null)
    {
        return new Builder(new static, $query, $callback);
    }
}
