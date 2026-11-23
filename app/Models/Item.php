<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'category',
        'description',
        'location',
        'date_reported',
        'type',
        'status',
        'image_path',
    ];

    protected $casts = [
        'date_reported' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }
}
