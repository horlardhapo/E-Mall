<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cart;
session_start();

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add_to_cart(Request $request)
    {
        $qty=$request->qty; 
        $product_id=$request->product_id;
        $product_info=DB::table('tbl_products')
                    ->where('product_id',$product_id)
                    ->first();

                    $data['qty']=$qty;
                    $data['id']=$product_info->product_id;
                    $data['name']=$product_info->product_name;
                    $data['price']=$product_info->product_price;
                    $data['options']['image']=$product_info->product_image;


                    Cart::add($data);
                    return Redirect::to('/show-cart');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    // show cart items
    public function show_cart()
    {
        
        $all_published_category=DB::table('tbl_category')
                        ->where('publication_status',1)
                        ->get();

          $manage_published_category=view('pages.add_to_cart')
            ->with('all_published_category',$all_published_category);
            return view('layout')
            ->with('pages.add_to_cart',$manage_published_category);
    }

    /**
     * code to delete things in my shoppingcart.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete_to_cart($rowId)
    {
        Cart::update($rowId,0);
         return Redirect::to('/show-cart');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_cart(Request $request)
    {
        $qty=$request->qty;
        $rowId=$request->rowId;

        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
