
@extends('layouts.main')
@section('title', 'Add Service')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patient Services</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('patientrecord') }}">Home</a></li>
              <li class="breadcrumb-item active">Patient Services</li>
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
                <h3 class="card-title">Add Patient Services</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="patientserviceform">
                <div class="card-body">
                  <div class="row d-flex justify-content-around"> 
                    <div class="form-group col-md-4">
                      <label for="patient">Patient</label>
                      <select class="form-control select2" name="patient" id="patient" style="width: 100%;">
                        <option selected="selected" value="" disabled>Select Patient</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->id . ' - ' . $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename }}</option>
                        @endforeach
                       </select>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="selectPatient">Document Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy">
                      </div>
                    </div>
                  </div>
                  <!-- <div class="row d-flex justify-content-center">
                    
                  </div> -->
                  <hr>
                  <div class="row d-flex justify-content-center div-services">
                    @foreach($services as $service)
                    <div class="form-group col-md-4">
                        <div class="custom-control custom-checkbox">
                          <input class="custom-control-input" type="checkbox" name="services[]" id="Checkbox-{{ $service->service }}" value="{{ $service->id }}" 
                          @if($service->status == 'inactive') disabled @endif>
                          <label for="Checkbox-{{ $service->service }}" class="custom-control-label">{{ $service->service }}</label>
                        </div>
                    </div>
                    @endforeach
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
  $('#patientserviceform').validate({
    rules: {
      patient: {
        required: true,
      },
      docdate: {
        required: true,
        date: true
      },     
    },
    messages: {
      patient: {
        required: "Please select patient",
      },
      docdate: {
        required: "Please enter document date",
      },   
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
        var data = $('#patientserviceform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        $.ajax({
            url: "{{ route('storepatientservice') }}",
            method: "POST",
            data: data,
            success: function(response){
                if(response.success)
                {
                    Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: 'Record has successfully added',
                                showConfirmButton: false,
                                timer: 2500
                              });   
                  setTimeout(function() {
                    // $(location).attr('href', "{{ route('servicerecord') }}");
                  },1000);
                }   
                else
                {
                    $('.div-services').addClass('is-invalid text-danger');
                    $('.div-services').after('<span id="service-error" class="error invalid-feedback">'+ response.services +'</span>');
                }
                console.log(response);
            },
            error: function(response){
                console.log(response);
            }
        });

    }
        
  });

  $('#patient').on('change', function(e){
    $("[aria-labelledby='select2-patient-container']").removeAttr('style');
    $('#patient-error').remove();
  });

  $('[name="services[]"]').change(function(){
    serviceischecked();
  });

  $('#btn-add').click(function(e){
    serviceischecked();
  });

  $('[data-mask]').inputmask();
  $('.select2').select2();

  $('#patient').on('change', function(e){
    $('#btn-add').attr('disabled', false);
  });

  function serviceischecked(){

    if ($('[name="services[]"]').is(':checked')) {
      $('.div-services').removeClass('is-invalid text-danger');
      $('#service-error').remove();
    }
    else
    {
      $('.div-services').addClass('is-invalid text-danger');
      $('.div-services').after('<span id="service-error" class="error invalid-feedback">Please select at least 1 service</span>');
    }
    
  }

});
</script>
@endsection

