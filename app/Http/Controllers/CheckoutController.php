<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Cart;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Session;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login_check()
    {
        return view('pages.login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function customer_registration(Request $request)
    {
        $data=array();
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['password']=md5($request->password);
        $data['mobile_number']=$request->mobile_number;


            $customer_id=DB::table('tbl_customer')
                        ->insertGetId($data);

                Session::put('customer_id',$customer_id);
                Session::put('customer_name',$request->customer_name);
                //Session::put('customer_name',$data['customer_name']);
                return Redirect('/checkout');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        
        return view('pages.checkout');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function save_shipping_info(Request $request)
    {
        $data=array();
        $data['shipping_email']=$request->shipping_email;
        $data['shipping_firstname']=$request->shipping_firstname;
        $data['shipping_lastname']=$request->shipping_lastname;
        $data['shipping_address']=$request->shipping_address;
        $data['shipping_mobile']=$request->shipping_mobile;
        $data['shipping_city']=$request->shipping_city;


           $shipping_id=DB::table('tbl_shipping')
                    ->insertGetId($data);
                Session::put('shipping_id',$shipping_id);
                return Redirect::to('/payment');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_login(Request $request)
    {
        $customer_email=$request->customer_email;
        $password=md5($request->password);
        $result=DB::table('tbl_customer')
                    ->where('customer_email',$customer_email)
                    ->where('password',$password)
                    ->first();

                if ($result){

                    Session::put('customer_id',$result->customer_id);
                    return Redirect::to('/checkout');
                }else {
                    return Redirect::to('/login-check');
                }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function payment()
    {
        return view('pages.payment');
    }

    public function order_place(Request $request)
    {
        $payment_gateway=$request->payment_method;

        // payment data
        $payment_data=array();
        $payment_data['payment_method']=$payment_gateway;
        $payment_data['payment_status']='pending';
        $payment_id=DB::table('tbl_payment')
            ->insertGetId($payment_data);


            // order data

        $order_data=array();
        $order_data['customer_id']=Session::get('customer_id');
        $order_data['shipping_id']=Session::get('shipping_id');
        $order_data['payment_id']=$payment_id;
        $order_data['order_total']=Cart::total();
        $order_data['order_status']='pending';
        $order_id=DB::table('tbl_order')
                    ->insertGetId($order_data);

            // Order details here
            $contents=Cart::content();
            $order_details=array();

            foreach ($contents as $v_content) 
            {
                $order_details['order_id']=$order_id;
                $order_details['product_id']=$v_content->id;
                $order_details['product_name']=$v_content->name;
                $order_details['product_price']=$v_content->price;
                $order_details['product_sales_quantity']=$v_content->qty;


                $order_detials_id=DB::table('tbl_order_details')
                                ->insertGetId($order_details);   
            }

            if ($payment_gateway == 'handCash') {

                    Cart::destroy();
                    return view('pages.handCash');
                  
                    echo "Successfully Done by Hand Cash";
            }elseif ($payment_gateway == 'debitcard') {

                    echo "Debitcard";
            }elseif ($payment_gateway == 'paypal') {
                    echo "Paypal";
            }else {
                echo "No payment option Selected!!";
            }

    }


    public function manage_order()
    {
          // $this->AdminAuthCheck();
           $all_order_info=DB::table('tbl_order')
                ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
                ->select('tbl_order.*','tbl_customer.customer_name')
                ->get();

           $manage_order=view('admin.manage_order')
            ->with('all_order_info',$all_order_info);

            return view('admin_layout')
            ->with('admin.manage_order',$manage_order);
    }

    public function view_order($order_id)
    {
         $order_by_id=DB::table('tbl_order')
                ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
                ->join('tbl_order_details','tbl_order.order_id','=','tbl_order_details.order_id')
                ->join('tbl_shipping','tbl_order.shipping_id','=','tbl_shipping.shipping_id')
                ->select('tbl_order.*','tbl_order_details.*','tbl_shipping.*','tbl_customer.*')
                ->get();

           $view_order=view('admin.view_order')
            ->with('order_by_id',$order_by_id);

            return view('admin_layout')
            ->with('admin.view_order',$view_order);

                // echo "<pre>";
                // print_r($order_by_id);
                // echo "</pre>";
                // exit();
    }


     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer_logout()
    {
        Session::flush();
        return Redirect::to('/');
    }

    
}


// {{--// $all_published_category =DB::table('tbl_category')
//                     ->where('publication_status',1)
//                     ->get();

//         $manage_published_category=view('pages.checkout')
//             ->with('all_published_category',$all_published_category);
//             return view('layout')
//             ->with('pages.checkout',$manage_published_category); 
// --}}
