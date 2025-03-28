<!doctype html>
<html lang="en">

<head>
    <title>{{ $product->name }}</title>
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
    <style>
        body {
            overflow-x: hidden;
            text-align: center;

        }

        .product-card {
            width: 50%;
            margin: auto;
            border: 1px solid #ddd;
            background-color: #fff;
            padding: 5px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        img {
            max-width: 60%;
            height: auto;
            border-radius: 10px;
        }
    </style>
</head>

<body >
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel CRUD Operation</h3>
    </div>
    <div class="row justify-content-center my-2 ">
        <div class="col-md-6 d-flex justify-content-end">
            <a href="{{ route('products.index') }}" class="btn btn-lg btn-dark">Back </a>
        </div>
    </div>
    <div class="product-card shadow-sm p-4 mb-3" style="background: linear-gradient(135deg, #fdfbfb, #ebedee); border-radius: 12px; border: 1px solid #ddd;">
    <h2 class="text-primary text-center mb-3" style="font-weight: bold;">{{ $product->name }}</h2>

    <!-- Product Image -->
    <div class="text-center">
        <img src="{{ asset('uploads/products/'.$product->image) }}" 
            alt="{{ $product->name }}" 
            style="width: 80%; max-height: 300px; object-fit: cover; border-radius: 12px; border: 3px solid #e0e0e0;">
    </div>

    <!-- Product Details Section -->
    <div class="product-details mt-4 p-3 rounded" style="background: #ffffff; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);">
        <div class="d-flex align-items-center mb-3">
            <span class="text-primary fs-5 me-2">💰</span>
            <p class="text-muted m-0"><strong>Price:</strong> <span class="text-dark">${{ $product->price }}</span></p>
        </div>
        
        <div class="d-flex align-items-center mb-3">
            <span class="text-success fs-5 me-2">🔢</span>
            <p class="text-muted m-0"><strong>SKU:</strong> <span class="text-dark">{{ $product->sku }}</span></p>
        </div>
        
        <div class="d-flex align-items-center mb-3">
            <span class="text-warning fs-5 me-2">📂</span>
            <p class="text-muted m-0"><strong>Category:</strong> <span class="text-dark">{{ $product->category ? $product->category->category_name : 'N/A' }}</span></p>
        </div>

        <div class="d-flex align-items-center mb-3">
            <span class="fs-5 me-2">🚀</span>
            <p class="text-muted m-0"><strong>State:</strong> 
                @if($product->state == 1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </p>
        </div>

        <div class="d-flex align-items-start">
            <span class="text-danger fs-5 me-2">📝</span>
            <p class="text-muted m-0"><strong>Description:</strong> <span class="text-dark">{{ $product->description }}</span></p>
        </div>
    </div>
</div>
@include('accounts.footer')

</body>

</html>