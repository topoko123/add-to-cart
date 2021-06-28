<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

use Illuminate\Http\Request;

use App\Models\Product;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function get_all_product(Request $request) {
        $get_data_in_db = Product::all();
        return $get_data_in_db;
    }

    public function addProduct(Request $request) {
        DB::beginTransaction();
        
        try {
            $random_id = Str::uuid()->toString();
            $data_save_to_db = array();
            
            $data_save_to_db['product_id']   = strtr($random_id, '-', $random_id);
            $data_save_to_db['product_name'] = $request->product_name;
            $data_save_to_db['price']        = $request->price;
            $data_save_to_db['quantity']     = $request->quantity;
            $data_save_to_db['created_at']   = Carbon::now('Asia/Bangkok');
            
            DB::table('products')->insert($data_save_to_db);
            DB::commit();
            return response()
                            ->Json(['message'=>'success'])
                            ->setStatusCode(201)
                            ->header("Content-Type", "application/json");
        }
        catch (\Exception $e) {
            DB::rollBack();
            return response()
                            ->json(['message'=>'failed'])
                            ->setStatusCode(400)
                            ->header("Content-Type", "application/json");
        }
    }

    public function removeProduct(Request $request, $product_id) {
        // DB::beginTransaction();
        // return Product::withTrashed()->get();
        // Product::onlyTrashed()->find(33)->forceDelete();
        // return Product::onlyTrashed()->where('deleted_at', '<', carbon::now('Asia/Bangkok'))->forceDelete();

        try {
            
            $delete_product_in_db = Product::where('product_id', $product_id)->first();
            if ($delete_product_in_db) {
                $delete_product_in_db->delete();

                return response()
                            ->Json(['message'=>'delete success'])
                            ->setStatusCode(200)
                            ->header("Content-Type", "application/json");
            }
            else {
                return response()
                            ->Json(['message'=>'Not Found Product ID'])
                            ->setStatusCode(200)
                            ->header("Content-Type", "application/json");
            }   
        }
        catch (\Exception $e) {
            return $e;
        }
    }
}
