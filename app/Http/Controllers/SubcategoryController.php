<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::select('subcategories.id','subcategories.name', 'category_id', 'categories.name as category')
        ->join('categories', 'categories.id', '=', 'subcategories.category_id')
        ->orderBy('subcategories.created_at', 'desc')  // Ordenar por fecha de creación en orden descendente
        ->paginate(10)
        ->items();

        $categories=Category::all();

        return Inertia::render('Admin/Subcategory/Index', ['subcategories' => $subcategories, 'categories'=>$categories]);
        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|max:150',
            'category_id'=>'required|numeric',
        ]);
        $category=new Subcategory($request->input());
        $category->save();
        return redirect('admin/subcategories');
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'name'=>'required|max:150',
            'category_id'=>'required|numeric',
        ]);
        $subcategory->update($request->input());
        return redirect('admin/subcategories');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        
        return redirect('admin/subcategories');
    }

}
