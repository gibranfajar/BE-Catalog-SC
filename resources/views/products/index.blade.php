@extends('layouts.layouts')

@section('content')
@section('title', 'Products')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addProductModal">
            Add Product
        </button>

        <div class="modal fade" id="addProductModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Product</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="products/store" method="post">
                            @csrf
                            <label for="name">Name</label>
                            <div class="form-group">
                                <input id="name" type="text" name="name" class="form-control">
                            </div>
                            <label for="article">Article</label>
                            <div class="form-group">
                                <select name="article" class="form-control" id="article">
                                    <option value="">- Select Article -</option>
                                    @foreach ($articles as $article)
                                        <option value="{{ $article->id }}">{{ $article->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="category">Category</label>
                            <div class="form-group">
                                <select name="category" class="form-control" id="category">
                                    <option value="">- Select Category -</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="color">Color</label>
                            <div class="form-group">
                                <select name="color" class="form-control" id="color">
                                    <option value="">- Select Color -</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label for="sku">Sku</label>
                            <div class="form-group">
                                <input id="sku" type="text" name="sku" class="form-control">
                            </div>
                            <label for="price">Price</label>
                            <div class="form-group">
                                <input id="price" type="text" name="price" class="form-control">
                            </div>
                            <label for="price_disc">Price Discount</label>
                            <div class="form-group">
                                <input id="price_disc" type="text" name="price_disc" class="form-control">
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Submit</span>
                        </button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-striped text-center" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product Name</th>
                            <th>Article</th>
                            <th>Category</th>
                            <th>Color</th>
                            <th>Sku</th>
                            <th>Price</th>
                            <th>Price Discount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->article->name }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>{{ $product->color->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->price_discount }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning block" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $product->id }}">
                                        Edit
                                    </button>
                                    <a href="/products/delete/{{ $product->id }}" onclick="alert('Are you sure?')"
                                        class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($products as $product)
            <div class="modal fade" id="modal-edit-{{ $product->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Product</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="products/update/{{ $product->id }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <input id="name" type="text" name="name"
                                        value="{{ $product->name }}" class="form-control">
                                </div>
                                <label for="article">Article</label>
                                <div class="form-group">
                                    <select name="article" class="form-control" id="article">
                                        <option value="">- Select Article -</option>
                                        @foreach ($articles as $article)
                                            <option {{ $article->id == $product->article_id ? 'selected' : '' }}
                                                value="{{ $article->id }}">{{ $article->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="category">Category</label>
                                <div class="form-group">
                                    <select name="category" class="form-control" id="category">
                                        <option value="">- Select Category -</option>
                                        @foreach ($categories as $category)
                                            <option {{ $category->id == $product->category_id ? 'selected' : '' }}
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="color">Color</label>
                                <div class="form-group">
                                    <select name="color" class="form-control" id="color">
                                        <option value="">- Select Color -</option>
                                        @foreach ($colors as $color)
                                            <option {{ $color->id == $product->color_id ? 'selected' : '' }}
                                                value="{{ $color->id }}">{{ $color->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="sku">Sku</label>
                                <div class="form-group">
                                    <input id="sku" type="text" name="sku" value="{{ $product->sku }}"
                                        class="form-control">
                                </div>
                                <label for="price">Price</label>
                                <div class="form-group">
                                    <input id="price" type="text" name="price"
                                        value="{{ $product->price }}" class="form-control">
                                </div>
                                <label for="price_disc">Price Discount</label>
                                <div class="form-group">
                                    <input id="price_disc" type="text" name="price_disc"
                                        value="{{ $product->price_discount }}" class="form-control">
                                </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Update</span>
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </section>
</div>
@endsection
