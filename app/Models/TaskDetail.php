<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskDetail extends Model
{
    use HasFactory;

    protected $fillable = ['tugas_id', 'name', 'description', 'file', 'deadline'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }
}
