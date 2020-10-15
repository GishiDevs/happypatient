
@extends('layouts.main')
@section('title', 'Dashboard')
@section('main_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
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
                <table id="patient-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <th>ID</th>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Procedure</th>
                      <th width="50px">Status</th>
                      <th>Diagnose Date</th>
                      <th width="100px" class="no-sort">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Procedure</th>
                      <th>Status</th>
                      <th>Diagnose Date</th>
                      <th>Actions</th>
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

  </div>

  <script>

  $(document).ready(function() {
 
    // if session has request to download pdf
    @if(Session::has('download_pdf'))
      $(location).attr('href', "{{ route('diagnosis.print', session()->get('download_pdf'))}}");
    @endif

			// $('#tax-table').DataTable();
	  $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('patientservice.servicesperuser') }}",
		    "bDestroy": true,
		    "columns": [
                    { "data": "DT_RowIndex"},
                    { "data": "ps_items_id"},
		    		        { "data": "docdate"},
		    		        { "data": "name"},
		    		        { "data": "service"},
                    { "data": "procedure"},
                    { "data": "status"},
                    { "data": "diagnose_date"},
                    { "data": "action"}
		    ],
        "order": [[ 6, "desc" ],
                  [ 2, "asc" ], 
                  [ 4, "asc" ], 
                  [ 1, "asc" ]
        ],

        "columnDefs": [
          { "visible": false, "targets": 1 },
          { "targets": "no-sort","orderable": false },
          {
            "targets": 6,
            "render": function ( data ) {
                if(data == 'diagnosed')
                {
                  return '<span class="badge bg-success">'+data+'</span>';
                }
                else if(data == 'pending')
                {
                  return '<span class="badge bg-warning">'+data+'</span>';
                }
                else if(data == 'cancelled')
                {
                  return '<span class="badge bg-danger">'+data+'</span>';
                }
                              
              }
          },
          {
            "targets": 8,
            "render": function ( data, type, object ) {
                // console.log(object);
                if(object.status == 'pending')
                { 
                  @can('diagnosis-create')
                    return data;
                  @else
                    return '';
                  @endcan
                }
                else
                { 
                  return '<a href="diagnosis/edit/'+object.ps_items_id+'" class="btn btn-sm btn-info" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
                }                 
              }
          }

        ]
        // "bSort" : false 
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
      
      //PUSHER - refresh data when table patient_services or patient_service_items has changes or diagnosis has created
      if(data.action == 'create-patient' || data.action == 'edit-patient' || data.action == 'delete-patient' || data.action == 'create-diagnosis' ||
         data.action == 'create-patient-services' || data.action == 'edit-patient-services' || data.action == 'cancel-patient-services' || 
         data.action == 'edit-service-amount')
      { 
        $('#patient-table').DataTable().ajax.reload()
      }

    });

	});

</script>

@endsection

