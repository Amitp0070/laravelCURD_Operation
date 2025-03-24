<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->get();
        return view('products.list', [
            'products' => $products
        ]);
    }
    public function view($id)
    {
        // 1. Product ko database se fetch karna
        $product = Product::with('category')->find($id);

        // 2. Agar product nahi mila toh 404 error show kare
        if (!$product) {
            abort(404, "Product not found");
        }

        // 3. Product ka data 'product.view' view file me bhejna
        return view('products.view', compact('product'));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name')->get();
        return view('products.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id', // Ensure category exists
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.create')->withInput()->withErrors($validator);
        }

        $product = new Product();
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category_id; // Save category ID
        $product->save();

        if ($request->image != "") {

            $image  = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            $image->move(public_path('uploads/products'), $imageName);

            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product Added Successfully');
    }
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->orderBy('category_name')->get();
        return view('products.edit', compact('product', 'categories'));
    }
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $rules = [
            'name' => 'required|min:5',
            'sku' => 'required|min:3',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,id',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withInput()->withErrors($validator);
        }

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category_id; // Category Assign
        $product->save();

        if ($request->image != "") {

            File::delete(public_path('uploads/products', $product->image));

            $image  = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = time() . '.' . $ext;

            $image->move(public_path('uploads/products'), $imageName);

            $product->image = $imageName;
            $product->save();
        }
        return redirect()->route('products.index')->with('success', 'Product Updated Successfully');
    }
    public function delete($id)
    {
        $product = Product::findOrfail($id);

        // delete image 
        File::delete(public_path('uploads/products/' . $product->image));

        // delete product from db
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product has been deleted successfully!');
    }
}
