<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Merchant;
use Auth;

class MerchantController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $merchant = $this->searchGenerator($request);
            return response()->json($merchant, 200);
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
            'name' => 'required|string',
            'address' => 'required|string',
            'user_id' => 'exists:users,id',
        ]);

        try {
            if(empty($request->user_id)){
                $user = Auth::user()->load('rewardpoint');
                $request->merge(['user_id' => $user->id]);
            }
            $merchant = Merchant::create($request->all());
            return response()->json($merchant, 201);
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
            'merchants' => 'required|array',
        ]);

        try {
            foreach ($request->merchants as $key => $value) {
               $merchant = Merchant::create($value);
            }
            return response()->json($request->merchants, 201);
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
            $merchant = Merchant::findOrFail($request->id);
            return response()->json($merchant, 200);
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
            $merchant = Merchant::findOrFail($request->id);

            $merchant->update($request->all());

            return response()->json($merchant, 200);
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
            $merchant = Merchant::findOrFail($request->id);

            Merchant::destroy($id);

            return response()->json($merchant, 200);
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
       
        $merchant = new Merchant;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $merchant = $merchant->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $merchant = $merchant->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $merchant = $merchant->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $merchant = $merchant->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $merchant = $merchant->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $merchant = $merchant->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $merchant = $merchant->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $merchant = $merchant->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $merchant = $merchant->paginate($per_page);
            }else{
                $merchant = $merchant->get();
            }
        }
        
        return $merchant;
    }
}