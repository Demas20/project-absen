<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupSubtask;
use App\Models\TaskDetail as TugasDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SubtaskController extends Controller
{
    public function uploadJawaban(Request $request, $tugasDetailId)
    {
        $siswa = Auth::guard('admin')->user();
        $siswaDetails = DB::table('students')
        ->join('classes', 'students.class_id', '=', 'classes.id') // Join dengan kelas
        ->join('groups', 'students.group_id', '=', 'groups.id') // Join dengan kelompok
        ->join('jurusan', 'classes.jurusan_id', '=', 'jurusan.id') // Join dengan jurusan
        ->select(
            'students.name',
            'groups.id as group_id',
            'classes.name as kelas_name',
            'groups.name as kelompok_name',
            'jurusan.name as jurusan_name'
        )->where('students.name','=', $siswa->name)->first();
        // dd($siswaDetails);
        // Validasi file
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx', // sesuaikan dengan jenis file yang diterima
        ]);

        // Temukan tugas detail berdasarkan ID
        $tugasDetail = TugasDetail::findOrFail($tugasDetailId);
        // dd($tugasDetail);
        // Cek apakah sudah ada file untuk kelompok ini
        $groupSubtask = GroupSubtask::where('tugas_detail_id', $tugasDetailId)
            ->where('group_id', $siswaDetails->group_id) // Asumsikan kamu menggunakan auth dan group_id ada di user
            ->first();
        // Jika tidak ada, buat entri baru
        if (!$groupSubtask) {
            $groupSubtask = new GroupSubtask();
            $groupSubtask->tugas_detail_id = $tugasDetailId;
            $groupSubtask->group_id = $siswaDetails->group_id; // Pastikan ada group_id di user
        }

        // Simpan file ke storage
        $filePath = $request->file('file')->store('uploads/subtask', 'public'); // Menyimpan file ke 'storage/app/uploads/subtasks'

        // Update status dan file
        $groupSubtask->file = $filePath;
        $groupSubtask->is_completed = true; // Setelah upload, anggap selesai
        $groupSubtask->save();

        // Cek status selesai tugas secara keseluruhan untuk semua kelompok
        $this->checkTugasCompletion($tugasDetail);

        return redirect()->back()->with('success', 'Jawaban berhasil diupload.');
    }
    private function checkTugasCompletion(TugasDetail $tugasDetail)
    {
        // Eager load groupSubtasks untuk menghindari masalah lazy loading
        $tugasDetail->load('groupSubtasks');

        // Cek apakah semua kelompok sudah selesai mengerjakan subtugas ini
        $allCompleted = $tugasDetail->groupSubtasks->every(function ($groupSubtask) {
            return $groupSubtask->is_completed;
        });

        // Update status tugas utama jika semua subtugas kelompok sudah selesai
        // if ($allCompleted) {
        //     $tugasDetail->tugas->status = 'completed'; // Status tugas
        //     $tugasDetail->tugas->save();
        // }
    }

}
