<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\IntegrationLog;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Queue;

/**
 * Class ArticleViewsSyncCommand
 * @package App\Console\Commands
 */
class ArticleViewsSyncCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stat-api:sync-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get articles views from IO Technologies';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $queueSize = Queue::size();
        if ($queueSize === 0) {
            $periodFrom = IntegrationLog::latest('sync_period_to')
                ?->first()
                ?->sync_period_to ?? Carbon::now()->addHours(-1);
            $periodTo = $periodFrom->copy()->addHour();
            if ($periodTo > Carbon::now()) {
                $periodTo = Carbon::now();
            }

            \App\Jobs\ArticleViewsSyncJob::dispatch(
                $periodFrom,
                $periodTo,
                0
            )->onQueue('default');
        }
        return 0;
    }
}
