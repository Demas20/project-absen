<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TaskDetail as TugasDetail;
class GroupSubtask extends Model
{
    use HasFactory;

    // Nama tabel yang digunakan oleh model ini
    protected $table = 'group_subtasks';

    // Atribut yang dapat diisi (mass assignable)
    protected $fillable = [
        'tugas_detail_id',
        'group_id',
        'file',
        'is_completed',
        'nilai',
    ];

    /**
     * Definisikan hubungan ke model TugasDetail.
     * Setiap GroupSubtask terkait dengan satu tugas detail.
     */
    public function tugasDetail()
    {
        return $this->belongsTo(TugasDetail::class, 'tugas_detail_id');
    }

    /**
     * Definisikan hubungan ke model Group.
     * Setiap GroupSubtask terkait dengan satu grup (kelompok).
     */
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * Memeriksa apakah tugas ini sudah selesai dikerjakan oleh kelompok.
     */
    public function isCompleted()
    {
        return $this->is_completed;
    }
}
