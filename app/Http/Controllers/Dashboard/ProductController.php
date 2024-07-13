<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:create-product', only: ['create', 'store']),
            new Middleware('permission:read-product', only: ['index']),
            new Middleware('permission:edit-product', only: ['edit', 'update']),
            new Middleware('permission:remove-product', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        $products = Product::when($req->search, function ($q) use ($req) {
            return $q->whereTranslationLike('title', "%{$req->search}%");
        })->when($req->category_search, function ($q) use ($req) {
            return $q->where('category_id', $req->category_search);
        })->paginate(10);

        $categories = Category::all();
        return view('dashboard.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('dashboard.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
            $rules[$locale . '.title'] = 'required|unique:product_translations,title';
            $rules[$locale . '.description'] = 'required|unique:product_translations,description';
        }

        $rules['image'] = 'required|mimes:jpeg,png,jpg,gif,svg';
        $rules['category_id'] = 'required|exists:categories,id';
        $rules['purchase_price'] = 'required|numeric';
        $rules['sell_price'] = 'required|numeric';
        $rules['stock'] = 'required|numeric';

        $request->validate($rules);

        $saved_path = 'uploads/product_images/' . $request->image->hashName();
        $manager = new ImageManager(new Driver());
        $image = $manager->read($request->image);
        $image->scale(300)
        ->save(public_path($saved_path));

        $data = $request->except('image');

        $data['image'] = $saved_path;

        Product::create($data);

        return to_route('dashboard.products.index')->with('success', __('site.record.added'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale)
        {
            $rules[$locale . '.title'] = 'required|unique:product_translations,title,' . $product->id . ",product_id";
            $rules[$locale . '.description'] = 'required|unique:product_translations,description,' . $product->id . ",product_id";
        }

        $rules['category_id'] = 'required|exists:categories,id';
        $rules['purchase_price'] = 'required|numeric';
        $rules['sell_price'] = 'required|numeric';
        $rules['stock'] = 'required|numeric';

        $request->validate($rules);

        $data = $request->except(['image']);
        if($request->image)
        {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg'
            ]);

            $saved_path = 'uploads/product_images/' . $request->image->hashName();

            $manager = new ImageManager(new Driver());
            $image = $manager->read($request->image);
            $image->scale(300)
            ->save(public_path($saved_path));

            $data['image'] = $saved_path;

            $old_image = substr($product->image, 7);
            Storage::disk('public_uploads')->delete($old_image);
        }

        $product->update($data);

        return back()->with('success', __('site.record.updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->image != 'assets/dashboard/images/foods/default.avif')
        {
            $image = substr($product->image, 7);
            Storage::disk('public_uploads')->delete($image);
        }

        $product->delete();
 
        return back()->with('success', __('site.record.deleted'));
    }
}
