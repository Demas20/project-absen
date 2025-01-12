<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas  as Classes;
use App\Models\Group;

class Student extends Model
{
    protected $fillable = ['NISN','name', 'profile_pic', 'class_id', 'group_id'];

    public function class()
    {
        return $this->belongsTo(Classes::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

}
