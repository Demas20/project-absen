<?php

namespace App\Http\Controllers;

use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Student;
use App\Models\Admin;
use App\Models\Mapel;
use App\Models\Tugas;
use App\Models\TaskDetail;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function index(){
        $student = Student::with(['class.jurusan', 'group'])->get();
        // dd($student);
        return view('siswa.index',compact('student'));
    }
    public function tambahSiswa(){
        $kelas = DB::table('classes')
            ->join('jurusan', 'classes.jurusan_id', '=', 'jurusan.id') // Sesuaikan kondisi join
            ->select('classes.id','jurusan.name as jurusan_name','classes.name')->get();
        $group = Group::all();
        return view('siswa.create',compact('kelas','group'));
    }
    public function tambahSiswaStore(Request $request){
        // Validasi input
        $validated = $request->validate([
            'NISN' => 'required|unique:students,NISN', // Pastikan NIP unik di tabel teacher
            'name' => 'required|string|max:255|unique:students,name',
            'username' => 'required|unique:admins,username', // Pastikan username unik di tabel admin
            'password' => 'required|string|min:6', // Password wajib dan minimal 6 karakter
            'profile_pic' => 'nullable|image|max:2048',
            'class_id' => 'required',
            'group_id' => 'required' // Gambar opsional, maksimal 2MB
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $student = new Student();
            $student->NISN = $validated['NISN'];
            $student->name = $validated['name'];
            $student->class_id = $validated['class_id'];
            $student->group_id = $validated['group_id'];
            // Simpan gambar profile jika ada
            if ($request->hasFile('profile_pic')) {
                $filePath = $request->file('profile_pic')->store('profile_pics', 'public');
                $student->profile_pic = $filePath;
            }
            $student->save();

            // Simpan data admin dengan role 'GURU'
            $admin = new Admin();
            $admin->username = $validated['username'];
            $admin->name = $validated['name'];
            $admin->password = bcrypt($validated['password']); // Enkripsi password
            $admin->role = 'siswa'; // Set default role
            $admin->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('siswa.dashboard'))->with('success', 'Siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function checkUsername(Request $request)
    {
        $nameExists = Student::where('name', $request->name)->exists();
        $usernameExists = Admin::where('username', $request->username)->exists();
        $nipExists = Student::where('NISN', $request->NISN)->exists();

        if ($nameExists) {
            return response()->json([
                'field' => 'name',
                'status' => 'error',
                'message' => 'Nama sudah digunakan.'
            ], 200);
        }

        if ($usernameExists) {
            return response()->json([
                'field' => 'username',
                'status' => 'error',
                'message' => 'Username sudah digunakan.'
            ], 200);
        }

        if ($nipExists) {
            return response()->json([
                'field' => 'username',
                'status' => 'error',
                'message' => 'Username sudah digunakan.'
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data valid.'
        ], 200);
    }


    public function indexKelas(){
        $kelas = DB::table('classes')
            ->join('jurusan', 'classes.jurusan_id', '=', 'jurusan.id') // Sesuaikan kondisi join
            ->select('jurusan.name as jurusan_name','classes.name')->get();
            // dd($kelas);
        return view('kelas.index', compact('kelas'));
    }
    public function tambahKelas(){
        $jurusan = Jurusan::all();
        return view('kelas.create',compact('jurusan'));
    }
    public function tambahKelasStore(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'jurusan' => 'required',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $kelas = new Kelas();
            $kelas->name = $validated['name'];
            $kelas->jurusan_id = $validated['jurusan'];
            $kelas->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('kelas.index'))->with('success', 'Kelas berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function tambahJurusan(){
        return view('kelas.createJurusan');
    }
    public function tambahJurusanStore(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $jurusan = new Jurusan();
            $jurusan->name = $validated['name'];
            $jurusan->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('kelas.index'))->with('success', 'Jurusan berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    //group
    public function indexGroup(){
        $group = Group::all();
        return view('group.index',compact('group'));;
    }
    public function tambahGroup(){
        return view('Group.createGroup');
    }
    public function tambahGroupStore(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $group = new Group();
            $group->name = $validated['name'];
            $group->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('group.index'))->with('success', 'group berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function tambahMapel(){
        return view('tugas.tambahMapel');
    }
    public function tambahMapelStore(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $mapel = new Mapel();
            $mapel->name = $validated['name'];
            $mapel->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('tugas.dashboard'))->with('success', 'Mapel berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    //halaman siswa
    public function halamanSiswa(){
        // join login siswa nampilkan kelas dan group join bang berdasarkan akun login yaitu name
        $siswa = Auth::guard('admin')->user();
        $groupSiswa = $siswa->group;
        $detailTugas = TaskDetail::get();
        $groupId = DB::table('students')
        ->where('name', '=', $siswa->name)
        ->value('group_id');
        $tugas = Tugas::with(['details.groupSubtasks'])->get();

        foreach ($tugas as $item) {
            $groupNilai = [];

            foreach ($item->details as $detail) {
                $totalNilai = 0;
                $totalSubtasks = 0;

                // Hanya hitung nilai subtugas yang sesuai dengan group siswa
                foreach ($detail->groupSubtasks as $subtask) {
                    if ($subtask->group_id == $groupId && !is_null($subtask->nilai)) {
                        $totalNilai += $subtask->nilai;
                        $totalSubtasks++;
                    }
                }

                // Simpan nilai rata-rata hanya jika ada subtugas yang sesuai
                if ($totalSubtasks > 0) {
                    $groupNilai[] = [
                        'detailName' => $detail->name,
                        'rataRataNilai' => $totalNilai / $totalSubtasks,
                    ];
                }
            }

            $item->groupNilai = $groupNilai;
        }
        // dd($siswa);
    // Lakukan join untuk mengambil kelas dan kelompok
    $siswaDetails = DB::table('students')
        ->join('classes', 'students.class_id', '=', 'classes.id') // Join dengan kelas
        ->join('groups', 'students.group_id', '=', 'groups.id') // Join dengan kelompok
        ->join('jurusan', 'classes.jurusan_id', '=', 'jurusan.id') // Join dengan jurusan
        ->select(
            'students.name',
            'classes.name as kelas_name',
            'groups.name as kelompok_name',
            'jurusan.name as jurusan_name'
        )->where('students.name','=', $siswa->name)->first();
        // dd($detailTugas);
        // dd($siswaDetails);
        return view('siswa.halamanSiswa',compact('siswaDetails','tugas','detailTugas'));
    }
    public function detailTugas($id){
        dd($id);
    }
}
