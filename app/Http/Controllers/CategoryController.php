<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Web_contents;
use App\Web_contents_photos;


class CategoryController extends Controller
{
    public $cateGoryIndexView = 'Back_End.web_contents.categoryIndex';

    public function index()
    {
        return view('Back_End.web_contents.category_panel');
    }



}
