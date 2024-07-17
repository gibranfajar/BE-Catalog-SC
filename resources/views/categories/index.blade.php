@extends('layouts.layouts')

@section('content')
@section('title', 'Categories')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            Add Category
        </button>

        <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Category</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="categories/store" method="post">
                            @csrf
                            <label for="name">Name</label>
                            <div class="form-group">
                                <input id="name" type="text" name="name" class="form-control">
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
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <button type="button" class="btn btn-warning block" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $category->id }}">
                                        Edit
                                    </button>
                                    <a href="categories/delete/{{ $category->id }}"
                                        onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        @foreach ($categories as $category)
            <div class="modal fade" id="modal-edit-{{ $category->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Category</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="categories/update/{{ $category->id }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <input id="name" type="text" name="name" value="{{ $category->name }}"
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
