<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\IntegrationLog;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

/**
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function getIndex(): Factory|View|Application
    {
        return view('dashboard.index');
    }

    /**
     * @return Application|Factory|View
     */
    public function getArticles(): Factory|View|Application
    {
        $articles = Article::orderByDesc('views')->paginate(25);
        return view('dashboard.articles', [
            'articles' => $articles
        ]);
    }

    /**
     * @return Application|Factory|View
     */
    public function getLogs(): Factory|View|Application
    {
        $logs = IntegrationLog::orderByDesc('id')->paginate(25);
        return view('dashboard.logs', [
            'logs' => $logs
        ]);
    }
}
