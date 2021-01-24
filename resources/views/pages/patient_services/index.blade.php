
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
              <div class="row">
                <div class="col-md-12 d-flex justify-content-center mt-3">
                  <div class="form-group mr-5">
                    <label>Filter Date From:</label>
                    <div class="input-group date" id="filter-date-from" data-target-input="nearest">
                      <input type="text" id="date-from" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="MM/DD/YYYY" data-target="#filter-date-from" readonly/>
                      <div class="input-group-append" data-target="#filter-date-from" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Filter Date To:</label>
                    <div class="input-group date" id="filter-date-to" data-target-input="nearest">
                      <input type="text" id="date-to" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="MM/DD/YYYY" data-target="#filter-date-to" readonly/>
                        <div class="input-group-append" data-target="#filter-date-to" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table id="patient-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <th>ID</th>
                      <th>Document Date</th>
                      <!-- <th>OR Number</th> -->
                      <th>Patient/Organization</th>
                      <th width="50px">Cancelled</th>
                      <th width="50px" class="no-sort">Action</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Document Date</th>
                      <!-- <th>OR Number</th> -->
                      <th>Patient Name</th>
                      <th>Cancelled</th>
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

  $(document).ready(function() {

    $('#filter-date-from').datetimepicker({
        format: 'L',
        useCurrent: false,
        ignoreReadonly: true
        
    });

    $('#filter-date-to').datetimepicker({
        format: 'L',
        useCurrent: false,
        ignoreReadonly: true
    });

    $("#filter-date-from, #filter-date-to").on("change.datetimepicker", function(e){

      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();  

      // if date-from or date-to texfield has value
      if(date_from || date_to)
      { 
        patient_services(); 
      }
      
    });

    patient_services();

    function patient_services()
    {
      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();  
      
      $('#patient-table').DataTable({
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "serverSide": true,
          "ajax": {
            url: "{{ route('patientservice.serviceslist') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", date_from: date_from, date_to: date_to  },
            // success: function(response){
            //   console.log(response);
            // }
          },
          "bDestroy": true,
          "columns": [
                      { "data": "DT_RowIndex"},
                      { "data": "id"},
                      { "data": "docdate"},
                      // { "data": "or_number"},
                      { "data": "name"},
                      { "data": "cancelled"},
                      { "data": "action"}
          ],
          "order": [],
          "columnDefs": [{
                            "targets": "no-sort",
                            "orderable": false
                          },
                          { "visible": false, "targets": 1 },
                          // {
                          //   "targets": 6,
                          //   // "data": "status",
                          //   "render": function ( data ) {

                          //       if(data == 'diagnosed')
                          //       {
                          //         return '<span class="badge bg-success">'+data+'</span>';
                          //       }
                          //       else if(data == 'pending')
                          //       {
                          //         return '<span class="badge bg-warning">'+data+'</span>';
                          //       }
                          //       else if(data == 'cancelled')
                          //       {
                          //         return '<span class="badge bg-danger">'+data+'</span>';
                          //       }
                                
                          //   }
                          // }
                          ],
      });

    }

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
      
      //PUSHER - refresh data when table patient_services has changes
      if(data.action == 'edit-patient' || data.action == 'create-patient-services' || data.action == 'edit-patient-services' || data.action == 'add-service-item')
      {
        $('#patient-table').DataTable().ajax.reload()
      }

    });

	});

</script>
@endsection

