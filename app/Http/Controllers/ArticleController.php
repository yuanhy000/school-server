<?php

namespace App\Http\Controllers;

use App\Article;
use App\Events\CreateArticle;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function createArticle(Request $request)
    {
        $requestInfo = $request->all();
//        dd($requestInfo);
        event(new CreateArticle($requestInfo));
        return response()->json([
            'message' => '发布动态成功'
        ]);
    }

    public function getArticleDetail(Request $request)
    {
        $article_id = $request->all()['article_id'];
        $article = Article::find($article_id);
        Article::viewIncrement($article_id);

        return new ArticleResource($article, -1);
    }

}
