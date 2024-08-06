<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        // dd($request);
        if ($request->ajax()) {
            $products = Product::query();
            return Datatables::of($products)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return "<a href='javascript:void(0)' class='btn btn-success' onclick='show_modal_edit(`modal_user`, $row->id)'>Edit</a> <a href='javascript:void(0)' class='btn btn-danger' onclick='show_modal_delete($row->id)'>delete</a>";
                })
                ->filter(function($product){
                    if (request()->has("data_range") && request()->input('data_range') !== '0') {
                        $rangeInput = request()->input('data_range');
                        $range = explode(' - ', $rangeInput);
                        $min = (int) $range[0];
                        $max = (int) $range[1];
                        if ($max === 0) {
                            // If $max is 0, include all prices from $min onwards
                            $product->where('price', '>=', $min);
                        } else {
                        $product->whereBetween('price', [$min, $max]);
                        }
                    }
                },true)
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
                'qty' => $request->qty,
            ];
            Product::create($product);

            return response()->json([
                   'status' => 'success',
                    'message' => 'Successfully create user',
            ], 200);
        }catch(\Exception  $ex){
            return response()->json([
                'status' => 'error',
                'message' => $ex -> getMessage()
            ]);
        }
    }

    public function edit($id){
        try{
            $product = Product::findOrFail($id);

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully create product',
                'data' => $product,
            ], 200);
        }catch(Error $er){
            return response()->json([
                'status' => 'error',
                'message' => $er -> getMessage()
            ]);
        }
    }

    public function update(Request $request, string $id)
    {
        try{
            $product = Product::findOrFail($id);

            $product->name = $request->name;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $HEHE_BOI = "HEHE_BOI";
            $product->update();

            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Update Product',
            ], 200);
        }catch(Error $er){
            return response()->json([
                'status' => 'error',
                'message' => $er -> getMessage()
            ]);
        }
    }

    public function destroy($id){
        try{
            $product = Product::findOrFail($id);
            $product->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully Delete Product',
            ], 200);
        }
        catch(Error $er){
            return response()->json([
                'status' => 'error',
                'message' => $er -> getMessage()
            ]);
        }
    }
}

Thiệt là tốt quá đi ạ
Chột bay lớ sin đạ
Wu sấu đơ lợ, wai đâu wi ka, am ớ trên lợ hợ
Min bí si dợ, bum bi đo trợ,bao um đơ pợ
Đơi sớ ni kợ, am bí sơ đợ, bu cơ sây dợ dợ
