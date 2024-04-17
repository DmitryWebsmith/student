<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function test()
    {
        return $this->hasOne(Test::class, 'id', 'test_id');
    }

    public function test_passed()
    {
        return $this->hasOne(TestPassed::class, 'test_id', 'test_id');
    }

    public function group()
    {
        return $this->hasOne(Group::class, 'id', 'group_id');
    }
}
