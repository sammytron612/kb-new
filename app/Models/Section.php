<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'section',
        'parent',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class, 'sectionid', 'id');
    }
}
