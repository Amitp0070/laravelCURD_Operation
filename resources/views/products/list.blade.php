<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />


    <!-- Include FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <!-- Bootstrap Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
        <div class="container">
            <a class="navbar-brand fw-bold  text-white " href="#">
                <i class="fas fa-database"></i> Laravel 11 CRUD
            </a>

            <!-- Responsive Button for Small Screens -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    @auth
                    <li class="nav-item d-flex align-items-center">
                        <span class="text-white fw-bold me-3">
                            <i class="fas fa-user-circle"></i> Welcome, {{ Auth::user()->name }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="btn btn-danger"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @else
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="btn btn-warning me-2">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">

        <div class="row justify-content-center">
            @if(Session::has('success'))
            <div class="col-md-8 mt-2">
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            </div>
            @endif

            <div class="row justify-content-center mt-3">
                <div class="col-md-12 d-flex justify-content-end">
                    @auth
                    <a href="{{ route('products.create') }}" class="btn btn-lg btn-dark">
                        <i class="fas fa-plus"></i> Create Product
                    </a>
                    @endauth
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
                        <table class="table">
                            <tr>
                                <th>ID</th>
                                <th></th>
                                <th>Name</th>
                                <th>Sku</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Created At</th>
                                <th>State</th>
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
                                <td>{{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}</td>
                                <td>
                                    @if($product->state == 1)
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('products.view',$product->id) }}" class="btn btn-primary">view</a>
                                    @if(Auth::check() && Auth::user()->id === $product->user_id)
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('products.delete', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this product?');" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                <ul class="pagination">
                                    @if ($products->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">Previous</span>
                                    </li>
                                    @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                                            &laquo; Previous
                                        </a>
                                    </li>
                                    @endif

                                    @foreach ($products->links()->elements[0] as $page => $url)
                                    <li class="page-item {{ $products->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                    @endforeach

                                    @if ($products->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                                            Next &raquo;
                                        </a>
                                    </li>
                                    @else
                                    <li class="page-item disabled">
                                        <span class="page-link">Next</span>
                                    </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('accounts.footer')
</body>

</html>