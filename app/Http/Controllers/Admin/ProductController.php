<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Services\CommonBusinessService;
use App\Services\PhotoService;
use App\Services\ProductService;
use App\Traits\UploadPhotos;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use AuthorizesRequests, UploadPhotos;
    public function index(Request $request, ProductService $productService)
    {
        $products = $productService->getPaginatedItems($request->all());
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::pluck('title', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.products.create', compact('categories','suppliers'));
    }

    public function edit(Product $product)
    {
        $this->authorize('create', Product::class);
        $categories = Category::pluck('title', 'id');
        $suppliers = Supplier::pluck('name', 'id');
        return view('admin.products.edit', compact('product', 'categories','suppliers'));
    }

    public function store(ProductRequest $request)
    {;
        $this->authorize('create', Product::class);
        $data = $request->validated(); // Get validated data
        // Check if there's an image file and upload it
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadPhoto($request->file('image'));
        }
        Product::create($data);
        return redirect()->route('admin.products.create')->with(['success' => 'Successfully created!']);
    }


    public function show($id)
    {
        $product = Product::with('category:id,title','supplier:id,name')->find($id);
        return view('admin.products.show', compact('product'));
    }

    public function update(ProductRequest $request, $id)
    {
        $this->authorize('create', Product::class);
        $product = Product::findOrFail($id);
        $data = $request->validated(); 
        // Check if there's an image file and upload it
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadPhoto($request->file('image'), $product->image);
        }
        $product->update($data);
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully updated!']);
    }


    public function destroy($id)
    {
        $this->authorize('delete', Product::class);
        $product = Product::findOrFail($id);     
        $this->deleteImage($product->image);
        $product->delete();
        return redirect()->route('admin.products.index')->with(['success' => 'Successfully deleted!']);
    }

    public function bulkDelete(Request $request, CommonBusinessService $commonBusinessService)
    {
        $ids = $request->input('ids');
        $files = Product::whereIn('id',$ids)->pluck('image');
        foreach($files as $file){
            $this->deleteImage($file);
        }
        $response = $commonBusinessService->bulkDelete($ids, 'App\Models\Product');
        return redirect()->route('admin.products.index')->with($response);
    }
}
