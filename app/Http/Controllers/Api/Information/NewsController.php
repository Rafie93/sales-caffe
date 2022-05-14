<?php

namespace App\Http\Controllers\Api\Information;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Information\News;
use App\Http\Resources\Information\NewsList as ListResource;
use App\Http\Resources\Information\NewsItem as ItemResource;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('id','desc')
                    ->where('status',1)
                    ->get();
        return new ListResource($news);
    }

    public function detail(Request $request,$id)
    {
        $news = News::where('id',$id)->first();
        if ($news) {
            return new ItemResource($news);
        }else{
        return response()->json(['data'=>null], 200);
    
        }
    }
    

}
