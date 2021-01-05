
@extends('layouts.main')
@section('title', 'File No Setting')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>File No Setting</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">File No Setting</li>
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
                <h3 class="card-title">File No Setting</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                @can('service-list')
                <table id="file-setting-no-table" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th width="30px" class="no-sort">#</th>
                      <!-- <th>ID</th> -->
                      <th>Service</th>
                      <th>Year</th>
                      <th>File No Start</th>
                      <!-- <th>File End Start</th> -->
                      <th>Status</th>
                      @canany(['service-edit','service-delete'])
                      <th width="110px" class="no-sort">Actions</th>
                      @endcan
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <!-- <th>ID</th> -->
                      <th>Service</th>
                      <th>Year</th>
                      <th>File No Start</th>
                      <!-- <th>File End Start</th> -->
                      <th>Status</th>
                      @canany(['service-edit','service-delete'])
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
<div class="modal fade" id="modal-file-no-setting">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Set File Number</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="file-setting-no-form">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="service" class="mr-2">Service: </label>
              <span id="service"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <label for="service" class="mr-2">File No Start: </label>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-12">
              <input type="text" name="start" class="form-control" id="start" placeholder="00000" maxlength="5" autofocus>
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

    $("#start").inputmask('integer',{min:1, max:99999});

    var action_type;
    var serviceid;
    var columns = [{ "data": "DT_RowIndex"},
                  //  { "data": "id"},
                   { "data": "service"},
                   { "data": "year"},
                   { "data": "start"},
                  //  { "data": "end"},
                   { "data": "status"}];

    @canany(['service-edit', 'service-delete'])
      columns.push({data: "action"});
    @endcanany
    
			// $('#tax-table').DataTable();
	  $('#file-setting-no-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('getsettings') }}",
		    "bDestroy": true,
		    "columns": columns,
        "order": [ 1, "asc" ],
        "columnDefs": [{
                          "targets": "no-sort",
                          "orderable": false
                        }] 
    });
    

    //Click Edit
    $('#file-setting-no-table').on('click', 'tbody td #btn-edit-setting', function(e){
      $('#btn-save').attr('disabled', true);

      serviceid = $(this).data('serviceid');

      $.ajax({
        url: "{{ route('file_no_setting.edit') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", serviceid: $(this).data('serviceid')},
        success: function(response){
          console.log(response);
          $('#service').empty().append('<strong>'+response.service+'</strong>');
          $('#start').val(response.start)
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

    //Service Form Validation
  $('#file-setting-no-form').validate({
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

      $('#btn-save').attr('disabled', true);

      var data = $('#file-setting-no-form').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        data.push({name: "serviceid", value: serviceid});
        $.ajax({
            url: "{{ route('file_no_setting.update') }}",
            method: "POST",
            data: data,
            success: function(response){
                if(response.success)
                {   
                    $('#file-setting-no-form')[0].reset();
                    $('#file-setting-no-table').DataTable().ajax.reload();
                    Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Record has been updated',
                                showConfirmButton: false,
                                timer: 2500
                              });  
                    $('#modal-file-no-setting').modal('toggle');
                }   
                else
                {

                }
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });

    }
  });
    
    $('#file-setting-no-form').on('change input',function(e){
      
      $('#btn-save').attr('disabled', false);
    
    });

    $('#btn-cancel').click(function(e){
        $('#file-setting-no-form')[0].reset();
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
      
      //PUSHER - refresh data when table services has changes
      if(data.action == 'create-service' || data.action == 'edit-service' || data.action == 'delete-service')
      {
        $('#file-setting-no-table').DataTable().ajax.reload()
      }

    });

});

</script>
@endsection

