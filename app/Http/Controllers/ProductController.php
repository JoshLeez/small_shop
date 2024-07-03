<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

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

    public function dtable(Request $request)
    {
        // $product = Product::select(['name', 'price', 'qty'])->get();
        // // dd($product);
        // return Datatables::of($product)->toJson();
        if ($request->ajax()) {
            $product = Product::select(['name','price','qty']);
        return Datatables::of($product)
         ->addIndexColumn()
         ->toJson();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $product = [
            'name'=> $request->name,
            'price'=> $request->price,
            'qty' => $request->price,
        ];
        Product::create($product);

        return response()->json([
               'status' => 'success',
                'message' => 'Successfully create user',
        ], 200);
    }

}

