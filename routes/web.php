<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Http\Controllers\Admin\DashboardController;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $categories = Category::where('status','0')->get();
    $brands = Brand::where('status','0')->get();
    $trendingProducts = Product::where('trending','1')->get();
    return view('frontend.collections.category.index', compact('categories', 'trendingProducts'));
});

Route::get('contact-us', [ContactController::class, 'index']);
Route::post('contact-us', [ContactController::class, 'store'])->name('contact.us.store');


Route::get('/collections/{category_slug}', function ($category_slug) {
    $category = \App\Models\Category::where('slug', $category_slug)->first();
    if ($category) {
        $categories =  Category::where('status', '0')->get();
        return view('frontend.collections.products.index', compact('category', 'categories'));
    } else {
        return redirect()->back();
    }
});

Route::get('/collections/{category_slug}/{product_slug}', function(string $category_slug, string $product_slug) {
    {
        $category = Category::where('slug', $category_slug)->first();
        $categories = Category::where('status','0')->get();

        if($category) {
            $product = $category->products()->where('slug', $product_slug)->where('status','0')->first();
            if($product) {
                return view('frontend.collections.products.view', compact('product','category','categories'));
            }
            else{
                return redirect()->back();
            }
        }

        else{
            return redirect()->back();
        }
    }
});

Route::get('/collections/{brand_slug}', function ($brand_slug) {
    $brand = \App\Models\Brand::where('slug', $brand_slug)->first();
    if ($brand) {
        $brands =  Brand::where('status', '0')->get();
        return view('frontend.collections.brand.index', compact('brand', 'brands'));
    } else {
        return redirect()->back();
    }
});

Auth::routes();

Route::controller(App\Http\Controllers\FrontEndController::class)->group(function () {

    Route::get('serach', 'searchProducts');
    Route::get('/collections', 'categories');
    Route::get('/collections/{category_slug}', 'products');
    Route::get('/collections/{category_slug}/{product_slug}', 'productView');
    Route::get('search', 'searchProducts');
    
});
// Auth::routes();
Route::prefix('admin')->middleware(['auth','isAdmin'])->group (function () {

    Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::controller(App\Http\Controllers\Admin\SliderController::class)->group(function () {
        Route::get('sliders', 'index');
        Route::get('sliders/create', 'create');
        Route::post('sliders/create', 'store');
        Route::get('sliders/{slider}/edit', 'edit');
        Route::put('sliders/{slider}', 'update');
        Route::get('sliders/{slider}/delete', 'destroy');
    });

    Route::controller(App\Http\Controllers\Admin\AdminController::class)->group(function () {
        Route::get('/admins', 'index');
        Route::get('/admins/create', 'create');
        Route::post('/admins', 'store');
        Route::get('/admins/{admin}/edit', 'edit');
        Route::put('/admins/{admin}', 'update');
        Route::get('/admins/{admin}/delete', 'destroy');
    });
    

    
    //Category Routes
    Route::controller(App\Http\Controllers\Admin\CategoryController::class)->group(function () {
        Route::get('/category', 'index');
        Route::get('/category/create', 'create');
        Route::post('/category', 'store');
        Route::get('/category/{category}/edit', 'edit');
        Route::put('/category/{category}', 'update');
    });

    Route::controller(App\Http\Controllers\Admin\ProductController::class)->group(function () {
        Route::get('/products', 'index');
        Route::get('/products/create', 'create');
        Route::post('/products', 'store');
        Route::get('/products/{product}/edit', 'edit');
        Route::put('/products/{product}', 'update');
        Route::get('products/{product_id}/delete', 'destroy');
        Route::get('product-image/{product_image_id}/delete','destroyImage');
    });

    Route::get('/brands', App\Http\Livewire\Admin\Brand\Index::class);
    
});

    

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');