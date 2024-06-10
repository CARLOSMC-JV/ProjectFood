<?php

namespace App\Http\Controllers;

use App\Models\ClassCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClassCategoryController extends Controller
{
    public function index()
    {
        $class_categories = ClassCategory::all();
        return Inertia::render('Admin/ClassCategory/Index', ['class_categories' => $class_categories]);
    }

    public function create()
    {
        return Inertia::render('Admin/ClassCategory/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|max:100']);
        $class_category = new ClassCategory($request->input());
        $class_category->save();
        return redirect('admin/class_categories');
    }

    // public function show(ClassCategory $class_category)
    // {
    //     $class_categories = ClassCategory::with('products')->get();

    //     return response()->json($class_categories);
    // }

    public function edit(ClassCategory $class_category)
    {
        return Inertia::render('Admin/ClassCategory/Edit', ['class_category' => $class_category]);
        
    }

    public function update(Request $request, ClassCategory $class_category)
    {
        $request->validate(['name' => 'required|max:100']);
        $class_category->update($request->all());
        return redirect('admin/class_categories');
    }

    public function destroy(ClassCategory $class_category)
    {
        $class_category->delete();
        return redirect('admin/class_categories');
    }
    public function showCategoryInClassCategory(Request $request, $class_category)
    {
        // Busca la instancia del modelo ClassCategory por el nombre
        $classCategory = ClassCategory::where('id', $class_category)->firstOrFail();

        // Obtén las categorías asociadas a la clase seleccionada
        $categories = $classCategory->categories;

        return Inertia::render('ListCategory/Index', ['categories' => $categories, 'classCategoryName' => $classCategory->name,]);
    }
}
