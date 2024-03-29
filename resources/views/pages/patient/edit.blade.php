
@extends('layouts.main')
@section('title', 'Update Patient')
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
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('patient.index') }}">Patients Record</a></li>
              <li class="breadcrumb-item active">Update Patient</li>
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
                <h3 class="card-title">Update Patient</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="patientform" method="POST" action="{{ route('patient.update', $patient->id) }}">
                @csrf
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="lastname">Lastname</label> <span class="text-danger">*</span>
                      <input type="text" name="lastname" class="form-control" id="lastname" value="{{ $patient->lastname }}" placeholder="Enter lastname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="firstname">Firstname</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" name="firstname" id="firstname" value="{{ $patient->firstname }}" placeholder="Enter firstname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="middlename">Middlename</label>
                      <input type="text" class="form-control" name="middlename" id="middlename" value="{{ $patient->middlename }}" placeholder="Enter middlename">
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-2">
                      <label for="gender">Gender</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-male" value="male" 
                        @if($patient->gender == 'male') checked @endif>
                        <label class="form-check-label" for="gender-male">Male</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="radio-female" value="female"
                        @if($patient->gender == 'female') checked @endif>
                        <label class="form-check-label" for="gender-female">Female</label>
                      </div>
                    </div>
                    <div class="form-group col-md-2">
                      <label for="gender">Civil Status</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-single" value="single" checked
                        @if($patient->civilstatus == 'single') checked @endif>
                        <label class="form-check-label" for="gender-male">Single</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-married" value="married"
                        @if($patient->civilstatus == 'married') checked @endif>
                        <label class="form-check-label" for="gender-female">Married</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-widowed" value="widowed"
                        @if($patient->civilstatus == 'widowed') checked @endif>
                        <label class="form-check-label" for="gender-female">Widowed</label>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="birthdate">Birthdate</label> <span class="text-danger">*</span>
                      <!-- <div id="datetimepicker-birthdate" class="input-group date" data-target-input="nearest">
                        <div class="input-group-append" data-target="#datetimepicker-birthdate" data-toggle="datetimepicker">
                          <div class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </div>
                        </div>
                        <input type="text" class="form-control datetimepicker-input" name="birthdate" id="birthdate" value="{{ $birthdate }}" data-target="#datetimepicker-birthdate"  placeholder="MM/DD/YYYY" readonly>
                      </div> -->
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="birthdate" id="birthdate" value="{{ $birthdate }}" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy">
                      </div>
                    </div> 
                    <!-- <div class="form-group col-md-3">
                      <label for="age">Age</label>
                      <input type="text" class="form-control" name="age" id="age" value="{{ $patient->age }}" placeholder="0">
                    </div> -->
                    <!-- <div class="form-group col-md-4">
                      <label for="weight">Weight</label> <span class="text-danger">*</span>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" value="{{ $patient->weight }}" placeholder="0.00">
                        <div class="input-group-append">
                          <span class="input-group-text">Kg</span>
                        </div>
                      </div>
                    </div> -->
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="landline">Landline</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-phone"></i>
                          </span>
                        </div>
                        <!-- <input class="form-control" type="text" name="landline" id="landline" value="{{ $patient->landline }}" data-inputmask='"mask": "(999)999-9999"' data-mask> -->
                        <input class="form-control" type="text" name="landline" id="landline" value="{{ $patient->landline }}">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="mobile">Mobile No.</label><span class="text-danger">*</span>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-mobile"></i>
                          </span>
                        </div>
                        <!-- <input class="form-control" type="text" name="mobile" id="mobile" value="{{ $patient->mobile }}" data-inputmask='"mask": "(+63)999-9999-999"' data-mask> -->
                        <input class="form-control" type="text" name="mobile" id="mobile" value="{{ $patient->mobile }}">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="email">Email address</label>
                      <input class="form-control" type="email" name="email" id="email" placeholder="Enter email" value="{{ $patient->email }}">
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="address">House/Unit/Flr #, Bldg Name, Blk/Lot #, Street Name</label>
                      <input class="form-control" type="text" name="address" id="address" value="{{ $patient->address }}">
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
                @can('patient-edit')
                <div class="card-footer">
                  <button type="submit" id="btn-submit" class="btn btn-primary" disabled>Update</button>
                </div>
                @endcan
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

        $('#province').empty().append('<option value="" disabled>Select a Province</option>');
        
        $.each(response, function(index, value){
          
          if("{{ $patient->province }}" == value.province_id)
          {
            $('#province').append('<option value="'+ value.province_id +'" selected>'+ value.name +'</option>');
          }
          else
          {
            $('#province').append('<option value="'+ value.province_id +'">'+ value.name +'</option>');
          }
          
        });

        //ajax get cities by province
        $.ajax({
          url: "{{ route('getcities') }}",
          method: "POST",
          data: { _token: '{{ csrf_token() }}', province_id: "{{ $patient->province }}" },
          success:function(response){
            console.log(response);

            $('#city').empty().attr('disabled',false);

            $.each(response.cities, function( index, value ) {
              if("{{ $patient->city }}" == value.city_id)
              {
                $('#city').append('<option value="'+ value.city_id +'" selected>'+ value.name +'</option>');
              }
              else
              {
                $('#city').append('<option value="'+ value.city_id +'">'+ value.name +'</option>');
              }

            });
          },
          error:function(response){
            console.log(response);
          }
        });

        $.ajax({
          url: "{{ route('getbarangays') }}",
          method: "POST",
          data: { _token: "{{ csrf_token() }}", city_id: "{{ $patient->city }}" },
          success: function(response){

            console.log(response);

            $('#barangay').empty().attr('disabled',false);

            $.each(response, function( index, value ) {
              if("{{ $patient->barangay }}" == value.id)
              {
                $('#barangay').append('<option value="'+ value.id +'" selected>'+ value.name +'</option>');
              }
              else
              {
                $('#barangay').append('<option value="'+ value.id +'">'+ value.name +'</option>');
              }

            });

          },
          error:function(response){
            console.log(response);
          }
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
      //   number: true,
      // },
      mobile: {
        required: true,
      },
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
        required: "Please select birthdate",
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
      },
      mobile: {
        required: "Please enter a mobile number"
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
      // e.preventDefault();
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
  

  $('#patientform').on('change input',function(e){
    
    $('#btn-submit').attr('disabled', false);
   
  });


  $('#age').inputmask('integer', {
      rightAlign: true,
      integerDigits:3,
      allowMinus:false
        
    });

  $('#weight').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false
        
    });

});
</script>
@endsection

