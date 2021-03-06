<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Question extends Model
{
    protected $fillable = ['user_id', 'title', 'body'];

    public static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_hidden', function (Builder $builder) {
            $builder->where('is_hidden', 'F');
        });

    }

    public function isHidden()
    {
        return $this->is_hidden === 'T';
    }

    public function getAvatarAttribute($value)
    {
        return $value . '.jpg';
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
