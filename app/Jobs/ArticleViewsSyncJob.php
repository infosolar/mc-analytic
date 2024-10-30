<?php

namespace App\Jobs;

use App\Models\IntegrationLog;
use App\Services\Import\ArticleViewsImportService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Class ArticleViewsSyncJob
 * @package App\Jobs
 */
class ArticleViewsSyncJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Carbon $periodFrom;
    private Carbon $periodTo;
    private int $offset;

    public int $timeout = 400;

    /**
     * Create a new job instance.
     *
     * @param Carbon $periodFrom
     * @param Carbon $periodTo
     * @param int $offset
     * @return void
     */
    public function __construct(Carbon $periodFrom, Carbon $periodTo, int $offset = 0)
    {
        $this->periodFrom = $periodFrom;
        $this->periodTo = $periodTo;
        $this->offset = $offset;
    }

    /**
     * Execute the job.
     *
     * @param ArticleViewsImportService $articleViewsImportService
     * @return void
     */
    public function handle(ArticleViewsImportService $articleViewsImportService)
    {
        try {
            $articleViewsImportService->getUpdatesFromApi(
                $this->periodFrom
                    ->copy()
                    ->timezone('Europe/Kiev')
                    ->toDateTimeString(),
                $this->periodTo
                    ->copy()
                    ->timezone('Europe/Kiev')
                    ->toDateTimeString(),
                $this->offset
            );
            $articleViewsImportService->handleUpdatesFromApi();

            if ($articleViewsImportService->isContinuation()) {
                self::dispatch($this->periodFrom, $this->periodTo, $this->offset + $articleViewsImportService::PER_PAGE)
                    ->delay(now()->addSeconds(65))
                    ->onQueue('default');
            } else {
                $message = $this->offset === 0
                    ? __('integration.successful_job.empty_articles_list')
                    : __('integration.successful_job.full_articles_list');
                IntegrationLog::create([
                    'message' => $message,
                    'sync_period_from' => $this->periodFrom,
                    'sync_period_to' => $this->periodTo,
                    'sync_offset' => null,
                    'sync_status' => true,
                ]);
                if (Carbon::now()->diffInMinutes($this->periodTo) > 65 && Carbon::now() > $this->periodTo) {
                    self::dispatch(
                        $this->periodTo,
                        $this->periodTo->copy()->addHour(),
                        0
                    )
                        ->delay(now()->addSeconds(65))
                        ->onQueue('default');
                }
            }
        } catch (\Throwable $throwable) {
            IntegrationLog::create([
                'message' => $throwable->getMessage(),
                'sync_period_from' => $this->periodFrom,
                'sync_period_to' => $this->periodTo,
                'sync_offset' => $this->offset,
                'sync_status' => false,
            ]);
        }
    }
}
