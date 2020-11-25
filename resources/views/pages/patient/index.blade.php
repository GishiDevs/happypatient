
@extends('layouts.main')
@section('title', 'Patient Record')
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
                @can('patient-create')
                <a href="{{ route('patient.create') }}" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patient-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <!-- <th>ID</th> -->
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Civil Status</th>
                      <th>Mobile</th>
                      @canany(['patient-edit','patient-delete'])
                      <th class="no-sort" width="110px">Actions</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <!-- <th>ID</th> -->
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Civil Status</th>
                      <th>Mobile</th>
                      @canany(['patient-edit','patient-delete','patient-history'])
                      <th>Actions</th>
                      @endcanany
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
                  //  { "data": "id"},
                   { "data": "lastname"},
                   { "data": "firstname"},
                   { "data": "middlename"},
                   { "data": "birthdate"},
                   { "data": "gender"},
                   { "data": "civilstatus"},
                   { "data": "mobile"}];

    @canany(['patient-edit', 'patient-delete'])
      columns.push({data: "action"});
    @endcanany

			// $('#tax-table').DataTable();
	  $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getpatientrecord') }}",
		    "bDestroy": true,
		    "columns": columns,
        // "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });
    
    //View Patient
    $('#patient-table').on('click', 'tbody td #btn-view-patient', function(e){
      
      var patientid = $(this).data('patientid');
      $('#view-text-patientid').val(patientid);
      $('#form-viewpatient').submit();

    });

    // //Edit Patient
    // $('#patient-table').on('click', 'tbody td #btn-edit-patient', function(e){
      
    //   var patientid = $(this).data('patientid');
    //   $('#edit-text-patientid').val(patientid);
    //   $('#form-editpatient').submit();

    // });

    //Delete Patient
    $('#patient-table').on('click', 'tbody td #btn-delete-patient', function(e){

      e.preventDefault();

      var patientid = $(this).data('patientid');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Delete record!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: "{{ route('patient.delete') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", patientid: patientid},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#patient-table').DataTable().ajax.reload();
              }
            },
            error: function(response){
              console.log(response);
            }
          });

        }
      });
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
      
      //PUSHER - refresh data when table patient has changes
      if(data.action == 'create-patient' || data.action == 'edit-patient' || data.action == 'delete-patient')
      {
        $('#patient-table').DataTable().ajax.reload()
      }

    });
    
	});

</script>
@endsection

