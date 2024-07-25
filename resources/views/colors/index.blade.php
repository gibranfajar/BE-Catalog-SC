@extends('layouts.layouts')

@section('content')
@section('title', 'Colors')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addColorModal">
            Add Color
        </button>

        <div class="modal fade" id="addColorModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Color</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="colors/store" method="post">
                            @csrf
                            <label for="name">Name</label>
                            <div class="form-group">
                                <input id="name" type="text" name="name" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="entry">
                                        <div class="innr">
                                            <div class="another">
                                                <div class="color-picker" data-input-id="add-color-input"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <input type="text" id="add-color-input" name="color" class="form-control"
                                        readonly>
                                </div>
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
                            <th>Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($colors as $color)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $color->name }}</td>
                                <td>
                                    <span
                                        style="background-color: {{ $color->code }}; display: inline-block; width: 50px; height: 20px; border-radius: 4px; margin-right: 10px;"></span>
                                    {{ $color->code }}
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $color->id }}">
                                        Edit
                                    </button>
                                    <a href="colors/delete/{{ $color->id }}"
                                        onclick="return confirm('Are you sure?')" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>


        @foreach ($colors as $color)
            <div class="modal fade" id="modal-edit-{{ $color->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit color</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="categories/update/{{ $color->id }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $color->id }}">
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <input id="name" type="text" name="name" value="{{ $color->name }}"
                                        class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="entry">
                                            <div class="innr">
                                                <div class="another">
                                                    <div class="color-picker"
                                                        data-input-id="edit-color-input-{{ $color->id }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" id="edit-color-input-{{ $color->id }}"
                                            name="color" value="{{ $color->code }}" class="form-control"
                                            readonly>
                                    </div>
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
