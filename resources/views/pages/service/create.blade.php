
@extends('layouts.main')
@section('title', 'Add Service')
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
              <li class="breadcrumb-item"><a href="{{ route('patientrecord') }}">Home</a></li>
              <li class="breadcrumb-item active">Add Service</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Service</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="serviceform">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="lastname">Service</label> <span class="text-danger">*</span>
                      <input type="text" name="service" class="form-control" id="service" placeholder="Enter service">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="status-active" name="status" value="active" checked>
                          <label for="active" class="custom-control-label">Active</label>
                        </div>
                        <div class="custom-control custom-radio">
                          <input class="custom-control-input" type="radio" id="status-inactive" name="status" value="inactive">
                          <label for="inactive" class="custom-control-label">Inactive</label>
                        </div>
                      </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">

$(document).ready(function () {

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
  });

});
</script>
@endsection

