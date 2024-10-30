<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetArticleRequest;
use App\Http\Requests\GetArticlesBatchRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

/**
 * Class ArticleController
 * @package App\Http\Controllers
 */
class ArticleController extends Controller
{
    /**
     * @param GetArticleRequest $articleRequest
     * @return ArticleResource|\Illuminate\Http\JsonResponse
     */
    public function getArticle(GetArticleRequest $articleRequest): ArticleResource|\Illuminate\Http\JsonResponse
    {
        $article = Article::firstWhere('url', $articleRequest->get('url'));
        if (!$article) {
            return response()->json([], 404);
        }
        return ArticleResource::make($article);
    }

    /**
     * @param GetArticlesBatchRequest $articlesBatchRequest
     * @return AnonymousResourceCollection
     */
    public function getArticlesBatch(GetArticlesBatchRequest $articlesBatchRequest): AnonymousResourceCollection
    {
        $article = Article::whereIn('url', $articlesBatchRequest->get('urls'))
            ->get();
        return ArticleResource::collection($article);
    }
}
