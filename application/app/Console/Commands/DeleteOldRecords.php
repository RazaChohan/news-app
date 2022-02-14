<?php

namespace App\Console\Commands;

use App\Models\News;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes news records older than 14 days';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private News $news)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->news->where('created_at', '<=', Carbon::now()->subDays(14)->toDateTimeString())->delete();

        return 0;
    }
}
