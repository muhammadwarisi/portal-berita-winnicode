<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ArticleReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua reviewer (anggap role_id 2 adalah reviewer)
        $reviewers = User::where('role_id', 2)->get();
        
        // Jika tidak ada reviewer, tidak bisa melanjutkan seeding
        if ($reviewers->isEmpty()) {
            $this->command->info('Tidak ada reviewer yang ditemukan. Seeding dibatalkan.');
            return;
        }
        
        // Ambil semua artikel
        $articles = Article::all();
        
        // Status yang mungkin untuk review
        $statuses = ['pending', 'approved', 'rejected'];
        
        // Komentar template untuk setiap status
        $commentTemplates = [
            'pending' => [
                'Artikel ini sedang dalam proses review.',
                'Saya masih mengevaluasi konten artikel ini.',
                'Perlu waktu tambahan untuk meninjau artikel ini secara menyeluruh.'
            ],
            'approved' => [
                'Artikel ini sudah baik dan layak untuk dipublikasikan.',
                'Konten artikel informatif dan sesuai dengan standar.',
                'Artikel ini memiliki kualitas yang baik, disetujui untuk publikasi.',
                'Saya menyetujui artikel ini karena kontennya akurat dan bermanfaat.'
            ],
            'rejected' => [
                'Artikel ini perlu perbaikan pada bagian konten utama.',
                'Ada beberapa kesalahan faktual yang perlu diperbaiki.',
                'Struktur artikel kurang baik dan perlu direvisi.',
                'Konten artikel tidak memenuhi standar kualitas yang diharapkan.'
            ]
        ];
        
        foreach ($articles as $article) {
            // Pilih 1-3 reviewer secara acak untuk setiap artikel
            $reviewerCount = rand(1, min(3, $reviewers->count()));
            $selectedReviewers = $reviewers->random($reviewerCount);
            
            foreach ($selectedReviewers as $reviewer) {
                // Pilih status secara acak
                $status = $statuses[array_rand($statuses)];
                
                // Pilih komentar yang sesuai dengan status
                $comments = $commentTemplates[$status][array_rand($commentTemplates[$status])];
                
                // Tentukan tanggal review (antara 1-14 hari yang lalu)
                $reviewedAt = null;
                if ($status !== 'pending') {
                    $reviewedAt = Carbon::now()->subDays(rand(1, 14));
                }
                
                // Insert data ke tabel article_review
                DB::table('article_review')->insert([
                    'article_id' => $article->id,
                    'reviewer_id' => $reviewer->id,
                    'status' => $status,
                    'comments' => $comments,
                    'reviewed_at' => $reviewedAt,
                    'created_at' => Carbon::now()->subDays(rand(15, 30)), // Tanggal pembuatan review
                    'updated_at' => $reviewedAt ?? Carbon::now()->subDays(rand(1, 14))
                ]);
            }
        }
    }
}
