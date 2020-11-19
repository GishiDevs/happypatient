
@extends('layouts.main')
@section('title', 'Roles')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Roles</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Role Lists</li>
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
                <h3 class="card-title">Role Lists</h3>
                <a href="" id="btn-add-role" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-role">Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('role-list')
                <table id="role-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                        <th width="30px" class="no-sort">#</th>
                        <!-- <th>ID</th> -->
                        <th>Role</th>
                        @canany(['role-edit','role-delete'])
                        <th width="140px" class="no-sort">Actions</th>
                        @endcanany
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                        <th>#</th>
                        <!-- <th>ID</th> -->
                        <th>Role</th>
                        @canany(['role-edit','role-delete'])
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
<div class="modal fade" id="modal-role">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="roleform">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="role">Role</label> <span class="text-danger">*</span>
              <input type="text" name="role" class="form-control" id="role" placeholder="Enter role" autofocus>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="selectPatient">Permission</label>
              <div class="form-group">
                <div class="row">
                @foreach($permissions as $permission)               
                  <div class="col-md-6">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" name="permission[]" type="checkbox" id="checkbox-permissionid-{{ $permission->id }}" value="{{ $permission->id }}">
                      <label for="checkbox-permissionid-{{ $permission->id }}" class="custom-control-label">{{ $permission->name }}</label>
                    </div>
                  </div>
                @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="modal-footer">
          <button type="reset" id="btn-cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="btn-save" class="btn btn-primary">Save</button> 
        </div>
      </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script>

  $(document).ready(function() {
    
    var action_type;
    var roleid;
    var columns = [{ "data": "DT_RowIndex"},
                  //  { "data": "id"},
                   { "data": "name"}];
                  
    @canany(['role-edit','role-delete'])
      columns.push({data: "action"});
    @endcanany

			// $('#tax-table').DataTable();
	  $('#role-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getrolerecord') }}",
		    "bDestroy": true,
		    "columns": columns,
        "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });
    
    //Click Edit
    $('#btn-add-role').click(function(e){
      uncheckpermission();
      $('#btn-save').attr('disabled', false);
      $('#roleform')[0].reset();
      $('.modal-title').empty().append('Add role');
      action_type = 'add';
    });

    //Click Edit
    $('#role-table').on('click', 'tbody td #btn-edit-role', function(e){

      $('#btn-save').attr('disabled', true);
      $('.modal-title').empty().append('Update Role');
      action_type = 'update';
      roleid = $(this).data('roleid');

      $.ajax({
        url: "{{ route('role.edit') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", roleid: $(this).data('roleid')},
        success: function(response){
          console.log(response);

          $('#role').val(response.role.name);
          
          //check all permission
          $.each(response.rolePermissions, function(i){
            $('#checkbox-permissionid-'+response.rolePermissions[i]).attr('checked', true);
          });

        },
        error: function(response){
          console.log(response);
        }
      });

    });

    //Delete Patient
    $('#role-table').on('click', 'tbody td #btn-delete-role', function(e){

      e.preventDefault();

      var roleid = $(this).data('roleid');

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
            url: "{{ route('role.delete') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", roleid: roleid},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#role-table').DataTable().ajax.reload();
              }
              else
              {
                Swal.fire(
                  'Error!',
                   response.error,
                  'error'
                );
              }
            },
            error: function(response){
              console.log(response);
            }
          });

        }
      });
    });

    //role Form Validation
  $('#roleform').validate({
    rules: {
      role: {
        required: true,
      },
      
    },
    messages: {
      role: {
        required: "Please enter role",
      },
     
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    submitHandler: function(e){
      
      $('#btn-save').attr('disabled', true);

      if(action_type == 'add')
      {
        addrole();
      }
      else
      {
        updaterole();
      }

      uncheckpermission();
      
    }
  });
    
  function addrole(){
    
    var data = $('#roleform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});

    $.ajax({
        url: "{{ route('role.store') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#roleform')[0].reset();
            // Sweet Alert
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
            });
            $('#role-table').DataTable().ajax.reload();
            $('#modal-role').modal('toggle');
            
          }
          else
          {
            $('#role').addClass('is-invalid');
            $('#role').after('<span id="role-error" class="error invalid-feedback">'+ response.role +'</span>');
          }

          $('#btn-save').removeAttr('disabled');

        },
        error: function(response){
          console.log(response);
        }
      });
  } 

  function updaterole(){
    var data = $('#roleform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        data.push({name: "roleid", value: roleid});
        $.ajax({
            url: "{{ route('role.update') }}",
            method: "POST",
            data: data,
            success: function(response){
                if(response.success)
                {   
                    $('#roleform')[0].reset();
                    $('#role-table').DataTable().ajax.reload();
                    Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Record has been updated',
                                showConfirmButton: false,
                                timer: 2500
                              });  
                    $('#modal-role').modal('toggle');
                    $('#btn-save').removeAttr('disabled');
                }   
                else
                {
                    $('#role').addClass('is-invalid');
                    $('#role').after('<span id="role-error" class="error invalid-feedback">'+ response.role +'</span>');
                }
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });
  } 
    $('#roleform').on('change input',function(e){
      
      $('#btn-save').attr('disabled', false);
    
    });

    $('#btn-cancel').click(function(e){
        $('#roleform')[0].reset();
        uncheckpermission();
    });

    $('.close').click(function(e){
        $('#roleform')[0].reset();
        uncheckpermission();
    });

    function uncheckpermission()
    {
      $('[name="permission[]"]').each(function(){
          $(this).attr('checked', false);
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
      
      //PUSHER - refresh data when table roles has changes
      if(data.action == 'create-role' || data.action == 'edit-role' || data.action == 'delete-role')
      {
        $('#role-table').DataTable().ajax.reload()
      }

    });
  
	});
  
</script>
@endsection

