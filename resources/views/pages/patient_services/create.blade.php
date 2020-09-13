
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
                            <a href="#step-1" type="button" id="btn-stepper-1" class="btn btn-success btn-circle" data-step="step-1">1</a>
                            <p><small>Services</small></p>
                        </div>
                        <div class="stepwizard-step col-xs-3"> 
                            <a href="#step-2" type="button" id="btn-stepper-2" class="btn btn-default btn-circle" data-step="step-2" disabled="disabled">2</a>
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
                            <input class="custom-control-input" type="checkbox" name="services[]" id="Checkbox-{{ $service->service }}" data-service="{{ $service->service }}" data-service-id="{{ $service->id }}" value="{{ $service->id }}" 
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
                      <div class="table-scrollable col-md-7">
                        <table class="table table-striped table-bordered table-hover" id="table-services">
                          <thead>
                            <th width="30%">Services</th>
                            <th width="30%">Price</th>
                            <th width="20%">Discount</th>
                            <th width="20%">Total Amount</th>
                          </thead>
                          <tbody>														
                          </tbody>
                          <tfoot>
												<tr>
													<td colspan="3">
														<strong><span class="pull-right">Grand Total :</span></strong>
													</td>
													<td><strong><span class="service-grand-total">0.00</span></strong></td>
												</tr>
											</tfoot>
                        </table>
                      </div>
                      <div class="form-group col-md-7">
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
        $('.card-footer').show();
      }

    }

    if(step == 'step-1')
    { 
      if($('#btn-add').text() == 'Submit')
      {
        $('.card-footer').hide();
      }
    }
      
  });
  
  //Remove error label when patient dropdown has value
  $('#patient').on('change', function(e){
    $("[aria-labelledby='select2-patient-container']").removeAttr('style');
    $('#patient-error').remove();
    $('#btn-add').text('Next');
    $('.card-footer').show();
  });

  //Call serviceischecked function when service is checked
  $('[name="services[]"]').change(function(){
    $('#btn-add').text('Next');
    $('.card-footer').show();
    serviceischecked();
  });

  // Add Services with Stepper
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
        $('.service-grand-total').empty().append("0.00");

        //Append table all selected services on billing stepper
        $('input:checkbox').each(function () {
            var services = (this.checked ? $(this).data('service') : "");
            var service_id = (this.checked ? $(this).data('service-id') : "");

            if(services)
            {
              $('#table-services tbody').append('<tr>'+
                                                    '<td>'+ services +'</td><td><input class="form-control input-small affect-total" type="text" name="price[]" id="price-serviceid-'+service_id+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="'+ services +'" data-serviceid="'+ service_id +'"></td>'+
                                                    '<td>'+
                                                         '<div class="input-group">'+
                                                            '<input class="form-control input-small affect-total" type="text" name="discount[]" id="discount-serviceid-'+service_id+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled data-service="'+ services +'" data-serviceid="'+ service_id +'">'+
                                                            '<div class="input-group-prepend"><span class="input-group-text">%</span></div>'+
                                                         '</div>'+
                                                    '</td>'+   
                                                    '<td><span class="service-total-amount" id="total-serviceid-'+service_id+'">0.00</span></td>'+
                                                '</tr>');
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

        $('#table-services').on('keyup', 'tbody td input[name="price[]"]', function(e){
          // alert($(this).closest('td').parent()[0].sectionRowIndex);
          var service = $(this).data('service');
          var service_id = $(this).data('serviceid');
          var price_per_service;
          var discount_per_service;

          //if price has value
          if($(this).val())
          {
            price_per_service = parseFloat($(this).val()).toFixed(2);
          }
          else
          {
            price_per_service = 0;
          }

          //if discount has value
          if($('#discount-serviceid-'+ service_id).val())
          {
            discount_per_service = parseFloat($('#discount-serviceid-'+ service_id).val()).toFixed(2) / 100;
          }
          else
          {
            discount_per_service = 0.00;
          }
          
          var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
          var total = parseFloat(price_per_service) - parseFloat(discount_amount);

          
          //disable/enable discount textbox
          if(price_per_service > 0){
            $('#discount-serviceid-'+ service_id).removeAttr('disabled');
          }
          else
          {
            $('#discount-serviceid-'+ service_id).attr('disabled', true);
          }

          //if price is not null then append total amount
          if($(this).val())
          {
            $('#total-serviceid-'+service_id).empty().append(parseFloat(total).toFixed(2));
          }
          else
          {
            $('#total-serviceid-'+service_id).empty().append(parseFloat(total).toFixed(2));
          }

          //call function getGrandTotal
          getGrandTotal();
          
        });


        $('#table-services').on('keyup', 'tbody td input[name="discount[]"]', function(e){
          var service = $(this).data('service');
          var service_id = $(this).data('serviceid');
          var price_per_service = parseFloat($('#price-serviceid-'+service_id).val()).toFixed(2);
          var discount_per_service = parseFloat($(this).val()).toFixed(2) / 100;

          //if discount has value
          if($(this).val())
          {
            discount_per_service = parseFloat($(this).val()).toFixed(2) / 100;
          }
          else
          {
            discount_per_service = 0.00;
          }

          var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
          var total = parseFloat(price_per_service) - parseFloat(discount_amount);

          //if discount is null then append total amount
          if($(this).val())
          {
            $('#total-serviceid-'+service_id).empty().append(parseFloat(total).toFixed(2));
          }
          else
          {
            $('#total-serviceid-'+service_id).empty().append(parseFloat(total).toFixed(2));
          }
          
          //call function getGrandTotal
          getGrandTotal();

        });

        $('[name="price[]"]').inputmask('decimal', {
          rightAlign: true,
          digits:2,
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
        $('#discount').inputmask('decimal', {
          rightAlign: true
        
        });
    }

  });

  $('[data-mask]').inputmask();
  $('.select2').select2();

  //append error span for services
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

      $('[href="#step-2"]').removeClass('btn-success').addClass('btn-default').attr('disabled', true);
      
    }
    
  }


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

  }

});
</script>
@endsection

