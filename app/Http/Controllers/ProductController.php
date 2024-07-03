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
            $product = Product::all();
        return Datatables::of($product)
         ->addIndexColumn()
         ->addColumn('action', function($row){
             return "<a href='javascript:void(0)' class='btn btn-success' onclick='show_modal_edit(\"modal_user\", $row->id)'>Edit</a> <a class='btn btn-danger'>delete</a>";
         })
         ->toJson();
        }
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try{
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
        }catch(Error $er){
            return response()->json([
                'status' => 'error',
                'message' => $er -> getMessage()
            ]);
        }
    }

}

