<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="bg-dark py-3">
        <h3 class="text-white text-center">Simple Laravel 11 CRUD</h3>
    </div>
    <div class="container">

        <div class="row justify-content-center">
            @if(Session::has('success'))
            <div class="col-md-8 mt-2">
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            </div>
            @endif

            <div class="row justify-content-center mt-3">
                <div class="col-md-12 d-flex justify-content-end">
                    <a href="{{ route('products.create') }}" class="btn btn-lg btn-dark">Create Product</a>
                </div>
            </div>
        </div>

        <div class="row d-flex justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg my-3">
                    <div class="card-header text-white bg-dark">
                        <h3>Products</h3>
                    </div>
                    <div class="card-body">
                        <table class="table text-center">
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Name</th>
                                <th>Sku</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>State</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            @if($products->isNotEmpty())
                            @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>
                                    @if($product->image != "")
                                    <img src="{{ asset('uploads/products/'.$product->image) }}" alt=""
                                        style="width: 60px; height: 55px; border-radius: 10px;">
                                    @endif
                                </td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category->category_name ?? 'N/A' }}</td>
                                <!-- <td>{{ $product->category ? $product->category->category_name : 'No Category' }}</td> -->
                                <td>${{ $product->price }}</td>
                                <td>
                                    @if($product->state == 1)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                                <td>
                                    <a href="{{ route('products.view',$product->id) }}" class="btn btn-primary">view</a>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">Edit</a>
                                    <a href="#" onclick="deleteProduct('{{ $product->id }}')"
                                        class="btn btn-danger">Delete</a>

                                    <form id="delete-product-form-{{ $product->id }}"
                                        action="{{ route('products.delete', $product->id) }}" method="post">
                                        @csrf
                                        @method('delete')
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
</body>

</html>

<script>
    function deleteProduct(id) {
        if (confirm('Are you sure you want to delete this product?')) {
            document.getElementById("delete-product-form-" + id).submit();
        }
    }
</script>