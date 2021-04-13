<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Models used in this Controller
 */
use App\Models\Product;

/**
 * Request used in this controller
 */
use App\Http\Requests\ProductRequest;

/**
 * Class used in this controller
 */
use Str,Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $category = Str::lower($request->query('category'));    
            
        $products = Product::where('category','like',"%{$category}%")
        ->where(function($query) use ($search){
                $query->where('name','like',"%{$search}%")
                      ->orWhere('description','like',"%{$search}%");
        })
        ->paginate(5);

        return response()->json([
            "status" => true,
            "products" => $products,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try
        {
        $product = new Product;
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->category = $request->get('category');
        $product->images = $request->images;
        $product->date_time = $request->get('dateTime');
        $product->save();
        
        return response()->json([
            'status' => true,
            'product' => $product,
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                "error_message" => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        if($product){
            return response()->json([
                "status" => true,
                "product" => $product,
            ],200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "No product found",
            ],200);
        }
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
        $product = Product::find($id);
        if($product){
            $product->name = $request->get('name');
            $product->description = $request->get('description');
            $product->category = Str::lower($request->get('category'));
            $product->save();

            return response()->json([
                "status" => true,
                "product" => $product,
            ],200);
        }

        return response()->json([
            "status" => true,
            "message" => "No product found",
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if($product){
            $product->delete();
            return response()->json([
                "status" => true,
                "message" => "successfully deleted",
            ]);
        }
        
        return response()->json([
            "status" => true,
            "message" => "No Product found",
        ]);
    }

    /**
     * Uploading Image
     * 
     * @return response json
     */
    public function image_upload(Request $request)
    {
        $image = $request->file;
        $filename = time().'.'.$image->getClientOriginalExtension();
        $path = public_path('images/uploads');
        Image::make($image)->save($path.'/'.$filename);
    
        return response()->json([
            "name" => $filename,
        ]);
    }
}
