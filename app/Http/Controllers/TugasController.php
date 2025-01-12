<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Tugas;
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
            'description' => 'required|string',
            'deadline' => 'required|date',
            'file' => 'required|file|mimes:doc,docx,xls,xlsx|max:2048',
            'mapel_id' => 'required|exists:mapels,id',
        ]);
    
        $filePath = $request->file('file')->store('tasks/files','public');
    
        Tugas::create([
            'name' => $request->name,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'file' => $filePath,
            'mapel_id' => $request->mapel_id,
        ]);
    
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
