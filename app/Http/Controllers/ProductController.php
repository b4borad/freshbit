<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productAry=Product::get()->toArray();
        return view('product.index')->with(compact('productAry'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'bail|required',
            'price' => 'bail|required|numeric',
            'upc' => 'bail|required|numeric',
            'status' => 'bail|required',
            'image'=>'bail|required|mimes:jpg,png',
        ]);
        
         /*$request->validate([
            'name'=>'bail|required',
            'price'=>'bail|required',
            'upc'=>'bail|required',
            'status'=>'bail|required',
            'image'=>'bail|required|mimes:jpg,png',
        ]);*/
       // Product::create($request->all());
        $reqdata = new Product;
        $reqdata->name = $request->name;
        $reqdata->price = $request->price;
        $reqdata->upc = $request->upc;
        $reqdata->status = $request->status;
        $reqdata->image = '';
        
        
        if($request->image)
        {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $reqdata->image = $imageName;
        }
       
        $reqdata->save();
        return redirect()->route('products.index')->with('success','Product created successfully.');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productAry=Product::where("id",$id)->get()->first();
        return view('product.edit')->with(compact('productAry'));
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
        $request->validate([
            'name' => 'bail|required',
            'price' => 'bail|required|numeric',
            'upc' => 'bail|required|numeric',
            'status' => 'bail|required',
           
        ]);
        
        
        $reqdata = new Product;
        $reqdata->name = $request->name;
        $reqdata->price = $request->price;
        $reqdata->upc = $request->upc;
        $reqdata->status = $request->status;
        
        $imageName=$request->old_image;
        if($request->image!="")
        {
            if($request->old_image!=""){
                file_exists(public_path().'/images/'.$request->old_image);
                {
                    unlink("images/".$request->old_image);
                    $imageName = "";
                }
                
            }
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images'), $imageName);
            $imageName = $imageName;
        }
        product::where("id", $id)->update(["name" => $request->name,"price" => $request->price,"upc" => $request->upc,"status" => $request->status,"image" => $imageName]);
        return redirect()->route('products.index')->with('success','Product updated successfully.');
       // $reqdata->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        product::where('id', $id)->delete();
        return redirect()->route('products.index')->with('success','Product deleted successfully.'); 
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->ids;
        product::whereIn('id',explode(",",$ids))->delete();
        return 1;
    }
}
