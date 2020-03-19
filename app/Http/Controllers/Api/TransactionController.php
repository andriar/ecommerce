<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\RewardPoint;
use App\Models\Stock;
use Auth;

class TransactionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        try {
            $transaction = $this->searchGenerator($request);
            return response()->json($transaction, 200);
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
            'code' => 'required|unique:transactions,code',
            'status' => 'required|in:GET_PAID,WAITING_FOR_PAYMENT',
            'code' => 'required',
            'transactions' => 'required|array',
            'transactions.*.amount' => 'required|numeric',
            'transactions.*.product_id' => 'required|exists:products,id',
        ]);
            
        try {
            $transactions = array();
            $reward = 20;
            $user = Auth::user()->load('rewardpoint');
            $request->merge(['buyer_id' => $user->id]);
            $request->merge(['meta_buyer' => $user]);

            $rewardPoint = RewardPoint::where('user_id', $request->buyer_id)->first();
            $totalReward = 0;

            foreach ($request->transactions as $key => $value) {
                $product = Product::where('id',$value['product_id'])->with(['stock', 'merchant'])->first();

                if($product['type_of_product'] == 'REWARD'){
                    $totalReward += ($product['price'] * $value['amount']);
                }

                $value['meta_product'] = $product;
                $value['merchant_id'] = $product['merchant_id'];
                $value['meta_merchant'] = $product['merchant'];
                array_push($transactions, $value);

                if($product['stock']->stock < $value['amount']){
                    $this->content['message'] = 'Out of Stocks';
                    return response()->json($this->content, 400);
                }
            }
            
            if($totalReward > $user->rewardpoint['points']){
                $this->content['message'] = 'not enough point';
                return response()->json($this->content, 400);
            }

            $transaction = Transaction::create($request->all());
            $transaction->transactionDetails()->createMany($transactions);

            foreach ($request->transactions as $key => $value) {
                $product = Product::where('id',$value['product_id'])->with(['stock'])->first();
                $product->stock()->update([
                    'stock' => $product['stock']->stock - $value['amount']
                ]);
            }

           if($totalReward <= 0){
                $rewardPoint->update([
                    'points' => $rewardPoint['points'] + $reward
                ]);
           }else{
                $rewardPoint->update([
                    'points' => $rewardPoint['points'] - $totalReward
                ]);
           }


            return response()->json($transaction, 201);
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
            'transactions' => 'required|array',
        ]);

        try {
            foreach ($request->transactions as $key => $value) {
               $transaction = Transaction::create($value);
            }
            return response()->json($request->transactions, 201);
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
            $transaction = Transaction::findOrFail($request->id);
            return response()->json($transaction, 200);
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
            $transaction = Transaction::findOrFail($request->id);

            $transaction->update($request->all());

            return response()->json($transaction, 200);
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
            $transaction = Transaction::findOrFail($request->id);

            Transaction::destroy($id);

            return response()->json($transaction, 200);
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
       
        $transaction = new Transaction;

        if(is_array($whereHas)){
            foreach ($whereHas as $item => $value) {
                $words = explode(",",$value);
                     $transaction = $transaction->whereHas($words[0], function ($query) use ($words) {
                        $query->where($words[1], $words[2]);
                    });
            }
        }

        if($join !== ''){
            $join = Str::lower($join);
            $words = explode(",",$join);
            $transaction = $transaction->with($words);
        }

        if($count !== ''){
            $count = Str::lower($count);
            $words = explode(",",$count);
            $transaction = $transaction->withCount($words);
        }

        if(is_array($filter)){
            foreach ($filter as $item => $value) {
                $words = explode(",",$value);
                if(array_key_exists(2, $words)){
                    if($words[2] || $words[2] == 'AND'){
                        $transaction = $transaction->orWhere($words[0], 'LIKE', '%'.$words[1].'%');
                    }else{
                        $transaction = $transaction->where($words[0], 'LIKE', '%'.$words[1].'%');
                    }
                }else{
                    $transaction = $transaction->where($words[0], 'LIKE', '%'.$words[1].'%');
                }
            }
        }

        $sortItem = explode(",",$sort);
        if(strtoupper($sortItem[1]) == 'ASC' || strtoupper($sortItem[1]) == 'DESC'){
            $transaction = $transaction->orderBy($sortItem[0], $sortItem[1]);
        }

        if($limit != ''){
            $transaction = $transaction->limit($limit)->get();
        }else{
            if($per_page !== 'all'){
                $transaction = $transaction->paginate($per_page);
            }else{
                $transaction = $transaction->get();
            }
        }
        
        return $transaction;
    }

     public function merchantTransaction(Request $request){
        try {
            $user = Auth::user()->load('merchant');
            $idMerchant = $user->merchant['id'];
            $transaction = Transaction::with(['transactionDetails'])->whereHas('transactionDetails', function ($query) use ($idMerchant) {
                $query->where('merchant_id', '=', $idMerchant);
            })->get();
            return response()->json($transaction, 200);
        } catch (\Throwable $th) {
            $this->content['statusCode'] = 500;
            $this->content['error'] = 'Internal Server Error';
            $this->content['message'] = 'something went wrong';
            return response()->json($this->content, 500);
        }
     }
}