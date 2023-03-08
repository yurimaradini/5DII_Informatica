<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
    	$categories = Category::all();

    	$mainNews = News::orderBy('created_at', 'desc')->limit(1)->get()->first();

    	$news = News::orderBy('created_at', 'desc')->limit(10)->offset(1)->get();

        return view('news', [
        	'mainNews' => $mainNews,
            'news' => $news,
            'categories' => $categories
        ]);
    }

    public function getNews($id)
    {
    	$categories = Category::all();

    	$news = News::find($id);

    	return view('news-detail', [
            'news' => $news,
            'categories' => $categories
    	]);
    }

    public function getCategories($id)
    {
        $categories = Category::all();

    	$category = Category::find($id);
        
    	$news = $category->news;

        //$news = $categories->news();
    	return view('news', [
            'news' => $news,
            'categories' => $categories
        ]);
    }
}
