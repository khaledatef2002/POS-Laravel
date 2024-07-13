<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CategoryController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:create-category', only: ['create', 'store']),
            new Middleware('permission:read-category', only: ['index']),
            new Middleware('permission:edit-category', only: ['edit', 'update']),
            new Middleware('permission:remove-category', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $categories = Category::when($req->search, function ($q) use ($req){
            return $q->whereTranslationLike('name', "%{$req->search}%");
        })->paginate(10);

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
            $rules[$locale . '.name'] = 'required|unique:category_translations,name';
        }

        $request->validate($rules);

        Category::create($request->all());

        return to_route('dashboard.categories.index')->with('success', __('site.record.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
            $rules[$locale . '.name'] = 'required|unique:category_translations,name,' . $category->id . ",category_id";
        }

        $request->validate($rules);

        $category->update($request->all());

        return back()->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', __('site.record.deleted'));
    }
}
