<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Stock;

class StockController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $stock = $this->searchGenerator($request);
            return response()->json($stock, 200);
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
            'stock' => 'required',
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $stock = Stock::create($request->all());
            return response()->json($stock, 201);
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
            'stocks' => 'required|array',
        ]);

        try {
            foreach ($request->stocks as $key => $value) {
               $stock = Stock::create($value);
            }
            return response()->json($request->stocks, 201);
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
            $stock = Stock::findOrFail($request->id);
            return response()->json($stock, 200);
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
            'stock' => 'numeric',
            'product_id' => 'exists:products,id',
        ]);

        try {
            $stock = Stock::findOrFail($request->id);

            $stock->update($request->all());

            return response()->json($stock, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 404;
            $this->content['error'] = 'Not Found';
            $this->content['message'] = 'Data Not Found';
            return response()->json($this->content, 404);
        }
    }

    public function updateByProduct(Request $request, $id)
    {
        $validatedData = $request->validate([
            'stock' => 'numeric',
            'product_id' => 'exists:products,id',
        ]);

        try {
            $stock = Stock::where('product_id', $request->id)->first();

            $stock->update($request->all());

            return response()->json($stock, 200);
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
            $stock = Stock::findOrFail($request->id);

            Stock::destroy($id);

            return response()->json($stock, 200);
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
       
        $stock = new Stock;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $stock = $stock->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $stock = $stock->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $stock = $stock->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $stock = $stock->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $stock = $stock->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $stock = $stock->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $stock = $stock->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $stock = $stock->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $stock = $stock->paginate($per_page);
            }else{
                $stock = $stock->get();
            }
        }
        
        return $stock;
    }
}