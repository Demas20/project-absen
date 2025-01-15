<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;
    protected $table = 'diskusi';
    protected $fillable = ['tugas_id','group_id', 'user_id', 'comment'];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(Admin::class);
    }

    // Relasi ke group
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
