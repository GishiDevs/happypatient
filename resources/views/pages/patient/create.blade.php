
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
              <li class="breadcrumb-item"><a href="/">Home</a></li>
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
                <h3 class="card-title">Add Patient </h3>
              </div>
              <!-- /.card-header -->
              <!-- patient form start -->
              <form role="form" id="patientform">
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="type">Options</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="option" id="option1" value="option1">
                        <label class="form-check-label" for="option1">Patient Information</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="option" id="option2" value="option2" checked>
                        <label class="form-check-label" for="option2">Patient Information and Services</label>
                      </div>
                    </div>
                  </div>
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
                    <div class="form-group col-md-2">
                      <label for="gender">Civil Status</label>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-single" value="single" checked>
                        <label class="form-check-label" for="gender-male">Single</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-married" value="married">
                        <label class="form-check-label" for="gender-female">Married</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="civilstatus" id="radio-widowed" value="widowed">
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
                      <input type="text" class="form-control" name="age" id="age" placeholder="0">
                    </div> -->
                    <!-- <div class="form-group col-md-4">
                      <label for="weight">Weight</label> <span class="text-danger">*</span>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" placeholder="0.00">
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
                        <!-- <input class="form-control" type="text" name="landline" id="landline" data-inputmask='"mask": "(999)999-9999"' data-mask> -->
                        <input class="form-control" type="text" name="landline" id="landline">
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
                        <!-- <input class="form-control" type="text" name="mobile" id="mobile" data-inputmask='"mask": "(+63)999-9999-999"' data-mask> -->
                        <input class="form-control" type="text" name="mobile" id="mobile">
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
                  <button type="submit" class="btn btn-primary" id="btn-next">Next</button>
                </div>
              </form>

              <!-- service form start -->
              <form role="form" id="patientserviceform" hidden>
                <div class="card-body">
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="bloodpressure">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="weight">Weight</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" placeholder="0.00">
                        <div class="input-group-append">
                          <span class="input-group-text">Kg</span>
                        </div>
                      </div>
                    </div>
                    <!-- <div class="form-group col-md-4">
                      <label for="OfficialReceipt">Official Receipt No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="or_number" id="or_number">
                      </div>
                    </div>  -->
                    <div class="form-group col-md-3">
                      <label for="temperature">Temperature</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="temperature" id="temperature" placeholder="00.0">
                        <div class="input-group-append">
                          <span class="input-group-text">°C</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-3 div-docdate">
                      <label for="docdate">Document Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" value="{{ date('m-d-Y') }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="title">Referring Physician</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="physician" id="physician" placeholder="Enter physician">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="pulserate">Pulse Rate</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="pulserate" id="pulserate" placeholder="0">
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="o2_sat">O2 Sat</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="o2_sat" id="o2_sat" placeholder="0.00">
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="pulserate">LMP</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lmp" id="lmp" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy">
                      </div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="table-scrollable col-md-12 table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="table-services">
                        <thead>
                          <th>Services</th>
                          <th>Procedure</th>
                          <th>Description</th>
                          <th width="150px">Price (PHP)</th>
                          <th width="150px">Medicine (PHP)</th>
                          <th width="150px">Discount (%)</th>
                          <th width="150px">Discount (PHP)</th>
                          <th width="110px">Total(PHP)</th>
                          <th width="100px">Action</th>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="text-right" colspan="7">
                              <strong><span class="pull-right">Grand Total :</span></strong>
                            </td>
                            <td><strong><span class="service-grand-total">0.00</span></strong></td>
                            <td><a href="" class="btn btn-xs btn-primary add-item" id="add-item"><i class="fa fa-plus"></i> Add Item</a></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="Notes">Notes</label>
                      <div class="input-group">
                        <textarea class="form-control" name="note" id="note" style="resize: none;"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                <button type="button" id="btn-previous" class="btn btn-primary">Previous</button>
                <button type="submit" id="btn-add" class="btn btn-primary">Add</button>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
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

  var option = 'option2';

  $('[name="option"]').click(function(){

    if($(this).val() == 'option1')
    {
      $('#btn-next').empty().append('Add');
    }
    else
    {
      $('#btn-next').empty().append('Next');
    }

    option = $(this).val();

  });

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

      //if option is equal to 'option1' then insert Personal Information without Patient Services
      if(option == 'option1')
      {

        var data_patient = $('#patientform').serializeArray();
        data_patient.push({name: "_token", value: "{{ csrf_token() }}"});

        //store patient information
        $.ajax({
            url: "{{ route('patient.store') }}",
            method: "POST",
            data: data_patient,
            success: function(response){
              
              console.log(response);

              if(response.success)
              {

                Swal.fire({
                  position: 'center',
                  icon: 'success',
                  title: 'Record has successfully added',
                  showConfirmButton: false,
                  timer: 2500
                });

                $('#patientform')[0].reset();
                getprovinces();
                // $('#province option:eq(0)').prop('selected', true);
                $('#city').empty().attr('disabled',true);
                $('#barangay').empty().attr('disabled',true);

                //set default option variable value into "option1"
                option = 'option1';

                //set default text
                $('#btn-next').empty().append('Add');

              }
            },
            error: function(response){
              console.log(response);
            }
        });
      }
      else
      {
        $('#patientserviceform').removeAttr('hidden');
        $('#patientform').attr('hidden', true);
      }

    }
  });

  $('#btn-previous').click(function(e){
    $('#patientserviceform').attr('hidden', true);
    $('#patientform').removeAttr('hidden');
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

  $('#temperature').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:1,
      allowMinus:false

    });

  $('#o2_sat').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false

    });

  $('#pulserate').inputmask('integer', {
      rightAlign: true,
      integerDigits:3,
      allowMinus:false

    });


  //patient services

  //document date text change
  $('#docdate').keyup(function(e){
    var docdate = new Date($(this).val());
    //Valide Document Date
    if(docdate == 'Invalid Date')
    {
      $('#docdate-error').remove();
      $('#docdate').addClass('is-invalid');
      $('#docdate').after('<span id="docdate-error" class="error invalid-feedback"> Please enter a valid date</span>');

    }
    else
    {
      // $('#docdate-error').remove();
      $(this).removeClass('is-invalid');
    }

  });

  var linenum = 1;
  //add new line item on services table
  $('#add-item').click(function(e){
    e.preventDefault();

    var x = linenum - 1

      $('#table-services tbody').append('<tr id="row-'+linenum+'">'+
                                        '<td>'+
                                          '<div class="form-group div-service">'+
                                            '<select class="form-control select2" name="service" id="service-linenum-'+linenum+'" style="width: 100%;">'+
                                              '<option selected="selected" value="" disabled>Select Service</option>'+
                                              @foreach($services as $service)
                                              '<option value="{{ $service->id }}" data-service="{{ $service->service}}" data-linenum="'+linenum+'">{{ $service->service}}</option>'+
                                              @endforeach
                                            '</select>'+
                                          '</div>'+
                                          '<input type="text" id="services-linenum-'+linenum+'" name="services[]" value="" hidden>'+
                                        '</td>'+
                                        '<td>'+
                                          '<div class="form-group div-procedure">'+
                                            '<select class="form-control select2" name="procedure" id="procedure-linenum-'+linenum+'" style="width: 100%;" disabled>'+
                                              '<option selected="selected" value="" disabled>Select Procedure</option>'+
                                            '</select>'+
                                          '</div>'+
                                          '<input type="text" id="procedures-linenum-'+linenum+'" name="procedures[]" value="" hidden>'+
                                        '</td>'+
                                        '<td>'+
                                          '<div class="form-group div-description">'+
                                            '<select class="select2" multiple="multiple" name="description" id="description-linenum-'+linenum+'" data-linenum="'+linenum+'" style="width: 100%;" disabled>'+
                                              '<option value="" disabled>Select Procedure</option>'+
                                            '</select>'+
                                            '<input type="text" id="descriptions-linenum-'+linenum+'" name="descriptions[]" value="" hidden>'+
                                          '</div>'+
                                        '</td>'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="price[]" id="price-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'" disabled>'+
                                        '</td>'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="medicine_amt[]" id="medicine_amt-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'" readonly>'+
                                        '</td>'+
                                        '<td>'+
                                          '<div class="input-group">'+
                                            '<input class="form-control input-small affect-total" type="text" name="discount[]" id="discount-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'" disabled>'+
                                            '<div class="input-group-prepend"><span class="input-group-text">%</span></div>'+
                                        '</div>'+
                                        '</td>'+
                                        '<td>'+
                                          '<div class="input-group">'+
                                            '<input class="form-control input-small affect-total" type="text" name="discount_amt[]" id="discount_amt-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled data-service="" data-serviceid="" data-linenum="'+linenum+'">'+
                                        '</div>'+
                                        '</td>'+
                                        '<td><span class="service-total-amount" id="total-linenum-'+linenum+'">0.00</span></td>'+
                                        '<td><a href="" class="btn btn-xs btn-danger delete-item" id="delete-item" data-linenum="'+linenum+'"><i class="fa fa-trash"></i> Remove</a></td>'+
                                      '</tr>');
    linenum++;

    $('.select2').select2();

    //disable add-item button by default
    $('#add-item').addClass('disabled');
    //disable btn-add button by default
    $('#btn-add').attr('disabled', true);

    $('#service-table-error').remove();

    $('#table-services').on('change', 'tbody td [name="service"]', function(e){
      var linenum = $(this).find(':selected').data('linenum');
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var service = $(this).find(':selected').data('service');
      var service_id = $(this).val();

      $('#services-linenum-'+linenum).val(service_id);

      $('.div-service').after('<span class="span-service" id="span-service-linenum-'+linenum+'" data-service="'+service+'" data-service_id="'+service_id+'">'+service+'</span>')
      $('.div-service').remove();

      if($(this).val())
      {
        // $('#add-item').removeClass('disabled');
        $('#procedure-linenum-'+ linenum).removeAttr('disabled');
      }

      // $.ajax({
      //   url: "{{ route('serviceprocedures') }}",
      //   method: "POST",
      //   data: {_token: "{{ csrf_token() }}", service_id: service_id},
      //   success: function(response){

      //     console.log(response);

      //     $('#procedure-linenum-'+ linenum).empty().append('<option selected="selected" value="" disabled>Select Procedure</option>');
      //     $.each(response.procedures, function( index, value ) {
      //       $('#procedure-linenum-'+ linenum).append('<option value="'+value.id+'" data-procedure="'+value.procedure+'" data-price="'+value.price+'" data-linenum="'+linenum+'">'+value.procedure+'</option>');
      //     });

      //   },
      //   error: function(response){
      //     console.log(response);
      //   }
      // });

      var procedures_id = [];  

      // insert all procedure id from the table into variable used for filtering select option  
      $.each($('[name="procedures[]"]'), function(index, data){
        if(data.value)
        {
          procedures_id[parseInt(data.value)] = parseInt(data.value);
        }
      });  

      $.each($('[name="description"]').find(':selected'), function(index, data){
        if($(this).val())
        {
          procedures_id[parseInt($(this).val())] = parseInt($(this).val());
        }
      });  

      $('#procedure-linenum-'+ linenum).empty().append('<option selected="selected" value="" disabled>Select Procedure</option>');

      @foreach($procedures as $procedure)

        var id = parseInt("{{ $procedure->id }}");

        if(service_id == "{{ $procedure->serviceid }}" && !procedures_id.includes(id))
        {
          $('#procedure-linenum-'+ linenum).append('<option value="{{ $procedure->id }}" data-service_id="{{ $procedure->serviceid }}" data-code="{{ $procedure->code }}" data-procedure="{{ $procedure->procedure }}" data-price="{{ $procedure->price }}" data-is_multiple="{{ $procedure->is_multiple }}" data-linenum="'+linenum+'">{{ $procedure->code }}</option>');
        }

      @endforeach  

    });


    $('#table-services').on('change', 'tbody td [name="procedure"]', function(e){
      var linenum = $(this).find(':selected').data('linenum');
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var service = $('#span-service-linenum-'+linenum).text();
      var service_id = $(this).find(':selected').data('service_id');
      var code = $(this).find(':selected').data('code');
      var procedure = $(this).find(':selected').data('procedure');
      var price = $(this).find(':selected').data('price');
      var is_multiple = $(this).find(':selected').data('is_multiple');
      var procedure_id = $(this).val();

      if(service == 'Check-up')
      {
        $('#medicine_amt-linenum-'+linenum).removeAttr('readonly');

      }

      $('#procedures-linenum-'+linenum).val(procedure_id);
      $('#price-linenum-'+linenum).val(price);

      $('.div-procedure').after('<span class="span-service" id="span-procedure-linenum-'+linenum+'" data-code="'+code+'" data-procedure="'+procedure+'" data-service_id="'+procedure_id+'">'+code+'</span>')
      $('.div-procedure').remove();

      if($(this).val())
      {
        // $('#add-item').removeClass('disabled');
        $('#price-linenum-'+ linenum).removeAttr('disabled');
        $('#discount-linenum-'+ linenum).removeAttr('disabled');
        $('#discount_amt-linenum-'+ linenum).removeAttr('disabled');
      }

      if(is_multiple == 'Y')
      {
        $('#description-linenum-'+ linenum).removeAttr('disabled');
      }

      //Remove class disabled on Add Item Button
      $('#add-item').removeClass('disabled');

      //Remove attribute disabled on button Add
      $('#btn-add').removeAttr('disabled');

      $('#total-linenum-'+linenum).empty().append(parseFloat(price).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      var procedures_id = [];  

      // insert all procedure id into variable used for filtering select option  
      $.each($('[name="procedures[]"]'), function(index, data){
        if(data.value)
        {
          procedures_id[parseInt(data.value)] = parseInt(data.value);
        }
      });  
      
      $.each($('[name="description"]').find(':selected'), function(index, data){
        if($(this).val())
        {
          procedures_id[parseInt($(this).val())] = parseInt($(this).val());
        }
      });

      $('#description-linenum-'+ linenum).empty();

      @foreach($procedures as $procedure)

        var id = parseInt("{{ $procedure->id }}");

        if(service_id == "{{ $procedure->serviceid }}" && procedure_id != "{{ $procedure->id }}" && !procedures_id.includes(id))
        {
          $('#description-linenum-'+ linenum).append('<option value="{{ $procedure->id }}" data-code="{{ $procedure->code }}" data-procedure="{{ $procedure->procedure }}" data-price="{{ $procedure->price }}" data-linenum="'+linenum+'">{{ $procedure->code }}</option>');
        }

      @endforeach

    });

    $('#table-services').on('change', 'tbody td [name="description"]', function(e){

      var linenum = this.dataset.linenum;
      var medicine_amt_per_service = parseFloat($('#medicine_amt-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($('#discount-linenum-'+linenum).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);
      var price_per_service = 0.00;
      var description = [];

      $.each($(this).find(':selected'), function(index, data){
        price_per_service = parseFloat(price_per_service) + parseFloat(this.dataset.price);
        description[index] = this.dataset.code;
      });

      // if description multiple select has value
      if($(this).find(':selected').length)
      {
        $('#descriptions-linenum-'+linenum).val(description.join());
        $('#price-linenum-'+linenum).val(parseFloat(price_per_service).toFixed(2));
      }
      else
      {
        $('#descriptions-linenum-'+linenum).val('');
        $('#price-linenum-'+linenum).val(0);
      }

      //if price has no value
      if(!$('#price-linenum-'+linenum).val())
      {
        price_per_service = 0.00;
      }

      //if medicine amount has no value
      if(!$('#medicine_amt-linenum-'+linenum).val())
      {
        medicine_amt_per_service = 0.00;
      }

      //if discount % has no value
      if(!$('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = 0.00;
      }

      //if discount amount has no value
      if(!$('#discount_amt-linenum-'+ linenum).val())
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      //disable add-item button when total_amount is 0 and below
      disableAddItemButton(total, linenum);

    });

    //service price text change
    $('#table-services').on('keyup input', 'tbody td input[name="price[]"]', function(e){
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = 0.00;
      var medicine_amt_per_service = parseFloat($('#medicine_amt-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($('#discount-linenum-'+linenum).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);


      //if price has value
      if($(this).val())
      {
        price_per_service = parseFloat($(this).val()).toFixed(2);

        $('#add-item').removeClass('disabled');
        // $('#btn-add').removeAttr('disabled');
      }
      else
      {
        price_per_service = 0;

        $('#add-item').addClass('disabled');
        // $('#btn-add').attr('disabled', true);
      }

      //if medicine amount has no value
      if(!$('#medicine_amt-linenum-'+linenum).val())
      {
        medicine_amt_per_service = 0.00;
      }

      //if discount % has no value
      if(!$('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = 0.00;
      }

      //if discount amount has no value
      if(!$('#discount_amt-linenum-'+ linenum).val())
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //disable/enable discount textbox
      // if(price_per_service > 0){
      //   $('#discount-linenum-'+ linenum).removeAttr('disabled');
      //   $('#discount_amt-linenum-'+ linenum).removeAttr('disabled');
      // }
      // else
      // {
      //   $('#discount-linenum-'+ linenum).attr('disabled', true);
      //   $('#discount_amt-linenum-'+ linenum).attr('disabled', true);
      // }

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      //disable add-item button when total_amount is 0 and below
      disableAddItemButton(total, linenum);;

    });

    //service medicine amount text change
    $('#table-services').on('keyup input', 'tbody td input[name="medicine_amt[]"]', function(e){
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = parseFloat($('#price-linenum-'+linenum).val()).toFixed(2);
      var medicine_amt_per_service = parseFloat($('#medicine_amt-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($('#discount-linenum-'+linenum).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);

      //if price has no value
      if(!$('#price-linenum-'+linenum).val())
      {
        price_per_service = 0.00;
      }

      //if medicine amount has no value
      if(!$('#medicine_amt-linenum-'+linenum).val())
      {
        medicine_amt_per_service = 0.00;
      }

      //if discount % has no value
      if(!$('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = 0.00;
      }

      //if discount amount has no value
      if(!$('#discount_amt-linenum-'+ linenum).val())
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      //disable add-item button when total_amount is 0 and below
      disableAddItemButton(total, linenum);;

    });


    //service discount text change
    $('#table-services').on('keyup input', 'tbody td input[name="discount[]"]', function(e){
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = parseFloat($('#price-linenum-'+linenum).val()).toFixed(2);
      var medicine_amt_per_service = parseFloat($('#medicine_amt-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($(this).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);


      //if price has no value
      if(!$('#price-linenum-'+linenum).val())
      {
        price_per_service = 0.00;
      }

      //if medicine amount has no value
      if(!$('#medicine_amt-linenum-'+linenum).val())
      {
        medicine_amt_per_service = 0.00;
      }

      //if discount % has no value
      if(!$(this).val())
      {
        discount_per_service = 0.00;
      }

      //if discount amount has no value
      if(!$('#discount_amt-linenum-'+linenum).val())
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      //disable add-item button when total_amount is 0 and below
      disableAddItemButton(total, linenum);;

    });

    //service discount amount text change
    $('#table-services').on('keyup input', 'tbody td input[name="discount_amt[]"]', function(e){
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = parseFloat($('#price-linenum-'+linenum).val()).toFixed(2);
      var medicine_amt_per_service = parseFloat($('#medicine_amt-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($('#discount-linenum-'+linenum).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($(this).val()).toFixed(2);


      //if price has no value
      if(!$('#price-linenum-'+linenum).val())
      {
        price_per_service = 0.00;
      }

      //if medicine amount has no value
      if(!$('#medicine_amt-linenum-'+linenum).val())
      {
        medicine_amt_per_service = 0.00;
      }

      //if discount % has no value
      if(!$('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = 0.00;
      }

      //if discount amount has no value
      if(!$(this).val())
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

      //disable add-item button when total_amount is 0 and below
      disableAddItemButton(total, linenum);;

    });

    //delete row
    $('#table-services').on('click', 'tbody td #delete-item', function(e){
      e.preventDefault();

      var linenum = $(this).data('linenum');
      var service = $('#span-service-linenum-'+linenum).text();
      var hasDropDown = false;
      var tr_length = $('#table-services tbody tr').length;

      //delete row
      $('#row-'+linenum).remove();

      //scan if there is a dropdown on a table
      $('#table-services tbody tr td').find('[name="service"], [name="procedure"]').each(function(){
         //$(this)   //select box of same row
         hasDropDown = true
      });
      // alert(hasDropDown);
      if(hasDropDown == false)
      {
        $('#add-item').removeClass('disabled');
        $('#btn-add').removeAttr('disabled');
      }

      //call function getGrandTotal
      getGrandTotal();

    });


    //table elements input masks
    $('[name="price[]"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('#tax').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false
    });
    $('[name="discount[]"]').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false

    });
    $('[name="discount_amt[]"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('#discount').inputmask('decimal', {
      rightAlign: true

    });

  });


  // Add Services with Stepper
  $('#btn-add').click(function(e){

    $('#btn-add').attr('disabled', true);

    var docdate = new Date($('#docdate').val());

    e.preventDefault();

    if(!$('select [name="service"]').val())
    {
      $('#service-error').remove();
      $('.div-service').append('<span id="service-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please select service</span>');
      $(".div-service").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger');
    }

    //Document Date validation error
    if(docdate == 'Invalid Date')
    {
      $('#docdate-error').remove();
      $('.div-docdate').append('<span id="docdate-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter a valid date</span>');
    }

    //count table tbody rows
    var tr_length = $('#table-services tbody tr').length;

    if(tr_length == 0)
    {
      $('#service-table-error').remove();
      $('.table-scrollable').append('<span id="service-table-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please add at least 1 service on the table</span>');
    }
    else
    {
      var data_patient = $('#patientform').serializeArray();
      data_patient.push({name: "_token", value: "{{ csrf_token() }}"});

      //store patient information
      $.ajax({
          url: "{{ route('patient.store') }}",
          method: "POST",
          data: data_patient,
          success: function(response){
            console.log(response);

            if(response.success)
            {
              $('#patientform')[0].reset();
              getprovinces();
              // $('#province option:eq(0)').prop('selected', true);
              $('#city').empty().attr('disabled',true);
              $('#barangay').empty().attr('disabled',true);

              var patient = response.patientid;
              var data_services = $('#patientserviceform').serializeArray();
              data_services.push({name: "_token", value: "{{ csrf_token() }}"});
              data_services.push({name: "grand_total", value: $('.service-grand-total').text()});
              data_services.push({name: "type", value: "individual"});
              data_services.push({name: "patient", value: patient});

              //store patient services
              $.ajax({
                  url: "{{ route('patientservice.store') }}",
                  method: "POST",
                  data: data_services,
                  success: function(response){
                      console.log(response);
                      if(response.success)
                      {
                        $('#select2-patient-container').empty().append('Select Patient');
                        $('#patientserviceform')[0].reset();
                        Swal.fire({
                          position: 'center',
                          icon: 'success',
                          title: 'Record has successfully added',
                          showConfirmButton: false,
                          timer: 2500
                        });

                        $('.service-total-amount').each(function () {
                          $(this).empty().append("0.00");
                        });

                        $('.service-grand-total').empty().append('0.00');

                        $('#table-services tbody').empty();

                        $('#patientform').removeAttr('hidden');
                        $('#patientserviceform').attr('hidden', true);

                        //set default option variable value into "option1"
                        option = 'option1';

                        //set default text
                        $('#btn-next').empty().append('Add');

                      }

                      $('#btn-add').removeAttr('disabled');
                  },
                  error: function(response){
                    console.log(response);
                  }
              });

            }
          },
          error: function(response){
            console.log(response);
          }
      });
    }

  });

  function getGrandTotal()
  {
    var sum = 0.00;
    var price = 0.00;

    //loop then sum each service total amount
    $('.service-total-amount').each(function(){
        price = parseFloat($(this).text()).toFixed(2);
        sum = parseFloat(sum)  + parseFloat(price);
    });

    //append Grand Total
    $('.service-grand-total').empty().append(parseFloat(sum).toFixed(2));

    //if grand total is 0 and below then add class text-danger
    if(parseFloat(sum).toFixed(2) > 0)
    {
      $('.service-grand-total').removeClass('text-danger');
    }
    else
    {
      $('.service-grand-total').addClass('text-danger');
    }

  }

  function disableAddItemButton(total, linenum)
  {
    //disable add-item button when total_amount is 0 and below
    if(parseFloat(total) > 0 )
    {
      $('#add-item').removeClass('disabled');
      $('#total-linenum-'+linenum).removeClass('text-danger');
    }
    else
    {
      $('#add-item').addClass('disabled');
      $('#total-linenum-'+linenum).addClass('text-danger');
      // Swal.fire({
      //       title: 'Warning',
      //       html: "Total Amount is 0 or below",
      //       icon: 'warning'
      //     });
    }
  }

});
</script>
@endsection

