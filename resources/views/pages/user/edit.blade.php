
@extends('layouts.main')
@section('title', 'Update User')
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
              <li class="breadcrumb-item"><a href="{{ route('patient.index') }}">Home</a></li>
              <li class="breadcrumb-item active">Update User</li>
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
                <h3 class="card-title">Update User </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="userform" method="POST" action="{{ route('user.update', $user->id) }}">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="name">Full Name</label> <span class="text-danger">*</span>
                      <input type="text" id="name" type="text" class="form-control" name="name" value="{{ $user->name }}" required autofocus placeholder="Enter full name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="email">Email</label>
                      <input id="email" type="email" class="form-control" name="email" value="{{ $user->email }}" placeholder="Enter email">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="name">Username</label>
                      <input type="text" id="username" type="text" class="form-control" name="username" value="{{ $user->username }}" readonly required placeholder="Enter username">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="password">Password</label>
                      <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                  </div> 
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="confirm_password">Confirm Password</label>
                      <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Enter confirm password">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="role">Role</label>
                      <select multiple class="custom-select" name="roles[]" id="roles">
                        @foreach($roles as $role)
                        <option value="{{ $role }}" @if(in_array($role,$userRole)) selected @endif>{{ $role }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" id="btn-submit" class="btn btn-primary" disabled>Update</button>
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
        // required: true,
      },
      confirm_password: {
        // required: true,
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

      Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Record has been updated',
            showConfirmButton: false,
            timer: 2500
          });
      return true;
    }
  });
  $('#userform').on('change input',function(e){
    
    $('#btn-submit').attr('disabled', false);
   
  });

});
</script>
@endsection

