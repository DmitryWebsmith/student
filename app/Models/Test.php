<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;

    protected $table = 'tests';

    public function questions()
    {
        return $this->hasMany(Question::class, 'test_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
