
@extends('layouts.main')
@section('title', 'Add Patient')
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
              <li class="breadcrumb-item active">Add Patient</li>
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
                <h3 class="card-title">Add Patient</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="patientform">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="lastname">Lastname</label> <span class="text-danger">*</span>
                      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter lastname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="firstname">Firstname</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter firstname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="middlename">Middlename</label>
                      <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter middlename">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="birthdate">Birthdate</label> <span class="text-danger">*</span>
                      <!-- <div id="datetimepicker-birthdate" class="input-group date" data-target-input="nearest">
                        <div class="input-group-append" data-target="#datetimepicker-birthdate" data-toggle="datetimepicker">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control datetimepicker-input" name="birthdate" id="birthdate" data-target="#datetimepicker-birthdate" placeholder="MM/DD/YYYY" readonly>
                      </div> -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="birthdate" id="birthdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy">
                      </div>
                    </div>
                    
                    <!-- <div class="form-group col-md-3">
                      <label for="age">Age</label>
                      <input type="text" class="form-control" name="age" id="age" readonly>
                    </div> -->
                    <div class="form-group col-md-3">
                      <label for="weight">Weight</label> <span class="text-danger">*</span>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" placeholder="0.00">
                        <div class="input-group-append">
                          <span class="input-group-text">Kg</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="gender">Gender</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-male" value="male" checked>
                        <label class="form-check-label" for="gender-male">Male</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-female" value="female">
                        <label class="form-check-label" for="gender-female">Female</label>
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="landline">Landline</label>
                      <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fa fa-phone"></i>
                          </span>
                        </div>
                        <input class="form-control" type="text" name="landline" id="landline" data-inputmask='"mask": "(999)999-9999"' data-mask>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="mobile">Mobile No.</label>
                      <div class="input-group">
                        <div class="input-group-append">
                          <span class="input-group-text">
                            <i class="fa fa-mobile"></i>
                          </span>
                        </div>
                        <input class="form-control" type="text" name="mobile" id="mobile" data-inputmask='"mask": "(+63)999-9999-999"' data-mask>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="email">Email address</label>
                      <input class="form-control" type="email" name="email" id="email" placeholder="Enter email">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="address">House/Unit/Flr #, Bldg Name, Blk/Lot #, Street Name</label>
                      <input class="form-control" type="text" name="address" id="address">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="province">Province</label> <span class="text-danger">*</span>
                      <select class="form-control select2" name="province" id="province" style="width: 100%;">
                      </select>
                    </div>
                    <div class="form-group col-md-4"> 
                      <label for="city">City/Town</label> <span class="text-danger">*</span>
                      <select class="form-control select2" name="city" id="city" style="width: 100%;" disabled>
                      </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="barangay">Barangay</label> <span class="text-danger">*</span>
                      <select class="form-control select2" name="barangay" id="barangay" style="width: 100%;" disabled>
                      </select>
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

  $('[data-mask]').inputmask();

  $('#city').empty().attr('disabled',true);
  $('#barangay').empty().attr('disabled',true);
  
  //Date range picker
  $('#datetimepicker-birthdate').datetimepicker({
        format: 'L',
        useCurrent: false,
        ignoreReadonly: true,
        maxDate: new Date
        
    });

  // $("#datetimepicker-birthdate").on("change.datetimepicker", function(e){
  //     var dob = $('#birthdate').val();
  //     var birthdate = dob.split('/');
  //     var bdate = birthdate[2] + '-' + birthdate[0] + '-' + birthdate[1];
  //     var month = moment().diff(moment(bdate, 'YYYY-MM-DD'), 'month');
  //     var age = moment().diff(moment(bdate, 'YYYY-MM-DD'), 'year');

  //     if(age == 0)
  //     {
  //       $('#age').val(age + '');
  //     }  
  // });

  $('.select2').select2();
  
  getprovinces();

  function getprovinces()
  {
    $.ajax({
      url: "{{ route('getprovinces') }}",
      method: "GET",
      success: function(response){

        console.log(response);

        $('#province').empty().append('<option value="" selected disabled>Select a Province</option>');
        
        $.each(response, function(index, value){
          $('#province').append('<option value="'+ value.province_id +'">'+ value.name +'</option>');
        });
      },
      error: function(response){
        console.log(response);
      }
    });
  }
  

  $('#province').on('change', function(e){

    $("[aria-labelledby='select2-province-container']").removeAttr('style');
    $('#province-error').remove();

    $.ajax({
      url: "{{ route('getcities') }}",
      method: "POST",
      data: { _token: '{{ csrf_token() }}', province_id: $(this).val() },
      success:function(response){
        console.log(response);

        $('#city').empty().attr('disabled',false);
        $('#barangay').empty().attr('disabled',false);

        var city_id;

        $.each(response.cities, function( index, value ) {
          $('#city').append('<option value="'+ value.city_id +'">'+ value.name +'</option>');
        });

        $.each(response.barangays, function(index, value){
          $('#barangay').append('<option value="'+ value.id +'">'+ value.name +'</option>');
        });

      },
      error:function(response){
        console.log(response);
      }
    });

  });

  $('#city').on('change', function(e){
    $.ajax({
      url: "{{ route('getbarangays') }}",
      method: "POST",
      data: { _token: "{{ csrf_token() }}", city_id: $(this).val() },
      success: function(response){

        console.log(response);

        $('#barangay').empty().attr('disabled',false);

        $.each(response, function(index, value){
          $('#barangay').append('<option value="'+ value.id +'">'+ value.name +'</option>');
        });

      },
      error:function(response){
        console.log(response);
      }
    });
  });

  //Patient Form Validation
  $('#patientform').validate({
    rules: {
      firstname: {
        required: true,
      },
      lastname: {
        required: true,
      },
      birthdate: {
        required: true,
        date: true,
        // dateFormat: true,
      },
      weight: {
        number: true,
        required: true,
      },
      // landline: {
      //   minlength: 2,
      // },
      // mobile: {
      //   number: true,
      // },
      email: {
        email: true
      },
      province: {
        required: true,
      },
    },
    messages: {
      firstname: {
        required: "Please enter firstname",
      },
      lastname: {
        required: "Please enter lastname",
      },
      birthdate: {
        required: "Please enter birthdate",
      },
      weight: {
        required: "Please enter weight",
        number: "Please enter a valid value",
      },
      province: {
        required: "Please select province"
      },
      email: {
        email: "Please enter a valid email"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
      if ($(element).hasClass('select2'))
      { 
        $(element).closest(".form-group").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger'); 
      }
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    submitHandler: function(e){

      var data = $('#patientform').serializeArray();
      data.push({name: "_token", value: "{{ csrf_token() }}"});
      
      $.ajax({
        url: "{{ route('storepatient') }}",
        method: "POST",
        data: data,
        success: function(response){
          console.log(response);

          if(response.success)
          {
            $('#patientform')[0].reset();
            getprovinces();
            // $('#province option:eq(0)').prop('selected', true);
            $('#city').empty().attr('disabled',true);
            $('#barangay').empty().attr('disabled',true);
            // Sweet Alert
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Record has successfully added',
              showConfirmButton: false,
              timer: 2500
            });
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

