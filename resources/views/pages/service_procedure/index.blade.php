
@extends('layouts.main')
@section('title', 'Services')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Service Procedure Record</li>
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
                <h3 class="card-title">Service Procedure Record</h3>
                @can('service-create')
                  <a href="{{ route('serviceprocedure.create') }}" id="btn-add-procedure" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('service-list')
                <table id="service-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <th>ID</th>
                      <th>Service</th>
                      <th>Procedure</th>
                      <th>Price</th>
                      @canany(['serviceprocedure-edit','serviceprocedure-delete'])
                      <th width="140px" class="no-sort">Actions</th>
                      @endcan
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Service</th>
                      <th>Procedure</th>
                      <th>Price</th>
                      @canany(['serviceprocedure-edit','serviceprocedure-delete'])
                      <th>Actions</th>
                      @endcanany
                    </tr>
                  </tfoot>
                </table>
                @endcan
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
    // var action_type;
    // var serviceid;
    // var columns = [{ "data": "DT_RowIndex"},
    //                { "data": "id"},
    //                { "data": "service"},
    //                { "data": "status"}];

    // @canany(['service-edit', 'service-delete'])
    //   columns.push({data: "action"});
    // @endcanany
    
		// 	// $('#tax-table').DataTable();
	  // $('#service-table').DataTable({
    //     "responsive": true,
    //     "autoWidth": false,
		//     "processing": true,
		//     "serverSide": true,
		//     "ajax": "{{ route('getprocedurerecord') }}",
		//     "bDestroy": true,
		//     "columns": columns,
    //     "order": [ 1, "asc" ],
    //     "columnDefs": [{
    //                       "targets": "no-sort",
    //                       "orderable": false
    //                     }] 
    // });

</script>
@endsection

