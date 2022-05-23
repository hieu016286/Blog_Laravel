<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $title = 'THÔNG BÁO';
        DB::table('posts')->insert([
            'user_id' => 1,
            'title' => $title,
            'slug' => Str::slug($title.uniqid(),'-'),
            'image' => 'default.png',
            'body' => 'ĐẾN GIỜ ĐĂNG BÀI RỒI',
            'status' => 1,
            'is_approved' => 1
        ]);
        Log::info("Post Cron run successfully!");
    }
}
