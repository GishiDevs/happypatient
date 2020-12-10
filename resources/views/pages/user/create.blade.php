
@extends('layouts.main')
@section('title', 'Add User')
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
              <li class="breadcrumb-item active">Add User</li>
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
                <h3 class="card-title">Add User </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="userform">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="name">Full Name</label> <span class="text-danger">*</span>
                      <input type="text" id="name" type="text" class="form-control" name="name" required autofocus placeholder="Enter full name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="description">Description</label>
                      <textarea class="form-control" rows="3" placeholder="Enter description" name="description" id="description"></textarea>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="license">License</label>
                      <input type="text" id="license" type="text" class="form-control" name="license" placeholder="Enter license">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" placeholder="Enter email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="name">Username</label> <span class="text-danger">*</span>
                      <input type="text" id="username" type="text" class="form-control" name="username" required placeholder="Enter username">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="password">Password</label> <span class="text-danger">*</span>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="confirm_password">Confirm Password</label> <span class="text-danger">*</span>
                      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter confirm password">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="role">Role</label>
                      <select multiple class="custom-select" name="roles[]" id="roles">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="role">Signatory of:</label>
                      <select multiple class="custom-select" name="services[]" id="services">
                        @foreach($services as $service)
                        <option value="{{ $service->id }}">{{ $service->service }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" id="btn-add" class="btn btn-primary">Add</button>
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

  //User Form Validation
  $('#userform').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        email: true
      },
      username: {
        required: true,
      },
      password: {
        minlength: 8,
        required: true,
      },
      confirm_password: {
        required: true,
        equalTo: "#password",
      },
      
    },
    messages: {
      name: {
        required: "Please enter full name",
      },
      email: {
        email: "Please enter a valid email",
      },
      username: {
        required: "Please enter username",
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

      $('#btn-add').attr('disabled', true);

      var data = $('#userform').serializeArray();
      data.push({name: "_token", value: "{{ csrf_token() }}"});
      
      $.ajax({
        url: "{{ route('user.store') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#userform')[0].reset();
            // Sweet Alert
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Record has successfully added',
              showConfirmButton: false,
              timer: 2500
            });
          }

          $('#btn-save').removeAttr('disabled');
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

