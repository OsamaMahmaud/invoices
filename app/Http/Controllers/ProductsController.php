<?php

namespace App\Http\Controllers;

use App\products;
use App\sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('permission:اضافة منتج', ['only' => ['store']]);
        $this->middleware('permission:تعديل منتج', ['only' => ['update']]);
        $this->middleware('permission:حذف منتج',['only' => ['destroy']]);
    }
    public function index()
    {
            $products = products::all();
            $sections=sections::all();
        //   $products->section->section_name;

        return view('products.product',compact('products','sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //  $products= $request->all();

        $rules=[
            'product_name' =>'required|max:100|unique:products,product_name',
            'description'=>'required',
           ];

        $message=[
            'product_name.required' =>'* product_name  required',
            'description.required' =>'* description  required',

        ];

         $validator= Validator::make($request->all(),$rules, $message);

        if($validator->fails())//فشل
        {
            return redirect()->route('products.store')->withErrors($validator)->withInputs($request->all());
        }

            else
            {
                products::create([
                        'product_name'=>$request->product_name,
                        'description'=>$request->description,
                        'section_id'=>$request->section_name,
                ]);
                return redirect('/products')->with(['success'=>'تم اضافة المنتج بنجاح']);
            }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    //    return $sec_id=sections::where('section_name',$request->section_name)->get('id');
        $sec_id=sections::where('section_name',$request->section_name)->first()->id;

         $product=products::find($request->id);

        $product->update([
                        'product_name'=>$request->product_name,
                        'description'=>$request->description,
                        'section_id'=>$sec_id,
        ]);

        return redirect('/products')->with(['success'=>'تم تعديل المنتج بنجاح']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pro_id=products::find($request->id);

        $pro_id->delete();
        return redirect('/products')->with(['success'=>'تم الحذف المنتج بنجاح']);

    }
}
