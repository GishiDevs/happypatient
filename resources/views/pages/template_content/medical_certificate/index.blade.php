
@extends('layouts.main')
@section('title', 'Services')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Medical Certificate</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Medical Certificate Templates</li>
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
                <h3 class="card-title">Medical Certificate Templates</h3>
                @can('certificate-create')
                <a href="{{ route('certificate.template.create') }}" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('certificate-list')
                <table id="certificate-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <!-- <th>ID</th> -->
                      <th>Template Name</th>
                      @canany(['certificate-edit','certificate-delete'])
                      <th width="140px" class="no-sort">Actions</th>
                      @endcan
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <!-- <th>ID</th> -->
                      <th>Template Name</th>
                      @canany(['certificate-edit','certificate-delete'])
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
    var action_type;
    var serviceid;
    var columns = [{ "data": "DT_RowIndex"},
                  //  { "data": "id"},
                   { "data": "name"}];

    @canany(['certificate-edit', 'certificate-delete'])
      columns.push({data: "action"});
    @endcanany
    
			// $('#tax-table').DataTable();
	  $('#certificate-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('gettemplatelist') }}",
		    "bDestroy": true,
		    "columns": columns,
        "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });

      
    // PUSHER

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher( "{{ env('PUSHER_APP_KEY') }}" , {
      cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
      encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('happypatient-event');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\EventNotification', function(data) {

      console.log(data.action);
      
      //PUSHER - refresh data when table services has changes
      if(data.action == 'create-certificate' || data.action == 'edit-certificate' || data.action == 'delete-certificate')
      {
        $('#certificate-table').DataTable().ajax.reload()
      }

    });

});

</script>
@endsection

