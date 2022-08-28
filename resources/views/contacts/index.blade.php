
@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-post">Add post</a>
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <td>ID</td>
                <td>Name</td>
                <td>Description</td>
                <td>Actions</td>
            </tr>
            </thead>
            <tbody id="posts-crud">
            @foreach($books as $key => $book)
                <tr id="book_id_{{ $book->id }}">
                    <td>{{ $book->id }}</td>
                    <td>{{ $book->name }}</td>
                    <td>{{ $book->description }}</td>
                    <!-- we will also add show, edit, and delete buttons -->
                    <td class="align-content-center">
                        <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                        <!-- we will add this later since its a little more complicated than the other two buttons -->

                        <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                        <!-- edit this shark (uses the edit method found at GET /sharks/{id}/edit -->
                        <a href="javascript:void(0)" id="edit-post" data-id="{{ $book->id }}" class="btn btn-info">Edit</a>
                        <a href="javascript:void(0)" id="delete-post" data-id="{{ $book->id }}" class="btn btn-danger delete-post">Delete</a>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="postCrudModal"></h4>
            </div>
            <div class="modal-body">
                <form id="postForm" name="postForm" class="form-horizontal">
                    <input type="hidden" name="book_id" id="book_id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Title</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="title" name="name" value="" required="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Body</label>
                        <div class="col-sm-12">
                            <input class="form-control" id="body" name="book_description" value="" required="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#create-new-post').click(function () {
            $('#btn-save').val("create-post");
            $('#postForm').trigger("reset");
            $('#postCrudModal').html("Add New post");
            $('#ajax-crud-modal').modal('show');
        });
        //$('#edit-post').click(function () {
        $('body').on('click', '#edit-post', function () {
            var book_id = $(this).data('id');
            $.get('ajax-contacts/'+book_id+'/edit', function (data) {
                $('#postCrudModal').html("Edit post");
                $('#btn-save').val("edit-post");
                $('#ajax-crud-modal').modal('show');
                $('#book_id').val(data.id);
                $('#title').val(data.name);
                $('#body').val(data.description);
            })
        });
        $('body').on('click', '.delete-post', function () {
            var book_id = $(this).data("id");
            confirm("Are You sure want to delete !");

            $.ajax({
                type: "DELETE",
                url: "{{ url('ajax-contacts')}}"+'/'+book_id,
                success: function (data) {
                    $("#book_id_" + book_id).remove();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        });
    });

    if ($("#postForm").length > 0) {
        $("#postForm").validate({

            submitHandler: function(form) {
                var actionType = $('#btn-save').val();
                $('#btn-save').html('Sending..');
                console.log($('#postForm').serialize());
                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ route('ajax-contacts.store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        var post = '<tr id="book_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.description + '</td>';
                        //var post = '<tr id="book_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td><td>' + data.description +'</td>';
                        post += '<td><a href="javascript:void(0)" id="edit-post" data-id="' + data.id + '" class="btn btn-info">Edit</a> ';
                        post += '<a href="javascript:void(0)" id="delete-post" data-id="' + data.id + '" class="btn btn-danger delete-post">Delete</a></td></tr>';


                        if (actionType == "create-post") {
                            $('#posts-crud').prepend(post);
                        } else {
                            $("#book_id_" + data.id).replaceWith(post);
                        }

                        $('#postForm').trigger("reset");
                        $('#ajax-crud-modal').modal('hide');
                        $('#btn-save').html('Save Changes');

                    },
                    error: function (data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            }
        })
    }


</script>@endsection