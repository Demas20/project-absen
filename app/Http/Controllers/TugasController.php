<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\Group;
use App\Models\GroupSubtask;
use App\Models\TaskDetail;
use Illuminate\Http\Request;
use App\Models\Diskusi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TugasController extends Controller
{
    public function index(){
        $tugas = Tugas::with('mapel')->get();
        // dd($tugas);
        return view('tugas.index',compact('tugas'));
    }
    public function create(){
        $mapel = Mapel::all();
        return view('tugas.create',compact('mapel'));
    }
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'file' => 'nullable|file',
            'mapel_id' => 'required|exists:mapels,id',
            'detail_name.*' => 'required|string|max:255',
            'detail_deadline.*' => 'required|date',
            'detail_file.*' => 'nullable|file',
        ]);

// Simpan tugas utama
        $tugas = new Tugas();
        $tugas->name = $request->name;
        $tugas->description = $request->description;
        $tugas->deadline = $request->deadline;
        $tugas->mapel_id = $request->mapel_id;

        // Simpan file tugas utama
        if ($request->hasFile('file')) {
            $tugas->file = $request->file('file')->store('tasks', 'public');
        }

        $tugas->save();

        // Simpan tugas detail
        if ($request->has('detail_name')) {
            foreach ($request->detail_name as $index => $detailName) {
                $detail = new TaskDetail();
                $detail->tugas_id = $tugas->id;
                $detail->name = $detailName;
                $detail->description = $request->detail_description[$index] ?? null;
                $detail->deadline = $request->detail_deadline[$index];

                // Simpan file tugas detail
                if ($request->hasFile("detail_file.$index")) {
                    $detail->file = $request->file("detail_file.$index")->store('task_details', 'public');
                }

                $detail->save();
            }
        }

        return redirect()->route('tugas.dashboard')->with('success', 'Tugas berhasil ditambahkan!');
    }
    public function tugasSiswa()
    {
        // Ambil data siswa yang sedang login
        $siswa = Auth::guard('admin')->user();

        // Ambil tugas berdasarkan kelas dan kelompok siswa
        $tugas = DB::table('tugas')
            ->join('groups', 'tugas.kelompok_id', '=', 'groups.id')
            ->select('tugas.*', 'classes.name as kelas_name', 'groups.name as kelompok_name')
            ->where('classes.id', $siswa->kelas_id)
            ->where('groups.id', $siswa->kelompok_id)
            ->get();
        dd($tugas);
        return view('siswa.tugas', compact('tugas'));
    }

    public function uploadJawaban(Request $request, $tugasId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:2048',
        ]);

        // Upload file jawaban
        $filePath = $request->file('file')->store('jawaban', 'public');

        // Simpan data jawaban ke database
        DB::table('jawaban')->insert([
            'tugas_id' => $tugasId,
            'siswa_id' => Auth::guard('siswa')->id(),
            'file' => $filePath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Jawaban berhasil diunggah!');
    }
    public function detailTugas($id)
    {
        $siswa = Auth::guard('admin')->user();

        // Ambil group_id siswa dari tabel lain jika tidak ada langsung di tabel admin
        $groupId = DB::table('students')
            ->where('name', '=', $siswa->name) // Cari berdasarkan nama admin
            ->value('group_id'); // Ambil group_id siswa

        if (!$groupId) {
            return redirect()->route('tugas.index')->with('error', 'Group ID siswa tidak ditemukan.');
        }
        $diskusi = Diskusi::where('tugas_id', $id)
        ->where('group_id', $groupId)
        ->with('user') // Menampilkan nama user yang memberi komentar
        ->get();
        // Ambil data tugas dengan subtugas yang sesuai dengan group_id
        $tugas = Tugas::with(['details.groupSubtasks' => function ($query) use ($groupId) {
            $query->where('group_id', $groupId); // Filter berdasarkan group_id
        }])->find($id);
        // dd($tugas);
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

        if (!$tugas) {
            return redirect()->route('tugas.index')->with('error', 'Tugas tidak ditemukan.');
        }
            // dd($diskusi);
        // dd($tugas->details);
        // dd($tugas->details);
        return view('tugas.detail', compact('tugas','diskusi','groupId','siswaDetails'));
    }

}
