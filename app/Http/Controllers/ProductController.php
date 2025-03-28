<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('created_at', 'DESC')->paginate(5);
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
            'state' => 'required|boolean', // ✅ Ensure only 1 or 0 is allowed
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
        $product->state = $request->state; // ✅ Save status
        $product->user_id = Auth::id(); // Store Logged-in User ID
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

        // Check if the logged-in user is the creator of the product
        if (Auth::user()->id !== $product->user_id) {
            return redirect()->route('products.index')->with('error', 'You are not authorized to edit this product.');
        }

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
            'state' => 'required|in:1,0',
        ];

        if ($request->image != "") {
            $rules['image'] = 'image';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            dd($request->all());
            return redirect()->route('products.edit', $product->id)->withInput()->withErrors($validator);
        }

        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->category_id = $request->category_id; // Category Assign
        $product->state = $request->state; // ✅ Update status
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
        $product = Product::findOrFail($id);

        // Authorization Check: Sirf product ka creator delete kar sakta hai
        if (Auth::id() !== $product->user_id) {
            return redirect()->route('products.index')->with('error', 'You are not authorized to delete this product.');
        }

        // Delete Image if Exists
        if ($product->image && File::exists(public_path('uploads/products/' . $product->image))) {
            File::delete(public_path('uploads/products/' . $product->image));
        }

        // Delete Product
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product has been deleted successfully!');
    }
}
