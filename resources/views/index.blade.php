@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Simple Ajax Laravel 5.3</h3>
			<div class="panel panel-default">
				<div class="panel-body">
					@if(Session::has('alert-success'))
					    <div class="alert alert-success">
				            {{ Session::get('alert-success') }}
				        </div>
					@endif
					
					{{-- <a href="{{route('article.create')}}" class="btn btn-info pull-right">Tambah Data</a><br><br> --}}
					<!-- Small modal -->
					<a href="{{ action('ImportExcel@importExport') }}" class="btn btn-success pull-left btn-sm">Import/Export Excel</a> 
					
					<button type="button" class="btn btn-info pull-right btn-sm" data-toggle="modal" data-target=".bs-example-modal-sm1">Tambah Data</button><br><br>

					<div class="modal fade bs-example-modal-sm1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
					  	<div class="modal-dialog modal-sm" role="document">
					    	<div class="modal-content">
					      		<div class="modal-header">
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        	<h4 class="modal-title">Tambah Data</h4>
						      	</div>
						      	<div class="modal-body">
					        		<div class="form-group">
					        			{{ csrf_field() }}
					        			<input type="text" name="title" id="title" class="form-control" placeholder="Title">
					        		</div>
					        		<div class="form-group">
					        			<textarea type="text" name="description" id="description" class="form-control" placeholder="Description"></textarea>
					        		</div>
					        		<div class="form-group" align="right">
					        			<button type="reset" class="btn btn-default" onclick="ClearFields();">Reset</button>
					        			<button type="button" id="add" class="btn btn-primary" data-dismiss="modal">Simpan</button>
					        		</div>
						      	</div>
					    	</div>
					  	</div>
					</div>

					<table class="table table-striped" id="table">
						<tr>
							<th>ID</th>
							<th>Title</th>
							<th>Description</th>
							<th>Action</th>
						</tr>
						@foreach($articles as $article)
						<tr class="item{{$article->id}}">
							<td>{{$article->id}}</td>
							<td>{{$article->title}}</td>
							<td>{{$article->description}}</td>
							<td>
								<a class="btn btn-primary btn-sm" href="{{ route('article.show',$article->id) }}" >Show</a>
								<button class="edit-modal btn btn-info btn-sm" data-id="{{$article->id}}" data-title="{{$article->title}}" data-description="{{$article->description}}">Edit</button>
								<button class="delete-modal btn btn-danger btn-sm" data-id="{{$article->id}}">Delete</button>
							</td>
						</tr>

						@endforeach
					</table>
					{{ $articles->links() }} 
					<!-- Edit modal -->
					<div class="modal fade bs-example-modal-sm2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
					  	<div class="modal-dialog modal-sm" role="document">
					    	<div class="modal-content">
					      		<div class="modal-header">
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        	<h4 class="modal-title">Ubah Data</h4>
						      	</div>
						      	<div class="modal-body">
					        		<div class="form-group">
					        			{{ csrf_field() }}
					        			<input type="hidden" name="id" id="id-edit">
					        			<input type="text" name="title-edit" id="title-edit" class="form-control" placeholder="Title">
					        		</div>
					        		<div class="form-group">
					        			<textarea type="text" name="description-edit" id="description-edit" class="form-control" placeholder="Description"></textarea>
					        		</div>
					        		<div class="form-group" align="right">
					        			<button type="button" id="edit" class="btn btn-primary" data-dismiss="modal">Ubah</button>
					        		</div>
						      	</div>
					    	</div>
					  	</div>
					</div>
					<!-- Delete modal -->
					<div class="modal fade bs-example-modal-sm3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
					  	<div class="modal-dialog modal-sm" role="document">
					    	<div class="modal-content">
					      		<div class="modal-header">
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						        	<h4 class="modal-title">Delete Data</h4>
						      	</div>
						      	<div class="modal-body">
					        		<div class="form-group">
					        			{{ csrf_field() }}
					        			<input type="hidden" name="id-delete" id="id-delete">
					        			<p>Yakin Ingin Menghapus Data? </p>
					        		</div>
					        		<div class="form-group" align="right">
					        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					        			<button type="button" id="delete" class="btn btn-danger" data-dismiss="modal">Delete</button>
					        		</div>
						      	</div>
					    	</div>
					  	</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('javascript')
<script>
	$(document).on('click', '.edit-modal', function() {
		$('#id-edit').val($(this).data('id'));
		$('#title-edit').val($(this).data('title'));
		$('#description-edit').val($(this).data('description'));
		$('.bs-example-modal-sm2').modal('show');
	});
	$(document).on('click', '.delete-modal', function() {
		$('#id-delete').val($(this).data('id'));
		$('.bs-example-modal-sm3').modal('show');
	});
	$("#add").click(function() {

        $.ajax({
            type: 'post',
            url: '/article/store',
            data: {
                '_token': $('input[name=_token]').val(),
                'title': $('input[name=title]').val(),
                'description': $('textarea[name=description]').val()
            },
            success: function(data) {
                if ((data.errors)){
                	$('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                }
                else {
                    $('.error').remove();
                    $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.title + "</td><td>" + data.description + "</td><td><a class='btn btn-primary btn-sm' href='/article/" + data.id + "'>Show</a> <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'>Edit</button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "'>Delete</button></td></tr>");
				  	toastr.success("Data Berhasil Disimpan.");
                }
            },
        });
        $('#title').val('');
        $('#description').val('');
    });

    $("#edit").click(function() {
        $.ajax({
            type: 'post',
            url: '/article/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id' : $('input[name=id]').val(),
                'title': $('input[name=title-edit]').val(),
                'description': $('textarea[name=description-edit]').val()
            },
            success: function(data) {
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.title + "</td><td>" + data.description + "</td><td><a class='btn btn-primary btn-sm' href='/article/" + data.id + "'>Show</a> <button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-title='" + data.title + "' data-description='" + data.description + "'>Edit</button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "'>Delete</button></td></tr>");
                toastr.success("Data Berhasil Diubah.");
            },
        });
    });

    $("#delete").click(function() {
        $.ajax({
            type: 'post',
            url: '/article/destroy',
            data: {
                '_token': $('input[name=_token]').val(),
                'id' : $('input[name=id-delete]').val()
            },
            success: function(data) {
                $('.item' + data.id).remove();
                toastr.success("Data Berhasil Dihapus.");
            }
        });
    });

	function ClearFields() {

	     document.getElementById("title").value = "";
	     document.getElementById("description").value = "";
	}
</script>
@endsection