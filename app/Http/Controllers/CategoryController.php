<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ClassCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::select('categories.id','categories.name', 'class_category_id', 'class_categories.name as category')
        ->join('class_categories', 'class_categories.id', '=', 'categories.class_category_id')
        ->orderBy('categories.created_at', 'desc')  // Ordenar por fecha de creación en orden descendente
        ->paginate(20)
        ->items();

        $class_categories=ClassCategory::all();

        return Inertia::render('Admin/Category/Index', ['categories' => $categories, 'class_categories'=>$class_categories]);
    }

    public function create()
    {
        // return Inertia::render('Category/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:150',
            'class_category_id'=>'required|numeric',
        ]);
        $category=new Category($request->input());

        $category->save();
        return redirect('admin/categories');
    }


    public function show(Category $category)
    {
        $categories = Category::with('products')->get();

        return response()->json($categories);
    }

    // public function edit(Category $category)
    // {
    //     return Inertia::render('Category/Edit', ['category' => $category]);
        
    // }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'=>'required|max:150',
            'class_category_id'=>'required|numeric',
        ]);
        $category->update($request->input());
        return redirect('admin/categories');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        
        return redirect('admin/categories');
    }
}
