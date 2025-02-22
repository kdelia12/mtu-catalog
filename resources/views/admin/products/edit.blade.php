@extends('layouts.admin')

@section('content')


<div class="content-header">
    <!-- Main content -->
    <section class="content">
       <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(session('message'))
                        <h5 class="alert alert-success mb-2">{{session('message')}}</h5>
                    @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Edit Products</h3>
            
                            <div class="card-tools">
                              <a href="{{ url('admin/products/') }}" class="btn btn-primary btn-sm">Back</a>
                            </div>
                          </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-warning">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ url('admin/products/'.$product->id.'') }}" method="POST" enctype="multipart/form-data">  
                                @csrf
                                @method('PUT')
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                            Home
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="details-tab" data-bs-toggle="tab" data-bs-target="#details-tab-pane" type="button" role="tab" aria-controls="details-tab-pane" aria-selected="false">
                                            Details
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="image-tab" data-bs-toggle="tab" data-bs-target="#image-tab-pane" type="button" role="tab" aria-controls="image-tab-pane" aria-selected="false">
                                            Product Image
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade border p-3 show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label>Category</label>
                                            <select name="category_id" class="form-control">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{$category->id == $product->category_id ? 'selected':''}}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Product Name</label>
                                            <input type="text" name="name" value="{{$product->name }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Product Slug</label>
                                            <input type="text" name="slug" value="{{$product->slug }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label>Select Brand</label>
                                            <select name="brand" class="form-control">
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->name }}" {{$brand->name == $product->brand ? 'selected':''}}>
                                                        {{ $brand->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label>Small Description (500 Words)</label>
                                            <textarea name="small_description" class="form-control" rows="4">{{$product->small_description}}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label>Description</label>
                                            <textarea name="description" class="form-control" rows="4">{{$product->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade border p-3" id="details-tab-pane" role="tabpanel" aria-labelledby="details-tab" tabindex="0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label>Original Price</label>
                                                    <input type="text" name="original_price"  value="{{$product->original_price}}"class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label>Selling Price</label>
                                                    <input type="text" name="selling_price"  value="{{$product->selling_price}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label>Quantity</label>
                                                    <input type="number" name="quantity" value="{{$product->quantity}}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label>Trending</label>
                                                    <input type="checkbox" name="trending" {{$product->trending == '1' ? 'checked':''}} style="width: 25px; height: 25px;">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label>Hide</label>
                                                    <input type="checkbox" name="status"  {{$product->status == '1' ? 'checked':''}}style="width: 25px; height: 25px;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="tab-pane fade border p-3" id="image-tab-pane" role="tabpanel" aria-labelledby="image-tab" tabindex="0">
                                        <div class="mb-3">
                                            <label> Upload Product Image</label>
                                            <input type="file" name="image[]" multiple class="form-control">
                                        </div>    
                                        <div>
                                            @if($product->productImages)
                                            <div class="row">
                                                @foreach($product->productImages as $image)
                                                <div class="col-md-2">
                                                    <img src="{{ asset($image->image)}}" style="width: 80px; height: 80px;" 
                                                        class= "me-4 border" alt="Img" />
                                                    <a href="{{url('admin/product-image/'.$image->id.'/delete')}}" class="d-block">Remove</a> 
                                                </div>
                                                @endforeach
                                            </div>
                                            @else
                                            <h5> No Image Added</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="col-md-12 mb-3">
                                        <button type="submit" class="btn btn-primary float-right my-2">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>

@endsection