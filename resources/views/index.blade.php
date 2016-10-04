@extends('layouts.app')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h3>Simple Ajax CRUD Laravel 5.3</h3>
			<div class="panel panel-default">
				<div class="panel-body">
					@if(Session::has('alert-success'))
					    <div class="alert alert-success">
				            {{ Session::get('alert-success') }}
				        </div>
					@endif
					{{-- <a href="{{route('crud.create')}}" class="btn btn-info pull-right">Tambah Data</a><br><br> --}}
					<!-- Small modal -->
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
					        			<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
					        		</div>
					        		<div class="form-group">
					        			<input type="text" name="phone" id="phone" class="form-control" placeholder="Nomor Handphone">
					        		</div>
					        		<div class="form-group" align="right">
					        			<button type="reset" class="btn btn-default">Reset</button>
					        			<button type="button" id="add" class="btn btn-primary" data-dismiss="modal">Simpan</button>
					        		</div>
						      	</div>
					    	</div>
					  	</div>
					</div>

					<table class="table table-striped" id="table">
						<tr>
							<th>ID</th>
							<th>Nama</th>
							<th>No HP</th>
							<th>Action</th>
						</tr>
						@foreach($cruds as $crud)
						<tr class="item{{$crud->id}}">
							<td>{{$crud->id}}</td>
							<td>{{$crud->nama}}</td>
							<td>{{$crud->phone}}</td>
							<td>
								<button class="edit-modal btn btn-info btn-sm" data-id="{{$crud->id}}" data-nama="{{$crud->nama}}" data-phone="{{$crud->phone}}">Edit</button>
								<button class="delete-modal btn btn-danger btn-sm" data-id="{{$crud->id}}">Delete</button>
							</td>
						</tr>
						@endforeach
					</table>
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
					        			<input type="text" name="nama-edit" id="nama-edit" class="form-control" placeholder="Nama">
					        		</div>
					        		<div class="form-group">
					        			<input type="text" name="phone-edit" id="phone-edit" class="form-control" placeholder="Nomor Handphone">
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
		$('#nama-edit').val($(this).data('nama'));
		$('#phone-edit').val($(this).data('phone'));
		$('.bs-example-modal-sm2').modal('show');
	});
	$(document).on('click', '.delete-modal', function() {
		$('#id-delete').val($(this).data('id'));
		$('.bs-example-modal-sm3').modal('show');
	});
	$("#add").click(function() {

        $.ajax({
            type: 'post',
            url: '/crud/store',
            data: {
                '_token': $('input[name=_token]').val(),
                'nama': $('input[name=nama]').val(),
                'phone': $('input[name=phone]').val()
            },
            success: function(data) {
                if ((data.errors)){
                	$('.error').removeClass('hidden');
                    $('.error').text(data.errors.name);
                }
                else {
                    $('.error').remove();
                    $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.nama + "</td><td>" + data.phone + "</td><td><button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-nama='" + data.nama + "' data-phone='" + data.phone + "'>Edit</button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "'>Delete</button></td></tr>");
				  	toastr.success("Data Berhasil Disimpan.");
                }
            },
        });
        $('#nama').val('');
        $('#phone').val('');
    });

    $("#edit").click(function() {
        $.ajax({
            type: 'post',
            url: '/crud/update',
            data: {
                '_token': $('input[name=_token]').val(),
                'id' : $('input[name=id]').val(),
                'nama': $('input[name=nama-edit]').val(),
                'phone': $('input[name=phone-edit]').val()
            },
            success: function(data) {
                $('.item' + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.nama + "</td><td>" + data.phone + "</td><td><button class='edit-modal btn btn-info btn-sm' data-id='" + data.id + "' data-nama='" + data.nama + "' data-phone='" + data.phone + "'>Edit</button> <button class='delete-modal btn btn-danger btn-sm' data-id='" + data.id + "' data-name='" + data.name + "'>Delete</button></td></tr>");
                toastr.success("Data Berhasil Diubah.");
            },
        });
    });

    $("#delete").click(function() {
        $.ajax({
            type: 'post',
            url: '/crud/destroy',
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
</script>
@endsection