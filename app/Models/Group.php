<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TaskDetail as TugasDetail;
class Group extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $fillable = ['name'];
    public function tugasdetails()
    {
        return $this->belongsToMany(TugasDetail::class, 'group_subtasks')
                    ->withPivot('is_completed', 'file')
                    ->withTimestamps();
    }
}
