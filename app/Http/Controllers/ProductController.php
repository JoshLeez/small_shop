<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index()
    {    
        $data = [
            'title' => 'Product',
            'page_title' => 'Product List'
        ];
        return view('admin.index', $data);
    }

}
