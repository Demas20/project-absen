<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mapel;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable = ['name', 'description', 'deadline', 'file', 'mapel_id'];

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }
}
