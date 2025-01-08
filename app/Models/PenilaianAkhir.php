<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Student as Student;
use App\Models\Tugas;

class PenilaianAkhir extends Model
{
    use HasFactory;
    protected $table = 'penilaian_akhir';

    protected $fillable = ['student_id', 'tugas_id', 'nilai'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

}
