<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GroupSubtask;
class TaskDetail extends Model
{
    use HasFactory;
    protected $table = 'tugas_details';
    protected $fillable = ['tugas_id', 'name', 'description', 'file', 'deadline'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class,'tugas_id');
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_subtasks')
                    ->withPivot('is_completed', 'file')
                    ->withTimestamps();
    }
    public function groupSubtasks()
    {
        return $this->hasMany(GroupSubtask::class, 'tugas_detail_id'); // Sesuaikan dengan nama kolom foreign key
    }
}
