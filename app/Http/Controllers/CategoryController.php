<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Fetch all active categories
    public function getCategories()
    {
        $categories = Category::where('is_active', 1)->orderBy('category_name')->get();

        return response()->json($categories);
    }
}
