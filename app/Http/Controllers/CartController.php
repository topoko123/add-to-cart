<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product, App\Models\User, App\Models\Cart;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


function check_has_product($user_id, $product_id) {
    $get_data_in_db = Cart::where('user_id', '=', $user_id)
    ->where('product_id', '=', $product_id)
    ->get();
    // $res_json = json_encode($get_data_in_db);

    if ($get_data_in_db == '[]') {
        return 'empty';
    }
    else {
        return 'already';
    }

}

function get_count_product($product_id) {
    $get_count = Product::select('quantity')
        ->where('product_id', '=', $product_id)
        ->first();
    return $get_count;
}

function get_count_product_cart($user_id, $product_id) {
    $get_count = Cart::select('quantity_product')
        ->where('user_id', '=', $user_id)
        ->where('product_id', '=', $product_id)
        ->first();
        
    return $get_count;
    // $key = 'quantity_product';
    // $decode_json = json_decode($res_json);
    // $response_result = array('msg'=> 'already', 'quantity_product'=> $decode_json[0]->$key);

}

function read_product_all_in_cart($user_id) {
    $get_data_in_db = DB::table('carts')
        ->join('users', 'carts.user_id', '=', 'users.user_id')
        ->join('products', 'carts.product_id', '=', 'products.product_id')
        ->where('carts.user_id', '=', $user_id)
        ->select('users.email', 'users.name', 'products.product_id', 'products.product_name',
                'products.price')
        ->get();

        return $get_data_in_db;
}

class CartController extends Controller
{
    public function read_product_all_in_cart(Request $request, $user_id) {
        return read_product_all_in_cart($user_id);
    }

    public function add_product_to_cart(Request $request, $product_id) {
        DB::beginTransaction();
        $get_quantity_from_products = check_has_product($request->user_id, $product_id);

        try {   
            if ($get_quantity_from_products == 'empty') {
                
                $data_save_to_db = array();
                $data_save_to_db['user_id'] = $request->user_id; 
                $data_save_to_db['product_id'] = $product_id;
                $data_save_to_db['quantity_product'] = $request->quantity_product;
                $data_save_to_db['price_product'] = $request->price_product;
                $data_save_to_db['created_at'] = Carbon::now('Asia/Bangkok');
    
                DB::table('carts')->insert($data_save_to_db);
                DB::commit();
                return response()
                                ->Json(['message'=>'Add Product to Cart!'])
                                ->setStatusCode(201)
                                ->header("Content-Type", "application/json");
            }
            else {
                                
                Cart::where('user_id', '=', $request->user_id)
                    ->where('product_id', '=', $product_id)
                    ->update(['quantity_product'=> $request->quantity_product,
                            'price_product'=>$request->price_product, 'updated_at'=>Carbon::now('Asia/Bangkok')]);
                DB::commit();
                                
                return response()
                                ->Json(['message'=>'update quantity product'])
                                ->setStatusCode(201)
                                ->header("Content-Type", "application/json");
            }
           
        }
        catch (\Exception $e) {
            DB::rollback();
            // return response()
            //                 ->Json(['message'=>'Failed'])
            //                 ->setStatusCode(400)
            //                 ->header('Content-Type', 'application/json');
            return $e;
        }
    }
}
