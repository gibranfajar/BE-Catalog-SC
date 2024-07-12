@extends('layouts.layouts')

@section('content')
@section('title', 'Articles')
<div class="page-heading">
    <section class="section">
        <button type="button" class="btn btn-primary block" data-bs-toggle="modal" data-bs-target="#addArticleModal">
            Add Article
        </button>

        <div class="modal fade" id="addArticleModal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Add Article</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="articles/store" method="post">
                            @csrf
                            <label for="name">Name</label>
                            <div class="form-group">
                                <input id="name" type="text" name="name" class="form-control">
                            </div>
                            <label for="description">Description</label>
                            <div class="form-group">
                                <textarea name="description" class="form-control"></textarea>
                            </div>
                            <label for="description">Sizechart</label>
                            <div class="form-group">
                                <input id="addSizeChart" type="hidden" name="size_chart">
                                <trix-editor input="addSizeChart"></trix-editor>
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
                            <th>Description</th>
                            <th>Sizechart</th>
                            <th>Publish Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($articles as $article)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $article->name }}</td>
                                <td>{{ $article->description }}</td>
                                <td>{!! $article->size_chart !!}</td>
                                <td>{{ date('D, d M Y', strtotime($article->created_at)) }}</td>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-warning block" data-bs-toggle="modal"
                                        data-bs-target="#modal-edit-{{ $article->id }}">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @foreach ($articles as $article)
            <div class="modal fade" id="modal-edit-{{ $article->id }}" tabindex="-1" role="dialog"
                aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalScrollableTitle">Edit Article</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="articles/update/{{ $article->id }}" method="post">
                                @csrf
                                <input type="hidden" name="id" value="{{ $article->id }}">
                                <label for="name">Name</label>
                                <div class="form-group">
                                    <input id="name" type="text" value="{{ $article->name }}" name="name"
                                        class="form-control">
                                </div>
                                <label for="description">Description</label>
                                <div class="form-group">
                                    <textarea name="description" class="form-control">{{ $article->description }}</textarea>
                                </div>
                                <label for="description">Sizechart</label>
                                <div class="form-group">
                                    <input id="editSizeChart" type="hidden" name="size_chart"
                                        value="{{ $article->size_chart }}">
                                    <trix-editor input="editSizeChart"></trix-editor>
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
