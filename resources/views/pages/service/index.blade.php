
@extends('layouts.main')
@section('title', 'Add Patient')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('patientrecord') }}">Home</a></li>
              <li class="breadcrumb-item active">Service Record Lists</li>
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
                <h3 class="card-title">Service Record Lists</h3>
                <a href="" id="btn-add-service" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-service">Add New</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="service-table" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th width="150px">Actions</th>
                  </tr>
                  </thead>
                  <tfoot>
                  <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Status</th>
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
    <!-- /.content -->
  </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<div class="modal fade" id="modal-service">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="serviceform">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="lastname">Service</label> <span class="text-danger">*</span>
              <input type="text" name="service" class="form-control" id="service" placeholder="Enter service">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="status-active" name="status" value="active" checked>
                  <label for="status-active" class="custom-control-label">Active</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="status-inactive" name="status" value="inactive">
                  <label for="status-inactive" class="custom-control-label">Inactive</label>
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
    var serviceid;
			// $('#tax-table').DataTable();
	  $('#service-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getservicerecord') }}",
		    "bDestroy": true,
		    "columns": [
                    { "data": "id"},
		    		{ "data": "service"},
		    		{ "data": "status"},
		    		{ "data": "action", orderable: false, searchable: false}
		    ]
    });
    
    //Click Edit
    $('#btn-add-service').click(function(e){
      $('#serviceform')[0].reset();
      $('.modal-title').empty().append('Add Service');
      action_type = 'add'
    });

    //Click Edit
    $('#service-table').on('click', 'tbody td #btn-edit-service', function(e){
      $('.modal-title').empty().append('Update Service');
      action_type = 'update';
      serviceid = $(this).data('serviceid');

      $.ajax({
        url: "{{ route('editservice') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", serviceid: $(this).data('serviceid')},
        success: function(response){
          console.log(response);
          $('#service').val(response.service);
          if(response.status == 'active')
          { 
            $('#status-inactive').removeAttr('checked');
            $('#status-active').attr('checked', true);
          }
          else
          {
            $('#status-active').removeAttr('checked');
            $('#status-inactive').attr('checked', true);
          }
        },
        error: function(response){
          console.log(response);
        }
      });

    });

    //Delete Patient
    $('#service-table').on('click', 'tbody td #btn-delete-service', function(e){

      e.preventDefault();

      var serviceid = $(this).data('serviceid');

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
            url: "{{ route('deleteservice') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", serviceid: serviceid},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#service-table').DataTable().ajax.reload();
              }
            },
            error: function(response){
              console.log(response);
            }
          });

        }
      });
    });

    //Service Form Validation
  $('#serviceform').validate({
    rules: {
      service: {
        required: true,
      },
      
    },
    messages: {
      service: {
        required: "Please enter service",
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
        addservice();
      }
      else
      {
        updateservice();
      }

    }
  });
    
  function addservice(){
    
    var data = $('#serviceform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});

    $.ajax({
        url: "{{ route('storeservice') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#serviceform')[0].reset();
            // Sweet Alert
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
            });
            $('#service-table').DataTable().ajax.reload();
            $('#modal-service').modal('toggle');
          }
          else
          {
            $('#service').addClass('is-invalid');
            $('#service').after('<span id="service-error" class="error invalid-feedback">'+ response.service +'</span>');
          }

        },
        error: function(response){
          console.log(response);
        }
      });
  } 

  function updateservice(){
    var data = $('#patientserviceform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        data.push({name: "serviceid", value: serviceid});
        $.ajax({
            url: "{{ route('updateservice') }}",
            method: "POST",
            data: data,
            success: function(response){
                if(response.success)
                {   
                    $('#serviceform')[0].reset();
                    $('#service-table').DataTable().ajax.reload();
                    Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Record has been updated',
                                showConfirmButton: false,
                                timer: 2500
                              });  
                    $('#modal-service').modal('toggle');
                }   
                else
                {
                    $('#service').addClass('is-invalid');
                    $('#service').after('<span id="service-error" class="error invalid-feedback">'+ response.service +'</span>');
                }
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });
  } 
  
	});

</script>
@endsection

