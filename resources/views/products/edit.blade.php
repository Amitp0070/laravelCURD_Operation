<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CURD </h3>
    </div>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{route('products.index')}}" class="btn btn-lg btn-dark">Back </a>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card border-0 shadow-lg my-3">
                    <div class="card-header text-white bg-dark">
                        <h3>Edit Product</h3>
                    </div>
                    <form enctype="multipart/form-data" action="{{ route('products.update',$product->id) }}" method="post">
                        @method('put')
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="" class="form-label h5">Name</label>
                                <input value="{{old('name',$product->name)}}" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name">
                                @error('name')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Sku</label>
                                <input value="{{old('sku',$product->sku)}}" type="text" class="form-control @error('sku') is-invalid @enderror" placeholder="Sku" name="sku">
                                @error('sku')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Price</label>
                                <input value="{{old('price',$product->price)}}" type="text" class="form-control @error('price') is-invalid @enderror" placeholder="Price" name="price">
                                @error('price')
                                <span class="invalid-feedback">{{$message}}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label h5">Category</label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- ✅ New: Product Status as Radio Buttons -->
                            <div class="mb-3">
                                <label class="form-label h5">Product Status</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="state" value="1" id="active"
                                            {{ $product->state == 1 ? 'checked' : '' }} style="accent-color: green; cursor: pointer;">
                                        <label class="form-check-label fw-bold text-success" for="active" style="cursor: pointer;">Active</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="state" value="0" id="inactive"
                                            {{ $product->state == 0 ? 'checked' : '' }} style="accent-color: red; cursor: pointer;">
                                        <label class="form-check-label fw-bold text-danger" for="inactive" style="cursor: pointer;">Inactive</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Description</label>
                                <textarea placeholder="Description" class="form-control" name="description" cols="30" rows="5">{{old('price',$product->description)}}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="" class="form-label h5">Image</label>
                                <input type="file" class="form-control" name="image" id="">
                                @if($product->image != "")
                                <img class="w-50 my-2" src="{{asset('uploads/products/'.$product->image)}}" alt="">
                                @endif
                            </div>
                            <div class="d-grid">
                                <button class="btn btn-lg btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>