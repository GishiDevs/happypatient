
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
                <table id="dashboard" class="table">
                  <thead>
                    <tr>
                      <!-- <th class="no-sort">#</th> -->
                      <th class="no-sort">ID</th>
                      <th class="no-sort">Patient Name</th>
                      <th class="no-sort">Service</th>
                      <th class="no-sort">Name</th>
                      <th class="no-sort">File #</th>
                      <th class="no-sort">Procedure</th>
                      <th width="50px" class="no-sort">Status</th>
                      <th width="150px" class="no-sort">Document Date</th>
                      <th width="150px" class="no-sort">Diagnose Date</th>
                      <th width="100px" class="no-sort">Actions</th>
                      <th>Queue</th>
                    </tr>
                  </thead>
                  <tbody>
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <!-- <th>#</th> -->
                      <th>ID</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Name</th>
                      <th>File#</th>
                      <th>Procedure</th>
                      <th>Status</th>
                      <th>Document Date</th>
                      <th>Diagnose Date</th>
                      <th>Actions</th>
                      <th>Queue</th>
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
    

    var patient_line_number = 0;
    var pending_ctr = 0;
    var diagnosed_ctr = 0;
    var total_items = 0;
    // if session has request to download pdf
    @if(Session::has('download_pdf'))
      // $(location).attr('href', "{{ route('diagnosis.print', session()->get('download_pdf'))}}");
    @endif

    dashboard_datatable();

		function dashboard_datatable()
    {
        var dt = $('#dashboard').DataTable({
          "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],
          "searching": true,
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "destroy": true,
          "serverSide": true,
          "ajax": "{{ route('patientservice.servicesperuser') }}",
          "bDestroy": true,
          "columns": [
                      // {
                      //   'className':      'details-control',
                      //   'orderable':      false,
                      //   'data':           null,
                      //   'defaultContent': ''
                      // },
                      // { "data": "DT_RowIndex"},
                      { "data": "id"},
                      { "data": "name"},
                      { "data": "service"},
                      { "data": "procedure"},
                      { "data": "file_no"},
                      { "data": "code"},
                      { "data": "status"},
                      { "data": "docdate"},
                      { "data": "diagnose_date"},
                      { "data": null},
                      { "data": 'queue_no'},

          ],
          order: [],
          rowGroup: {
              dataSrc: [ 'id' , 'name', 'service' ],

              startRender: function(rows, group, group_index) {

                var group_label = group;

                if(group_index == 0)
                { 
                  group_label = rows.data()[0]['queue_no'] + '. ' + rows.data()[0]['name'].toUpperCase() ;
                }

                $('.dtrg-level-1').remove();

                return group_label.bold();

              },

              endRender: function(rows, group, group_index) {
                // return null;
              },
          },
          columnDefs: [ 
            {
              targets: [ 0, 1, 2 , 10],
              visible: false
            },
            {
              targets: 'no-sort', orderable : false 
            },
            {
              targets: 3,
              render: function( data ) {
                return '';
              }
            },
            {
              targets: 6,
              render: function ( data ) {
                  if(data == 'diagnosed' || data == 'receipted')
                  {
                    return '<span class="badge bg-success">done</span>';
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
              targets: 9,
              render: function ( data , type, object ) {
                // console.log(object);
                if(object.status == 'pending')
                { 
                  @can('diagnosis-create')
                    if(object.service == 'Check-up')
                    {
                      return '<a href="diagnosis/create/'+object.ps_items_id+'"class="btn btn-xs btn-success" data-ps_items_id="'+object.ps_items_id+'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Receipt</a>';
                    }
                    else
                    {
                      return '<a href="diagnosis/create/'+object.ps_items_id+'"class="btn btn-xs btn-success" data-ps_items_id="'+object.ps_items_id+'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Diagnose</a>';
                    }
                    
                  @else
                    return '';
                  @endcan
                }
                else
                { 
                  @can('diagnosis-edit')
                    return '<a href="diagnosis/edit/'+object.ps_items_id+'" class="btn btn-xs btn-info" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
                  @else
                    return '';
                  @endcan
                }                 
              }
          }
          ]
          // "bSort" : false 
      });
    }
    
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
         data.action == 'edit-service-amount' || data.action == 'edit-procedure' || data.action == 'create-role' || data.action == 'edit-role' ||
         data.action == 'add-service-item' || data.action == 'remove-service-item' || data.action == 'edit-patient')
      { 

          $('#dashboard').DataTable().ajax.reload();

      }

    });

	});

</script>

@endsection

