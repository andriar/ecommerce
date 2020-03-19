<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Product;
use Auth;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $product = $this->searchGenerator($request);
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 500;
            $this->content['error'] = 'Internal Server Error';
            $this->content['message'] = 'something went wrong';
            return response()->json($this->content, 500);
        }
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'type_of_product' => 'in:REWARD,NOT_REWARD',
            'price' => 'required',
            'merchant_id' => 'exists:merchants,id',
            'size' => 'required',
            'stock' => 'required',
        ]);

        try {
            if(empty($request->merchant_id)){
                $user = Auth::user()->load('merchant');
                $request->merge(['merchant_id' => $user->merchant['id']]);
            }
            $product = Product::create($request->all());
            $product->stock()->create($request->all());

            return response()->json($product, 201);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 500;
            $this->content['error'] = 'Internal Server Error';
            $this->content['message'] = 'Failed to create';
            return response()->json($this->content, 500);
        }
    }

    public function bulk(Request $request)
    {
        $validatedData = $request->validate([
            'products' => 'required|array',
        ]);

        try {
            foreach ($request->products as $key => $value) {
               $product = Product::create($value);
            }
            return response()->json($request->products, 201);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 500;
            $this->content['error'] = 'Internal Server Error';
            $this->content['message'] = 'Failed to create';
            return response()->json($this->content, 500);
        }
    }

    public function show(Request $request)
    {
        try {
            $product = Product::findOrFail($request->id);
            return response()->json($product, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 404;
            $this->content['error'] = 'Not Found';
            $this->content['message'] = 'Data Not Found';
            return response()->json($this->content, 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'string',
            'type' => 'string',
            'type_of_product' => 'in:REWARD,NOT_REWARD',
            'post_status' => 'in:ARCHIVE,POST',
            'price' => 'numeric',
            'merchant_id' => 'exists:merchants,id',
        ]);

        try {
            $product = Product::findOrFail($request->id);

            $product->update($request->all());


            return response()->json($product, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 404;
            $this->content['error'] = 'Not Found';
            $this->content['message'] = 'Data Not Found';
            return response()->json($this->content, 404);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($request->id);

            Product::destroy($id);

            return response()->json($product, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 404;
            $this->content['error'] = 'Not Found';
            $this->content['message'] = 'Data Not Found';
            return response()->json($this->content, 404);
        }
    }

    public function searchGenerator($request) {
        $per_page = $request->per_page ?  $request->per_page : 'all';
        $filter = $request->filter ? $request->filter : [];
        $sort = $request->sort ? $request->sort : 'created_at,ASC';
        $join = $request->join ? $request->join : '';
        $count = $request->count ? $request->count : '';
        $whereHas = $request->where_has ? $request->where_has : [];
        $limit = $request->limit ? $request->limit : '';
       
        $product = new Product;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $product = $product->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $product = $product->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $product = $product->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $product = $product->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $product = $product->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $product = $product->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $product = $product->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $product = $product->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $product = $product->paginate($per_page);
            }else{
                $product = $product->get();
            }
        }
        
        return $product;
    }
}