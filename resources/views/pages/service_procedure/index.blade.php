
@extends('layouts.main')
@section('title', 'Services')
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
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Service Procedure Record</li>
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
                <h3 class="card-title">Service Procedure Record</h3>
                @can('service-create')
                  <a href="{{ route('serviceprocedure.create') }}" id="btn-add-procedure" class="btn btn-primary float-right">Add New</a>
                @endcan
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('service-list')
                <table id="procedure-table" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <!-- <th>ID</th> -->
                      <th>Service</th>
                      <th>Code Name</th>
                      <th>Procedure</th>
                      <th>Price</th>
                      <th>To Diagnose</th>
                      <th>Multiple</th>
                      <th>Template Last Updated</th>
                      @canany(['serviceprocedure-edit','serviceprocedure-delete'])
                      <th width="200px" class="no-sort">Actions</th>
                      @endcan
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <!-- <th>ID</th> -->
                      <th>Service</th>
                      <th>Code Name</th>
                      <th>Procedure</th>
                      <th>Price</th>
                      <th>To Diagnose</th>
                      <th>Multiple</th>
                      <th>Template Last Updated</th>
                      @canany(['serviceprocedure-edit','serviceprocedure-delete'])
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
<!-- /.content-wrapper -->
<div class="modal fade" id="modal-procedure">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Update Procedure</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="serviceprocedureform">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="service">Service</label>
              <select class="form-control select2" name="service" id="service" style="width: 100%;">
                <option selected="selected" value="" disabled>Select Service</option>
                @foreach($services as $service)
                <option value="{{ $service->id }}" data-service="{{ $service->service }}">{{ $service->service }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="code">Code Name</label>
              <input type="text" name="code" class="form-control" id="code" placeholder="Enter code name">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="procedure">Procedure</label>
              <input type="text" name="procedure" class="form-control" id="procedure" placeholder="Enter procedure">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="price">Price</label>
              <input type="text" name="price" class="form-control" id="price" placeholder="0.00">
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" name="to_diagnose" type="checkbox" id="check-to-diagnose" value="Y">
                <label for="check-to-diagnose" class="custom-control-label">To Diagnose</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" name="is_multiple" type="checkbox" id="check-is-multiple" value="Y">
                <label for="check-is-multiple" class="custom-control-label">Multiple</label>
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
    var procedure_id;
    var columns = [{ "data": "DT_RowIndex"},
                  //  { "data": "id"},
                   { "data": "service"},
                   { "data": "code"},
                   { "data": "procedure"},
                   { "data": "price"},
                   { "data": "to_diagnose"},
                   { "data": "is_multiple"},
                   { "data": "template_last_update"}];

    @canany(['serviceprocedure-edit', 'serviceprocedure-delete'])
      columns.push({data: "action"});
    @endcanany
    
			// $('#tax-table').DataTable();
	  $('#procedure-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getprocedurerecord') }}",
		    "bDestroy": true,
		    "columns": columns,
        "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });

    // edit procedure
    $('#procedure-table').on('click', 'tbody td #btn-edit-procedure', function(e){
      e.preventDefault();
      
      $('#btn-save').removeAttr('disabled');

      procedure_id = $(this).data('procedureid');

      $.ajax({
        url: "{{ route('serviceprocedure.edit') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", procedure_id: $(this).data('procedureid')},
        success: function(response){
          console.log(response);

          $('#code').val(response.procedure.code);
          $('#procedure').val(response.procedure.procedure);
          $('#price').val(response.procedure.price);

          if(response.procedure.to_diagnose == 'Y')
          {
            $('#check-to-diagnose').prop('checked', true);
          }
          else
          {
            $('#check-to-diagnose').prop('checked', false);
          }

          if(response.procedure.is_multiple == 'Y')
          {
            $('#check-is-multiple').prop('checked', true);
          }
          else
          {
            $('#check-is-multiple').prop('checked', false);
          }
          
          // $('#service').find('option').each(function(){
          //     $(this).removeAttr('selected');
          // });

          // $('#service').find('option').each(function(){

          //   if($(this).val() == response.procedure.serviceid)
          //   { 
          //     $('#select2-service-container').empty().append(response.procedure.service);
          //     $(this).attr('selected', 'selected');
          //   }
          // });

          $('#service').empty().append('<option selected="selected" value="" disabled>Select Service</option>');

          var selected = '';  

          @foreach($services as $service)

            if('{{ $service->id }}' == response.procedure.serviceid)
            { 
              selected = 'selected';
            }
            else
            {
              selected = '';
            }
            $('#service').append('<option value="{{ $service->id }}" data-service="{{ $service->service }}" '+selected+'> {{ $service->service }}</option>');

          @endforeach

        },
        error: function(response){
          console.log(response);
        }
      });

      $('#modal-procedure').modal('toggle');
    });

    //Delete Patient
    $('#procedure-table').on('click', 'tbody td #btn-delete-procedure', function(e){

      e.preventDefault();

      procedure_id = $(this).data('procedureid');

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
            url: "{{ route('serviceprocedure.delete') }}",
            method: "POST",
            data: {_token: "{{ csrf_token() }}", procedure_id: procedure_id},
            success: function(response){
              console.log(response);
              if(response.success)
              {
                Swal.fire(
                  'Deleted!',
                  'Record has been deleted.',
                  'success'
                );
                $('#procedure-table').DataTable().ajax.reload();
              }
            },
            error: function(response){
              console.log(response);
            }
          });

        }
      });
    });

    $('#btn-save').click(function(e){
      
      $(this).attr('disabled', true);

      var data = $('#serviceprocedureform').serializeArray();
      data.push({name: "_token", value: "{{ csrf_token() }}"});
      data.push({name: "procedure_id", value: procedure_id});

      e.preventDefault();
      $.ajax({
        url: "{{ route('serviceprocedure.update') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#select2-service-container').empty().append('Select Service');
            $('#serviceprocedureform')[0].reset();
            $('#procedure-table').DataTable().ajax.reload();
            Swal.fire({
                       position: 'center',
                       icon: 'success',
                       title: 'Record has been updated',
                       showConfirmButton: false,
                       timer: 2500
                      });  
            $('#modal-procedure').modal('toggle');
          }

          $(this).removeAttr('disabled');

        },
        error: function(response){
          console.log(response);
        }
      });
    });
    

    $('[name="price"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });

    $('.select2').select2();

    $('#btn-cancel').click(function(e){
        $('#select2-service-container').empty().append('Select Service');
        $('#serviceprocedureform')[0].reset();
    });

    $('#price').on('keyup', function(){
      if($(this).val() == 0)
      {
        $('#btn-save').attr('disabled', true);
      }
      else
      {
        $('#btn-save').removeAttr('disabled');
      }
      
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
      
      //PUSHER - refresh data when table service_procedures has changes
      if(data.action == 'create-procedure' || data.action == 'edit-procedure' || data.action == 'delete-procedure' || data.action == 'edit-role')
      {
        $('#procedure-table').DataTable().ajax.reload()
      }

    });

  });
</script>
@endsection

