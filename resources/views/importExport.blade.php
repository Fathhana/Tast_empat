@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h3>Simple Ajax Laravel 5.3</h3>
            <div class="panel panel-default">
                <div class="panel-body">
                        @if ($message = Session::get('success'))
					<div class="alert alert-success" role="alert">
						{{ Session::get('success') }}
					</div>
				@endif

				@if ($message = Session::get('error'))
					<div class="alert alert-danger" role="alert">
						{{ Session::get('error') }}
					</div>
				@endif

				<h3>Import File Form:</h3>
				<form style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;" action="{{ URL::to('importExcel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

					<input type="file" name="import_file" />
					{{ csrf_field() }}
					<br/>

					<button class="btn btn-primary">Import CSV or Excel File</button>

				</form>

				<br/>
    	

		    	<h3>Import File From Database:</h3>

		    	<div style="border: 4px solid #a1a1a1;margin-top: 15px;padding: 20px;"> 
			    	<a href="{{ url('downloadExcel/xls') }}"><button class="btn btn-success btn-lg">Download Excel xls</button></a>
					<a href="{{ url('downloadExcel/xlsx') }}"><button class="btn btn-success btn-lg">Download Excel xlsx</button></a>
					<a href="{{ url('downloadExcel/csv') }}"><button class="btn btn-success btn-lg">Download CSV</button></a>
		    	</div> 
		    	<br />
		    	<div class="pull-right">
                        <a class="btn btn-primary" href="{{ route('article.index') }}"> Back</a>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

