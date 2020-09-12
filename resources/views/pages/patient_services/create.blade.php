
@extends('layouts.main')
@section('title', 'Patient Services')
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
              <li class="breadcrumb-item"><a href="/">Home</a></li>
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
                  <div class="stepwizard">
                    <div class="stepwizard-row setup-panel">
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-1" type="button" class="btn btn-success btn-circle" data-step="step-1">1</a>
                            <p><small>Services</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-2" type="button" class="btn btn-default btn-circle" data-step="step-2" disabled="disabled">2</a>
                            <p><small>Billings</small></p>
                        </div>
                    </div>
                  </div>
                  <div class="setup-content stepper" id="step-1">
                    <div class="row d-flex justify-content-around"> 
                      <div class="form-group col-md-4 div-patient">
                        <label for="patient">Patient</label>
                        <select class="form-control select2" name="patient" id="patient" style="width: 100%;">
                          <option selected="selected" value="" disabled>Select Patient</option>
                          @foreach($patients as $patient)
                          <option value="{{ $patient->id }}" data-patient-name="{{ $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename }}">{{ $patient->id . ' - ' . $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="selectPatient">Document Date</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                          </div>
                          <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" value="{{ date('m-d-Y') }}">
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="row d-flex justify-content-center div-services">
                      @foreach($services as $service)
                      <div class="form-group col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox" name="services[]" id="Checkbox-{{ $service->service }}" data-service="{{ $service->service }}" value="{{ $service->id }}" 
                            @if($service->status == 'inactive') disabled @endif>
                            <label for="Checkbox-{{ $service->service }}" class="custom-control-label">{{ $service->service }}</label>
                          </div>
                      </div>
                      @endforeach
                    </div>
                  </div>
                  <div class="setup-content stepper" id="step-2" hidden>
					
                      <div class="row">
                        <!--/span-->
                        <div class="col-md-4">
                          <div class="form-group">
                          <label class="control-label col-md-5"><strong>Patient Name :</strong></label>
                            <div class="col-md-7">
                              <p class="form-control-static" id='patient-name'>
                                
                              </p>
                            </div>
                          </div>
                        </div>
                        <!--/span-->							
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label col-md-5"><strong>Date :</strong></label>
                            <div class="col-md-7">
                              <p class="form-control-static" id="document-date">
                                
                              </p>
                            </div>
                          </div>
                        </div>	
                        <div class="form-group col-md-2">
                        <label for="selectPatient">Official Receipt No.</label>
                        <div class="input-group">
                          <input type="text" class="form-control" name="or" id="or">
                        </div>
                      </div>						
                      </div> 
                      <hr>                     
                      <div class="table-scrollable col-md-6">
                        <!-- if you're updating the layout of this table, make sure update purchaseOrderReceiveTable.hbs/.js as well-->
                        <table class="table table-striped table-bordered table-hover" id="table-services">
                          <thead>
                            <th width="70%">Services</th>
                            <th width="30%">Price</th>
                          </thead>
                          <tbody>														
                          </tbody>
                          <tfoot>
												<tr>
													<td colspan="1">
														<span class="pull-right">SubTotal :</span>
													</td>
													<td><span class="service-subTotal">0.00</span></td>
												</tr>
												<!-- <tr>
													<td colspan="1">
														<span class="pull-right">Tax :</span>
													</td>													
													<td><input class="form-control input-small affect-total service-tax" type="text" name="tax" id="tax" placeholder="0.00"></td>
												</tr>								 -->
												<tr>
													<td colspan="1">
														<span class="pull-right">Discount :</span>
													</td>
													<td>
                            <div class="input-group">
                              <div class="input-group-prepend">
                                <span class="input-group-text">%</span>
                              </div>
                              <input class="form-control input-small affect-total service-discount" type="text" name="discount" id="discount" placeholder="0.00" disabled>
                            </div>
                          </td>
												</tr>																
												<tr>
													<td colspan="1">
														<strong><span class="pull-right">Total :</span></strong>
													</td>
													<td><strong><span class="service-total">0.00</span></strong></td>
												</tr>
											</tfoot>
                        </table>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="selectPatient">Notes</label>
                        <div class="input-group">
                          <textarea class="form-control" id="receiveTab_notes" style="resize: none;"></textarea>
                        </div>
                      </div>
                  </div>							
                </div>
                <div class="card-footer">
                  <button type="submit" id="btn-add" class="btn btn-primary">Next</button>
                </div>
                <!-- /.card-body -->
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

  var navListItems = $('div.setup-panel div a');
  var allWells = $('.steps');

  $('div.setup-panel div a').click(function (e) {
    e.preventDefault();
    
    var step = $(this).data('step');
    
    if($(this).is('[disabled]') == false)
    {
      $('.setup-content').attr('hidden',true);
      $('#'+step).removeAttr('hidden');

      if(step == 'step-2')
      {
        $('#btn-add').text('Submit');
      }

    }

    if(step == 'step-1')
    {
      $('#btn-add').text('Next');
    }
      
  });
  
  //Service Form Validation
  // $('#patientserviceform').validate({
  //   rules: {
  //     patient: {
  //       required: true,
  //     },
  //     docdate: {
  //       required: true,
  //       date: true
  //     },     
  //   },
  //   messages: {
  //     patient: {
  //       required: "Please select patient",
  //     },
  //     docdate: {
  //       required: "Please enter document date",
  //     },   
  //   },
  //   errorElement: 'span',
  //   errorPlacement: function (error, element) {
      
  //     error.addClass('invalid-feedback');
  //     element.closest('.form-group').append(error);

  //     if ($(element).hasClass('select2'))
  //     { 
  //       $(element).closest(".form-group").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger'); 
  //     }
      
  //   },
  //   highlight: function (element, errorClass, validClass) {
  //     $(element).addClass('is-invalid');
  //   },
  //   unhighlight: function (element, errorClass, validClass) {
  //     $(element).removeClass('is-invalid');
  //   },
  //   submitHandler: function(e){
        

  //       $('#patient-name').empty().append($("#patient :selected").data('patient-name'));
  //       $('#document-date').empty().append($('#docdate').val());
  //       $('#table-services tbody').empty();

  //       $('input:checkbox').each(function () {
  //           var services = (this.checked ? $(this).data('service') : "");

  //           if(services)
  //           {
  //             $('#table-services tbody').append('<tr><td>'+ services +'</td><td><input class="form-control input-small affect-total" type="text" name="price[]" id="price" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask></td></tr>');
  //           }
            
  //       });

  //       if($('[name="services[]"]').is(':checked'))
  //       {
  //         $('[href="#step-2"]').removeClass('btn-default').addClass('btn-success').removeAttr('disabled');
  //         $('#step-2').removeAttr('hidden');
  //         $('#step-1').attr('hidden', true);
  //         $('#btn-add').text('Submit');
  //       }
  //       else
  //       {
  //         $('[href="#step-2"]').removeClass('btn-success').addClass('btn-default').attr('disabled', true);
  //       }

  //       //Sum each price
  //       $('[name="price[]"]').on('change input',function(){
  //         $('[name="price[]"]').each(function(){
  //           alert($(this).val());
  //           $('.service-subTotal').empty().append($(this).val());
  //           $('.service-total').empty().append($(this).val());
  //         });
  //       });

  //       $('[name="price[]"]').inputmask({
  //           mask:'9',repeat:7,placeholder:"0000000",numericInput: true,rightAlign: true
  //       });
  //       $('#tax').inputmask({
  //           mask:'9',repeat:4,placeholder:"0000000",numericInput: true,rightAlign: true
  //       });
  //       $('#discount').inputmask({
  //           mask:'9',repeat:4,placeholder:"0000000",numericInput: true,rightAlign: true
  //       });
  //   }
        
  // });

  $('#patient').on('change', function(e){
    $("[aria-labelledby='select2-patient-container']").removeAttr('style');
    $('#patient-error').remove();
  });

  $('[name="services[]"]').change(function(){
    serviceischecked();
  });

  
  $('#btn-add').click(function(e){
    e.preventDefault();

    if(!$('#patient').val())
    { 
      $('#patient-error').remove();
      $('.div-patient').append('<span id="patient-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please select patient</span>');
      $(".form-group").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger'); 
    }
    
    serviceischecked();
    
    if($('#btn-add').text() == 'Submit')
    {
          var data = $('#patientserviceform').serializeArray();
          data.push({name: "_token", value: "{{ csrf_token() }}"});
          $.ajax({
              url: "{{ route('patientservice.store') }}",
              method: "POST",
              data: data,
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

                  }   
                  else
                  {   
                      $('.div-services').addClass('is-invalid text-danger');
                      $('.div-services').after('<span id="service-error" class="error invalid-feedback">'+ response.services +'</span>');
                  }
                  
              },
              error: function(response){
                  console.log(response);
              }
          });
    }
    else
    {
        $('#patient-name').empty().append($("#patient :selected").data('patient-name'));
        $('#document-date').empty().append($('#docdate').val());
        $('#table-services tbody').empty();

        $('input:checkbox').each(function () {
            var services = (this.checked ? $(this).data('service') : "");

            if(services)
            {
              $('#table-services tbody').append('<tr><td>'+ services +'</td><td><input class="form-control input-small affect-total" type="text" name="price[]" id="price" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask></td></tr>');
            }
            
        });

        if($('[name="services[]"]').is(':checked') && $('#patient').val())
        {
          $('[href="#step-2"]').removeClass('btn-default').addClass('btn-success').removeAttr('disabled');
          $('#step-2').removeAttr('hidden');
          $('#step-1').attr('hidden', true);
          $('#btn-add').text('Submit');
        }
        else
        {
          $('[href="#step-2"]').removeClass('btn-success').addClass('btn-default').attr('disabled', true);
        }

        //Sum each price
        var discount;
        var sum;
        var price;
        var total;
        $('input[name="price[]"]').on('keyup',function(){
          sum = 0.00;
          $('input[name="price[]"]:visible').each(function(){
            
            if($(this).val())
            {
              price = parseFloat($(this).val()).toFixed(2);
            }
            else
            {
              price = parseFloat(0.00).toFixed(2);
            }

            sum = parseFloat(sum)  + parseFloat(price);
            
            //disable/enable discount textbox
            if(sum > 0){
              $('#discount').removeAttr('disabled');
            }
            else
            {
              $('#discount').attr('disabled', true);
            }

          });
          // alert(sum);
          $('.service-subTotal').empty().append(parseFloat(sum).toFixed(2));
          $('.service-total').empty().append(parseFloat(sum).toFixed(2));
        });

        $('#discount').on('keyup',function(){
          discount = parseFloat($(this).val()).toFixed(2) / 100;
          discount_amount = parseFloat(sum) * parseFloat(discount);
          total = parseFloat(sum) - parseFloat(discount_amount);

          //if discount is null then append original amount
          if($(this).val())
          {
            $('.service-total').empty().append(parseFloat(total).toFixed(2));
          }
          else
          {
            $('.service-total').empty().append(parseFloat(sum).toFixed(2));
          }
          
          // alert(discount);
        });

        $('[name="price[]"]').inputmask('decimal', {
          rightAlign: true
        });
        $('#tax').inputmask('decimal', {
          rightAlign: true
        });
        $('#discount').inputmask('decimal', {
          rightAlign: true
        
        });
    }




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
      if($('#patientserviceform [type="checkbox"]').length > 0){
          $('#service-error').remove();
          $('.div-services').addClass('is-invalid text-danger');
          $('.div-services').after('<span id="service-error" class="invalid-feedback">Please select at least 1 service</span>');
      }
      else
      {
        $('[href="#step-2"]').removeClass('btn-success').addClass('btn-default').attr('disabled', true);
      }
     }
    
  }

});
</script>
@endsection

