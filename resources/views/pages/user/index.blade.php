
@extends('layouts.main')
@section('title', 'User Record')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">User Record</li>
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
                <h3 class="card-title">User Record Lists</h3>
                @can('user-create')
                <a href="{{ route('user.create') }}" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="user-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Roles</th>
                      @canany(['user-edit','user-delete'])
                      <th width="140px" class="no-sort">Actions</th>
                      @endcanany
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Roles</th>
                      @canany(['user-edit','user-delete'])
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
                   { "data": "id"},
		    		       { "data": "name"},
		    		       { "data": "username"},
		    		       { "data": "email"},
		    		       { "data": "roles"}];

    @canany(['user-edit','user-delete'])
      columns.push({data: "action"});
    @endcanany
    
			// $('#tax-table').DataTable();
	  $('#user-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getuserrecord') }}",
		    "bDestroy": true,
		    "columns": columns,
        "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });
    
    //View user
    $('#user-table').on('click', 'tbody td #btn-view-user', function(e){
      
      var userid = $(this).data('userid');
      $('#view-text-userid').val(userid);
      $('#form-viewuser').submit();

    });

    //Edit user
    $('#user-table').on('click', 'tbody td #btn-edit-user', function(e){
      
      var userid = $(this).data('userid');
      $('#edit-text-userid').val(userid);
      $('#form-edituser').submit();

    });

    //Delete user
    $('#user-table').on('click', 'tbody td #btn-delete-user', function(e){

      e.preventDefault();

      var userid = $(this).data('userid');

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
            url: "{{ route('user.delete') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", userid: userid},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#user-table').DataTable().ajax.reload();
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
      
      //PUSHER - refresh data when table users has changes
      if(data.action == 'create-user' || data.action == 'edit-user' || data.action == 'delete-user')
      {
        $('#procedure-table').DataTable().ajax.reload()
      }

    });
    
	});

</script>
@endsection

