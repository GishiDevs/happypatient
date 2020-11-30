
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
                <table id="patient-table" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th></th>
                      <th class="no-sort">ID</th>
                      <th class="no-sort">Patient Name</th>
                      <th class="no-sort">Document Date</th>
                      <th class="no-sort">Service</th>
                      <!-- <th class="no-sort">Procedure</th>
                      <th width="50px" class="no-sort">Status</th>
                      <th class="no-sort">Diagnose Date</th>
                      <th width="100px" class="no-sort">Actions</th> -->
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>ID</th>
                      <th>Patient Name</th>
                      <th>Document Date</th>
                      <th>Service</th>
                      <!-- <th>Procedure</th>
                      <th>Status</th>
                      <th>Diagnose Date</th>
                      <th>Actions</th> -->
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
      // $(location).attr('href', "{{ route('diagnosis.print', session()->get('download_pdf'))}}");
    @endif

			// $('#tax-table').DataTable();
    var dt = $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('patientservice.servicesperuser') }}",
		    "bDestroy": true,
		    "columns": [
                    {
                      'className':      'details-control',
                      'orderable':      false,
                      'data':           null,
                      'defaultContent': ''
                    },
                    // { "data": "DT_RowIndex"},
                    { "data": "id"},
                    { "data": "name"},
		    		        { "data": "docdate"},
		    		        { "data": "service"},
        //             { "data": "procedure"},
        //             { "data": "status"},
        //             { "data": "diagnose_date"},
        //             { "data": "action"}
		    ],
        // "order": [[ 6, "desc" ],
        //           [ 2, "asc" ], 
        //           [ 4, "asc" ], 
        //           [ 1, "asc" ],
        //           [ 5, "asc" ],
        //           [ 3, "asc" ]
        // ],
        "order": [[ 1, "desc" ]],
        "columnDefs": [
          { "visible": false, "targets": 1 },
          { "targets": "no-sort","orderable": false },
        ]
        // "columnDefs": [
        //   { "visible": false, "targets": 1 },
        //   { "targets": "no-sort","orderable": false },
        //   {
        //     "targets": 6,
        //     "render": function ( data ) {
        //         if(data == 'diagnosed' || data == 'receipted')
        //         {
        //           return '<span class="badge bg-success">'+data+'</span>';
        //         }
        //         else if(data == 'pending')
        //         {
        //           return '<span class="badge bg-warning">'+data+'</span>';
        //         }
        //         else if(data == 'cancelled')
        //         {
        //           return '<span class="badge bg-danger">'+data+'</span>';
        //         }
                              
        //       }
        //   },
        //   {
        //     "targets": 8,
        //     "render": function ( data, type, object ) {
        //         // console.log(object);
        //         if(object.status == 'pending')
        //         { 
        //           @can('diagnosis-create')
        //             if(object.service == 'Check-up')
        //             {
        //               return '<a href="diagnosis/create/'+object.ps_items_id+'"class="btn btn-sm btn-success" data-ps_items_id="'+object.ps_items_id+'" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Receipt</a>';
        //             }
        //             else
        //             {
        //               return data;
        //             }
                    
        //           @else
        //             return '';
        //           @endcan
        //         }
        //         else
        //         { 
        //           return '<a href="diagnosis/edit/'+object.ps_items_id+'" class="btn btn-sm btn-info" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
        //         }                 
        //       }
        //   }

        // ]
        // "bSort" : false 
    });

    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#patient-table tbody').on( 'click', 'tr td.details-control', function () {
      
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
        }
        else {
            tr.addClass( 'details' );
            // row.child( get_services( row.data() ) ).show();

            var ps_id = row.data().id;
            var service_id = row.data().service_id;
            var procedures = '';
            
            @foreach($patient_service_items as $item)

              var btn_action_text = 'Diagnose';
              var diagnose_date = '{{ $item->diagnose_date }}';

              if('{{ $item->service }}' == 'Check-up')
              {
                btn_action_text = 'Receipt';
              }

              var badge_class = 'bg-warning';
              var action = '';


              //if use has permission
              @can('diagnosis-create')
                action = '<a href="{{ route("diagnosis.create", $item->ps_items_id) }}" class="btn btn-xs btn-success" data-ps_items_id="{{ $item->ps_items_id }}" data-action="create" id="btn-create-diagnosis"><i class="fa fa-edit"></i> '+btn_action_text+'</a>';
              @endcan
              

              if('{{ $item->status }}' == 'diagnosed' || '{{ $item->status }}' == 'receipted')
              { 
                badge_class = 'bg-success';
                action = '<a href="{{ route("diagnosis.edit", $item->ps_items_id) }}" class="btn btn-xs btn-info" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>';
              }   

              if(!'{{ $item->diagnose_date }}')
              {
                diagnose_date = '';
              }

              if('{{ $item->id }}' == ps_id && '{{ $item->serviceid }}' == service_id)
              {
                procedures += '<tr style="background: white;" >'+
                                '<td>{{ $item->procedure }}</td>'+
                                '<td><span class="badge '+badge_class+'">{{ $item->status }}</span></td>'+
                                '<td>'+diagnose_date+'</td>'+
                                '<td>'+action+'</td>'+
                              '</tr>';
              }

            @endforeach

            row.child('<table class="table table-hover">'+
                        '<thead>'+
                          '<th>Procedure</th>'+
                          '<th width="100px">Status</th>'+
                          '<th width="100px">Date</th>'+
                          '<th width="100px">Actions</th>'+
                        '</thead>'+
                        '<tbody>'+procedures+'</tbody>'+
                      '</table>'
                      ).show(); 

            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    // dt.on( 'draw', function () {
    //     $.each( detailRows, function ( i, id ) {
    //         $('#'+id+' td.details-control').trigger( 'click' );
    //     } );
    // } );

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
         data.action == 'edit-service-amount' || data.action == 'edit-procedure')
      { 
        $('#patient-table').DataTable().ajax.reload()
      }

    });

	});

</script>

@endsection

