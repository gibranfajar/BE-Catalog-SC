@extends('layouts.layouts')

@section('content')
@section('title', 'Sizes')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addSizeModal">
            Add Size
        </button>

        <div class="modal fade" id="addSizeModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Size</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="sizes/store" method="post">
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
                            <label for="size">Size</label>
                            <div class="form-group">
                                <input id="size" type="text" name="size" class="form-control">
                            </div>
                            <label for="stock">Stock</label>
                            <div class="form-group">
                                <input id="stock" type="text" name="stock" class="form-control">
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
                            <th>Size</th>
                            <th>Stock</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sizes as $size)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $size->product->name }}</td>
                                <td>{{ $size->size }}</td>
                                <td>{{ $size->stock }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning block" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $size->id }}">
                                        Edit
                                    </button>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($sizes as $size)
            <div class="modal fade" id="modal-edit-{{ $size->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Size</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="sizes/update/{{ $size->id }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $size->id }}">
                                <label for="product">Product</label>
                                <div class="form-group">
                                    <select name="product" class="form-control" id="product">
                                        <option value="">- Select Product -</option>
                                        @foreach ($products as $product)
                                            <option {{ $product->id == $size->product_id ? 'selected' : '' }}
                                                value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                    </select>
                                </div>
                                <label for="size">Size</label>
                                <div class="form-group">
                                    <input id="size" type="text" name="size" value="{{ $size->size }}"
                                        class="form-control">
                                </div>
                                <label for="stock">Stock</label>
                                <div class="form-group">
                                    <input id="stock" type="text" name="stock" value="{{ $size->stock }}"
                                        class="form-control">
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
