
@extends('layouts.main')
@section('title', 'Permissions')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Permissions</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Permission Lists</li>
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
                <h3 class="card-title">Permission Lists</h3>
                @if(Auth::user()->hasPermissionTo('permission-create'))
                <a href="" id="btn-add-permission" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-permission">Add New</a>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="permission-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Permission</th>
                      @if(Auth::user()->hasRole('Admin'))
                      <th width="140px">Actions</th>
                      @endif
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>ID</th>
                      <th>Permission</th>
                      @if(Auth::user()->hasRole('Admin'))
                      <th>Actions</th>
                      @endif
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
<div class="modal fade" id="modal-permission">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="permissionform">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="permission">Permission</label> <span class="text-danger">*</span>
              <input type="text" name="permission" class="form-control" id="permission" placeholder="Enter permission" autofocus>
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
    var permissionid;
    var columns = [{ "data": "id"},
                   { "data": "name"}];
    if("{{ Auth::user()->hasRole('Admin') }}"){
      columns.push({data: "action"});
    }
			// $('#tax-table').DataTable();
	  $('#permission-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getpermissionrecord') }}",
		    "bDestroy": true,
		    "columns": columns,
		    
    });
    
    //Click Edit
    $('#btn-add-permission').click(function(e){
      $('#btn-save').attr('disabled', false);
      $('#permissionform')[0].reset();
      $('.modal-title').empty().append('Add permission');
      action_type = 'add'
    });

    //Click Edit
    $('#permission-table').on('click', 'tbody td #btn-edit-permission', function(e){
      $('#btn-save').attr('disabled', true);
      $('.modal-title').empty().append('Update Permission');
      action_type = 'update';
      permissionid = $(this).data('permissionid');

      $.ajax({
        url: "{{ route('permission.edit') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", permissionid: $(this).data('permissionid')},
        success: function(response){
          console.log(response);
          $('#permission').val(response.name);
        },
        error: function(response){
          console.log(response);
        }
      });

    });

    //Delete Patient
    $('#permission-table').on('click', 'tbody td #btn-delete-permission', function(e){

      e.preventDefault();

      var permissionid = $(this).data('permissionid');

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
            url: "{{ route('permission.delete') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", permissionid: permissionid},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#permission-table').DataTable().ajax.reload();
              }
            },
            error: function(response){
              console.log(response);
            }
          });

        }
      });
    });

    //permission Form Validation
  $('#permissionform').validate({
    rules: {
      permission: {
        required: true,
      },
      
    },
    messages: {
      permission: {
        required: "Please enter permission",
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
      
      if(action_type == 'add')
      {
        addpermission();
      }
      else
      {
        updatepermission();
      }

    }
  });
    
  function addpermission(){
    
    var data = $('#permissionform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});

    $.ajax({
        url: "{{ route('permission.store') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#permissionform')[0].reset();
            // Sweet Alert
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
            });
            $('#permission-table').DataTable().ajax.reload();
            $('#modal-permission').modal('toggle');
          }
          else
          {
            $('#permission').addClass('is-invalid');
            $('#permission').after('<span id="permission-error" class="error invalid-feedback">'+ response.permission +'</span>');
          }

        },
        error: function(response){
          console.log(response);
        }
      });
  } 

  function updatepermission(){
    var data = $('#permissionform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        data.push({name: "permissionid", value: permissionid});
        $.ajax({
            url: "{{ route('permission.update') }}",
            method: "POST",
            data: data,
            success: function(response){
                if(response.success)
                {   
                    $('#permissionform')[0].reset();
                    $('#permission-table').DataTable().ajax.reload();
                    Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Record has been updated',
                                showConfirmButton: false,
                                timer: 2500
                              });  
                    $('#modal-permission').modal('toggle');
                }   
                else
                {
                    $('#permission').addClass('is-invalid');
                    $('#permission').after('<span id="permission-error" class="error invalid-feedback">'+ response.permission +'</span>');
                }
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });
  } 
    $('#permissionform').on('change input',function(e){
      
      $('#btn-save').attr('disabled', false);
    
    });

    $('#btn-cancel').click(function(e){
          $('#permissionform')[0].reset();
    });
  
	});

</script>
@endsection

