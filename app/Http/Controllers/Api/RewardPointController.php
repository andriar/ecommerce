<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\RewardPoint;

class RewardPointController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $rewardpoint = $this->searchGenerator($request);
            return response()->json($rewardpoint, 200);
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
            'user_id' => 'required',
            'points' => 'required',
        ]);

        try {
            $rewardpoint = RewardPoint::create($request->all());
            return response()->json($rewardpoint, 201);
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
            'rewardpoints' => 'required|array',
        ]);

        try {
            foreach ($request->rewardpoints as $key => $value) {
               $rewardpoint = RewardPoint::create($value);
            }
            return response()->json($request->rewardpoints, 201);
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
            $rewardpoint = RewardPoint::findOrFail($request->id);
            return response()->json($rewardpoint, 200);
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
            $rewardpoint = RewardPoint::findOrFail($request->id);

            $rewardpoint->update($request->all());

            return response()->json($rewardpoint, 200);
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
            $rewardpoint = RewardPoint::findOrFail($request->id);

            RewardPoint::destroy($id);

            return response()->json($rewardpoint, 200);
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
       
        $rewardpoint = new RewardPoint;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $rewardpoint = $rewardpoint->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $rewardpoint = $rewardpoint->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $rewardpoint = $rewardpoint->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $rewardpoint = $rewardpoint->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $rewardpoint = $rewardpoint->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $rewardpoint = $rewardpoint->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $rewardpoint = $rewardpoint->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $rewardpoint = $rewardpoint->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $rewardpoint = $rewardpoint->paginate($per_page);
            }else{
                $rewardpoint = $rewardpoint->get();
            }
        }
        
        return $rewardpoint;
    }
}