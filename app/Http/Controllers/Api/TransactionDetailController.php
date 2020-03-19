<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\TransactionDetail;

class TransactionDetailController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $transactiondetail = $this->searchGenerator($request);
            return response()->json($transactiondetail, 200);
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
        ]);

        try {
            $transactiondetail = TransactionDetail::create($request->all());
            return response()->json($transactiondetail, 201);
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
            'transactiondetails' => 'required|array',
        ]);

        try {
            foreach ($request->transactiondetails as $key => $value) {
               $transactiondetail = TransactionDetail::create($value);
            }
            return response()->json($request->transactiondetails, 201);
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
            $transactiondetail = TransactionDetail::findOrFail($request->id);
            return response()->json($transactiondetail, 200);
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
            'name' => 'required',
        ]);

        try {
            $transactiondetail = TransactionDetail::findOrFail($request->id);

            $transactiondetail->update($request->all());

            return response()->json($transactiondetail, 200);
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
            $transactiondetail = TransactionDetail::findOrFail($request->id);

            TransactionDetail::destroy($id);

            return response()->json($transactiondetail, 200);
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
       
        $transactiondetail = new TransactionDetail;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $transactiondetail = $transactiondetail->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $transactiondetail = $transactiondetail->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $transactiondetail = $transactiondetail->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $transactiondetail = $transactiondetail->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $transactiondetail = $transactiondetail->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $transactiondetail = $transactiondetail->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $transactiondetail = $transactiondetail->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $transactiondetail = $transactiondetail->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $transactiondetail = $transactiondetail->paginate($per_page);
            }else{
                $transactiondetail = $transactiondetail->get();
            }
        }
        
        return $transactiondetail;
    }
}