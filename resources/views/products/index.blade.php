@extends('layouts.layouts')

@section('content')
@section('title', 'Products')
<div class="page-heading">
    <section class="section">
        <a href="{{ route('products.add') }}" class="btn btn-primary block">Add Product</a>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-striped text-center" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="w-25">Product Name</th>
                            <th>Article</th>
                            <th>Category</th>
                            <th>Color</th>
                            <th class="w-25">Size</th>
                            <th>Price</th>
                            <th>Price Discount</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productsData as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product['name'] }}</td>
                                <td>{{ $product['article'] }}</td>
                                <td>{{ $product['category'] }}</td>
                                <td>{{ $product['color'] }}</td>
                                <td>
                                    @foreach ($product['sizes'] as $size)
                                        <div>{{ $size['name'] }} (Stock: {{ $size['stock'] }})</div>
                                    @endforeach
                                </td>
                                <td>{{ $product['price'] }}</td>
                                <td>{{ $product['price_disc'] }}</td>
                                <td>
                                    <img src="{{ asset($product['image']) }}" class="img-fluid w-100"
                                        alt="{{ $product['name'] }}">
                                </td>
                                <td>
                                    <a href="/products/edit/{{ $product['id'] }}" class="btn btn-warning">Edit</a>
                                    <a href="/products/delete/{{ $product['id'] }}"
                                        onclick="return confirm('Are you sure?')" class="btn btn-danger">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
