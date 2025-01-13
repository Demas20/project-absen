<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\TaskDetail;
use Illuminate\Http\Request;
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
            $tugas->file = $request->file('file')->store('tasks');
        }

        $tugas->save();

        // Simpan tugas detail
        if ($request->has('detail_name')) {
            foreach ($request->detail_name as $index => $detailName) {
                $detail = new TaskDetail();
                $detail->task_id = $tugas->id;
                $detail->name = $detailName;
                $detail->description = $request->detail_description[$index] ?? null;
                $detail->deadline = $request->detail_deadline[$index];

                // Simpan file tugas detail
                if ($request->hasFile("detail_file.$index")) {
                    $detail->file = $request->file("detail_file.$index")->store('task_details');
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

}
