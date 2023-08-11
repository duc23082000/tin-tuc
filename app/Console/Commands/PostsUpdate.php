<?php

namespace App\Console\Commands;

use App\Enums\PostStatusEnum;
use App\Models\Post;
use Illuminate\Console\Command;

class PostsUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::where('posted_at', today())->update(['status' => PostStatusEnum::PubLic]);
    }
}
