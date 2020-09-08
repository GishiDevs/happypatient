
@extends('layouts.main')
@section('title', 'Services List')
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
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Services List</li>
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
                <h3 class="card-title">Services List</h3>
                @can('patientservices-create')
                <a href="{{ route('patientservice.create') }}" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patient-table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th width="50px">Status</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Status</th>
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

  $(document).ready(function() {
    $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('patientservice.serviceslist') }}",
		    "bDestroy": true,
		    "columns": [
                    { "data": "id"},
		    		        { "data": "docdate"},
		    		        { "data": "patientname"},
		    		        { "data": "service"},
                    { "data": "status"}
		    ],
        "order": [[ 0, "asc" ]]      
        
    });
    
	});

</script>
@endsection

