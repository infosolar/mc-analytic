<?php

namespace App\Services\Import;

use App\Models\Article;

/**
 * Class ArticleViewsImportService
 * @package App\Services\Import
 */
class ArticleViewsImportService
{
    public const PER_PAGE = 2500;

    private IntegrationService $integrationService;
    private bool $continuationStatus = false;
    private array $apiAnswer = [];

    /**
     * ArticleViewsImportService constructor.
     * @param IntegrationService $integrationService
     */
    public function __construct(IntegrationService $integrationService)
    {
        $this->integrationService = $integrationService;
    }

    /**
     * @param string $periodFrom
     * @param string $periodTo
     * @param int $offset
     * @throws \Exception
     */
    public function getUpdatesFromApi(string $periodFrom, string $periodTo, int $offset): void
    {
        $params = [
            'entities' => [
                'articles' => [
                    'entity' => 'articles',
                    'details' => ['pageviews']
                ]
            ],
            'options' => [
                'period' => [
                    'name' => 'range',
                    'at_from' => $periodFrom,
                    'at_to' => $periodTo,
                ],
                'per_page' => self::PER_PAGE,
                'offset' => $offset,
            ]
        ];
        $this->apiAnswer = $this->integrationService->downloadDataFromRemote($params);
    }

    /**
     * @throws \Exception
     */
    public function handleUpdatesFromApi(): void
    {
        $articles = $this->apiAnswer['articles']['list'] ?? null;

        if ($articles === null || !is_array($articles)) {
            throw new \Exception(__('integration.articles_not_exist'));
        } elseif (!empty($articles)) {
            $this->saveStatsToDatabase($articles);
            $this->continuationStatus = true;
        }
    }

    /**
     * @param array $articles
     */
    private function saveStatsToDatabase(array $articles): void
    {
        foreach ($articles as $article) {
            if (empty($article['url']) || empty($article['pageviews'])) {
                continue;
            }

            $articleName = !empty($article['page']) ? $article['page'] : null;

            /** @var Article $dbArticle */
            $dbArticle = Article::firstWhere('url', $article['url']);

            if ($dbArticle) {
                $dbArticle->name = $articleName ?? $dbArticle->name;
                $dbArticle->views += (int)$article['pageviews'];
                $dbArticle->save();
            } else {
                Article::create([
                    'url' => $article['url'],
                    'name' => $articleName,
                    'views' => (int)$article['pageviews'],
                ]);
            }
        }
    }

    /**
     * @return bool
     */
    public function isContinuation(): bool
    {
        return $this->continuationStatus;
    }
}
