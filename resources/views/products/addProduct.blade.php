@extends('layouts.layouts')

@section('content')
@section('title', 'Products')
<div class="page-heading">
    <div class="card">
        <div class="card-body">
            <form action="products/store" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name">Name</label>
                    <div class="form-group">
                        <input id="name" type="text" name="name" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="article">Article</label>
                    <div class="form-group">
                        <input id="article" type="text" name="article" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description">Description</label>
                    <div class="form-group">
                        <input id="description" type="hidden" name="description">
                        <trix-editor input="description"></trix-editor>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="size_chart">Size Chart</label>
                    <div class="form-group">
                        <input id="size_chart" type="hidden" name="size_chart">
                        <trix-editor input="size_chart"></trix-editor>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="category">Category</label>
                    <div class="form-group">
                        <select name="category" class="form-control" id="category">
                            <option value="">- Select Category -</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="color">Color</label>
                    <div class="form-group">
                        <select name="color" class="form-control" id="color">
                            <option value="">- Select Color -</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="size">Size and Stock</label>
                    <div id="size-stock-wrapper">
                        <div class="form-group size-stock-group row d-flex justify-content-between">
                            <div class="col-md-4">
                                <input id="size" type="text" name="size[]" class="form-control"
                                    placeholder="Size">
                            </div>
                            <div class="col-md-4">
                                <input id="stock" type="text" name="stock[]" class="form-control"
                                    placeholder="Stock">
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-danger remove-size-stock">Remove</button>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success" id="add-size-stock">Add Size</button>
                </div>

                <div class="mb-3">
                    <label for="image">Image</label>
                    <div class="form-group">
                        <input id="image" type="file" name="image[]" multiple class="form-control">
                    </div>
                </div>


                <div class="mb-3">
                    <label for="price">Price</label>
                    <div class="form-group">
                        <input id="price" type="text" name="price" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price_disc">Price Discount</label>
                    <div class="form-group">
                        <input id="price_disc" type="text" name="price_disc" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary w-25">
                        <span class="d-none d-sm-block">Submit</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('add-size-stock').addEventListener('click', function() {
        var wrapper = document.getElementById('size-stock-wrapper');
        var newFieldGroup = document.createElement('div');
        newFieldGroup.classList.add('form-group', 'size-stock-group', 'row', 'd-flex',
            'justify-content-between');
        newFieldGroup.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="size[]" class="form-control" placeholder="Size">
            </div>
            <div class="col-md-4">
                <input type="text" name="stock[]" class="form-control" placeholder="Stock">
            </div>
            <div class="col-md-4">
                <button type="button" class="btn btn-danger remove-size-stock">Remove</button>
            </div>
        `;
        wrapper.appendChild(newFieldGroup);
    });

    document.getElementById('size-stock-wrapper').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-size-stock')) {
            event.target.parentElement.parentElement.remove();
        }
    });
</script>

@endsection
