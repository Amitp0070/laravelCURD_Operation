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
    <div class="product-card shadow-lg mb-2">
        <h1 class="bg-dark text-white py-2" style="border-radius: 10px;">{{ $product->name }}</h1>

        {{-- Product Image --}}
        <img src="{{asset('uploads/products/'.$product->image)}}"
            alt="{{ $product->name }}">

        {{-- Product Details --}}
        <p><strong>Price:</strong> ${{ $product->price }}</p>
        <p><strong>SKU:</strong> {{ $product->sku }}</p>
        <p><strong>Category:</strong> {{ $product->category ? $product->category->category_name : 'N/A' }}</p>
        <p><strong>Description:</strong> {{ $product->description }}</p>

    </div>

</body>

</html>