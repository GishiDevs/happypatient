
@extends('layouts.main')
@section('title', 'Add Patient')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patient</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Patient Record</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Patient Record Lists</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patient-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Birthdate</th>
                    <th>Weight</th>
                    <th>Gender</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Middlename</th>
                    <th>Birthdate</th>
                    <th>Weight</th>
                    <th>Gender</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>
  $(function () {
    $(document).ready(function() {
			// $('#tax-table').DataTable();
		    $('#patient-table').DataTable({
                "responsive": true,
                "autoWidth": false,
		    	"processing": true,
		    	"serverSide": true,
		    	"ajax": "{{ route('getpatientrecord') }}",
		    	"bDestroy": true,
		    	"columns": [
                    { "data": "id"},
		    		{ "data": "lastname"},
		    		{ "data": "firstname"},
		    		{ "data": "middlename"},
                    { "data": "birthdate"},
                    { "data": "weight"},
                    { "data": "gender"},
		    		{ "data": "action", orderable: false, searchable: false}
		    	]
		    });
		});
  });
</script>
@endsection

