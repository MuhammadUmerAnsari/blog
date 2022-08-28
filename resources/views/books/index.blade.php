@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Books') }} <a href="{{ url('/books/create') }}" class="btn btn-xs btn-info pull-right float-right">Create Book</a></div>
                <div class="card-body">
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Description</td>
                            <td>Created On</td>
                            <td>Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($books as $key => $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->name }}</td>
                                <td>{{ $book->description }}</td>
                                <td>{{ $book->created_at }}</td>
                                <!-- we will also add show, edit, and delete buttons -->
                                <td class="align-content-center">
                                    <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                                    <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                    <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                                    <a class="btn btn-small btn-info" href="{{ URL::to('/books/edit/' . $book->id) }}">Edit</a>
                                    <a class="btn btn-small btn-success" href="{{ URL::to('/books/delete/' . $book->id) }}" >Delete</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
