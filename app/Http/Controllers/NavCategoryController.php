<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClassCategory;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NavCategoryController extends Controller
{
    public function index()
    {
        // $categories = ClassCategory::with('categories')->get();
        // $classCategories = ClassCategory::with('categories.subcategories')->get();
        $classCategories = ClassCategory::all();

        return response()->json(['classCategories' => $classCategories]);
    }
}
