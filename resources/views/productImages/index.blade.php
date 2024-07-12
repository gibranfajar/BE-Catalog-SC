@extends('layouts.layouts')

@section('content')
@section('title', 'Product Images')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addImagesModal">
            Add Images
        </button>

        <div class="modal fade" id="addImagesModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Images</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="product-images/store" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="product">Product</label>
                            <div class="form-group">
                                <select name="product" class="form-control" id="product">
                                    <option value="">- Select Product -</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                </select>
                            </div>
                            <label for="image">Image</label>
                            <div class="form-group">
                                <input id="image" type="file" name="image[]" class="form-control" multiple>
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
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productImages as $image)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $image->product->name }}</td>
                                <td><img src="{{ asset('storage/products/' . $image->image) }}" class="img-fluid w-25"
                                        alt="{{ $image->image }}" srcset="">
                                </td>
                                <td>
                                    <form action="product-images/delete/{{ $image->id }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="alert('Are you sure?')">Delete</button>
                                    </form>
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
