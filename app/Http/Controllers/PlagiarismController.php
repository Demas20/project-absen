<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupSubtask;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PlagiarismController extends Controller
{
    public function checkPlagiarism(Request $request, $groupSubtaskId)
    {
        // Ambil GroupSubtask berdasarkan ID yang diberikan
        $groupSubtask = GroupSubtask::findOrFail($groupSubtaskId);

        // Ambil semua GroupSubtask yang terkait dengan subtugas yang sama
        $subtaskId = $groupSubtask->tugas_detail_id;  // Asumsi ada relasi dengan subtugas
        $allGroupSubtasks = GroupSubtask::where('tugas_detail_id', $subtaskId)->get();

        // Ambil file jawaban dari GroupSubtask yang akan dibandingkan
        $fileToCompare = $groupSubtask->file;  // Asumsi ada relasi atau field 'file'

        // Logika untuk cek plagiarisme antara fileToCompare dan semua GroupSubtask lainnya
        $similarityResults = $this->checkFilesForPlagiarism($fileToCompare, $allGroupSubtasks);
        // dd($similarityResults);
        // Return hasil pengecekan plagiarisme
        return view('plagiarism.results', compact('similarityResults'));
    }

    private function checkFilesForPlagiarism($fileToCompare, $allGroupSubtasks)
    {
        $results = [];

        // Ambil teks dari fileToCompare
        $textToCompare = $this->getTextFromFile($fileToCompare);

        foreach ($allGroupSubtasks as $otherSubtask) {
            if ($otherSubtask->file !== $fileToCompare) { // Pastikan tidak membandingkan file yang sama
                $textToCompareWith = $this->getTextFromFile($otherSubtask->file);
                $comparisonResult = $this->compareFiles($textToCompare, $textToCompareWith);
                // dd($otherSubtask->file);
                $results[] = [
                    'group' => $otherSubtask->group->name ?? 'Unknown', // Nama kelompok
                    'similarity' => $comparisonResult, // Persentase kemiripan
                ];
            }
        }

        return $results;
    }


    // Fungsi untuk mengambil teks dari file (PDF/Word)
    // Fungsi untuk mengambil teks dari file (PDF/Word)
    // Fungsi untuk mengambil teks dari file (PDF/Word)
    private function getTextFromFile($file)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION); // Ambil extension file
        Log::info('Processing file: ' . $file . ' with extension: ' . $extension);

        $content = '';

        if ($extension === 'pdf') {
            $content = $this->getTextFromPdf($file);
        } elseif ($extension === 'docx') {
            $content = $this->getTextFromDocx($file);
        } else {
            Log::warning('Unsupported file type: ' . $extension);
        }
        // dd($this->getTextFromPdf($file));
        // Log untuk memeriksa hasil teks
        Log::info('Extracted content from file: ' . $content);
        return $content;
    }



    private function getTextFromPdf($filePath)
    {
        try {
            $fullPath = public_path('storage/' . $filePath);
            Log::info('Full PDF path: ' . $fullPath);
            // dd($fullPath);
            if (!file_exists($fullPath)) {
                Log::error('File not found: ' . $fullPath);
                return '';
            }

            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseFile($fullPath);
            $content = $pdf->getText();
            // dd($pdf->getText());
            Log::info('PDF content extracted: ' . $content);
            return $content;
        } catch (\Exception $e) {
            Log::error('Error parsing PDF: ' . $e->getMessage());
            return '';
        }
    }
    private function getTextFromDocx($filePath)
    {
        try {
            $fullPath = Storage::path($filePath); // Ambil path lengkap file
            Log::info('Full DOCX path: ' . $fullPath);

            if (!Storage::exists($filePath)) {
                Log::error('File not found: ' . $fullPath);
                return '';
            }

            $phpWord = \PhpOffice\PhpWord\IOFactory::load($fullPath);
            $content = '';

            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $content .= $element->getText() . ' ';
                    }
                }
            }

            Log::info('DOCX content extracted: ' . $content);
            return $content;
        } catch (\Exception $e) {
            Log::error('Error parsing DOCX: ' . $e->getMessage());
            return '';
        }
    }

    // Fungsi untuk membandingkan dua teks (misalnya menggunakan Cosine Similarity)
    private function compareFiles($text1, $text2)
    {
        similar_text($text1, $text2, $percent);
        return $percent;
    }
}
