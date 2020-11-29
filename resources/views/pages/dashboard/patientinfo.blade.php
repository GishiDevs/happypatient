
@extends('layouts.main')
@section('title', 'Dashboard')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patient Information</h1>
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
                {{-- <h3 class="card-title">Patient record list for today {{ date('Y-m-d') }}</h3> --}}
                <h3 class="card-title">Patient record list for {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime(date('Y-m-d')))) !!}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patient-table" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Civil Status</th>
                      <th>Mobile</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Civil Status</th>
                      <th>Mobile</th>
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
    var columns = [{ "data": "DT_RowIndex"},
                   { "data": "lastname"},
                   { "data": "firstname"},
                   { "data": "middlename"},
                   { "data": "birthdate"},
                   { "data": "gender"},
                   { "data": "civilstatus"},
                   { "data": "mobile"}];

			// $('#tax-table').DataTable();
	  $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getpatientlists') }}",
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
      
      //PUSHER - refresh data when table patient_services or patient_service_items has changes
      if(data.action == 'create-patient' || data.action == 'edit-patient' || data.action == 'delete-patient')
      {
        $('#patient-table').DataTable().ajax.reload()
      }

    });
        
	});

</script>
@endsection

