<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
class GuruController extends Controller
{
    public function index(){
        $teacher = DB::table('teacher')
            ->join('admins', 'teacher.name', '=', 'admins.name') // Sesuaikan kondisi join
            ->select('admins.role','teacher.NIP','teacher.name', 'admins.status_login')
            ->where('admins.role', '=', 'guru')->get();

        return view('Guru.index',compact('teacher'));
    }
    public function create(){
        return view('Guru.create');
    }
    public function store(Request $request){
        // Validasi input
        $validated = $request->validate([
            'NIP' => 'required|unique:teacher,NIP', // Pastikan NIP unik di tabel teacher
            'name' => 'required|string|max:255|unique:teacher,name',
            'username' => 'required|unique:admins,username', // Pastikan username unik di tabel admin
            'password' => 'required|string|min:6', // Password wajib dan minimal 6 karakter
            'profile_pic' => 'nullable|image|max:2048' // Gambar opsional, maksimal 2MB
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan data guru ke tabel teacher
            $teacher = new Teacher();
            $teacher->NIP = $validated['NIP'];
            $teacher->name = $validated['name'];

            // Simpan gambar profile jika ada
            if ($request->hasFile('profile_pic')) {
                $filePath = $request->file('profile_pic')->store('profile_pics', 'public');
                $teacher->profile_pic = $filePath;
            }
            $teacher->save();

            // Simpan data admin dengan role 'GURU'
            $admin = new Admin();
            $admin->username = $validated['username'];
            $admin->name = $validated['name'];
            $admin->password = bcrypt($validated['password']); // Enkripsi password
            $admin->role = 'guru'; // Set default role
            $admin->save();

            // Commit transaksi jika semua berhasil
            DB::commit();

            return redirect(route('guru.dashboard'))->with('success', 'Guru berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();

            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
