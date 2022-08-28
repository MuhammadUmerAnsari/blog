@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Books') }}</div>

                <div class="card-body">
                    <div class="container">
                        <h2>Please Enter The Book Details Here.</h2>
                        <form action="{{ URL::to('/books/store/') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="email">Book Name:</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Book Name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Book Description:</label>
                                <textarea class="form-control" rows="5" id="description" name="book_description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a class="btn btn-small btn-success" href="{{ URL::to('/books/index/') }}">Backs</a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
