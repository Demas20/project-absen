<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    use HasFactory;
    
    protected $table = 'jurusan';
    protected $fillable = ['name'];
    public function classes()
    {
        return $this->hasMany(Kelas::class, 'jurusan_id');
    }
}
