<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diskusi;
use Illuminate\Support\Facades\Auth;
class DiskusiController extends Controller
{
    public function store(Request $request,$tugasId, $groupId)
        {
            $request->validate([
                'comment' => 'required|string|max:1000',
            ]);

            Diskusi::create([
                'tugas_id' => $tugasId,
                'group_id' => $groupId,
                'user_id' => Auth::id(), // Menyimpan ID user yang login
                'comment' => $request->comment,
            ]);

            return back()->with('success', 'Komentar berhasil ditambahkan.');
        }


}
