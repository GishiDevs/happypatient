
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
                      <th>ID</th>
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Weight (Kg)</th>
                      <th>Mobile</th>
                      @can('patient-edit','patient-delete')
                      <th width="140px">Actions</th>
                      @endcan
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Lastname</th>
                      <th>Firstname</th>
                      <th>Middlename</th>
                      <th>Birthdate</th>
                      <th>Gender</th>
                      <th>Weight (Kg)</th>
                      <th>Mobile</th>
                      @can('patient-edit','patient-delete')
                      <th>Actions</th>
                      @endcan
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
    var columns = [{ "data": "id"},
                   { "data": "lastname"},
                   { "data": "firstname"},
                   { "data": "middlename"},
                   { "data": "birthdate"},
                   { "data": "gender"},
                   { "data": "weight"},
                   { "data": "mobile"}];

    if("{{ Auth::user()->hasPermissionTo('patient-edit') }}" || "{{ Auth::user()->hasPermissionTo('patient-delete') }}"){
      columns.push({data: "action"});
    }

			// $('#tax-table').DataTable();
	  $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getpatientrecord') }}",
		    "bDestroy": true,
		    "columns": columns,
    });
    
    //View Patient
    $('#patient-table').on('click', 'tbody td #btn-view-patient', function(e){
      
      var patientid = $(this).data('patientid');
      $('#view-text-patientid').val(patientid);
      $('#form-viewpatient').submit();

    });

    //Edit Patient
    $('#patient-table').on('click', 'tbody td #btn-edit-patient', function(e){
      
      var patientid = $(this).data('patientid');
      $('#edit-text-patientid').val(patientid);
      $('#form-editpatient').submit();

    });

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
    
	});

</script>
@endsection

