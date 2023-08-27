<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    // use HasFactory;
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'user', 'completed', 'completed_at'];

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}
