
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
                  <div class="row"> 
                    <div class="form-group col-md-4 div-patient">
                      <label for="patient">Patient</label>
                      <select class="form-control select2" name="patient" id="patient" style="width: 100%;">
                        <option selected="selected" value="" disabled>Select Patient</option>
                        @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" data-patient-name="{{ $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename }}">{{ $patient->id . ' - ' . $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename }}</option>
                        @endforeach
                      </select>
                    </div>
                    <div class="form-group col-md-4 div-docdate">
                      <label for="docdate">Document Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" value="{{ date('m-d-Y') }}">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="OfficialReceipt">Official Receipt No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="or_number" id="or_number">
                      </div>
                    </div>           
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="bloodpressure">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="temperature">Temperature</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="temperature" id="temperature" placeholder="00.0">
                        <div class="input-group-append">
                          <span class="input-group-text">°C</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="weight">Weight</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" placeholder="0.00">
                        <div class="input-group-append">
                          <span class="input-group-text">Kg</span>
                        </div>
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
                          <th width="150px">Price (PHP)</th>
                          <th width="150px">Discount (%)</th>
                          <th width="150px">Discount (PHP)</th>
                          <th width="170px">Total Amount (PHP)</th>
                          <th width="130px">Action</th>
                        </thead>
                        <tbody>												
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5">
                              <strong><span class="pull-right">Grand Total :</span></strong>
                            </td>
                            <td><strong><span class="service-grand-total">0.00</span></strong></td>
                            <td><a href="" class="btn btn-sm btn-primary add-item" id="add-item"><i class="fa fa-plus"></i> Add Item</a></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="Notes">Notes</label>
                      <div class="input-group">
                        <textarea class="form-control" name="note" id="note" style="resize: none;"></textarea>
                      </div>
                    </div>						
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" id="btn-add" class="btn btn-primary" disabled>Add</button>
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
  
  //Remove error label when patient dropdown has value
  $('#patient').on('change', function(e){
    $("[aria-labelledby='select2-patient-container']").removeAttr('style');
    $('#patient-error').remove();
  });

  // //Call serviceischecked function when service is checked
  // $('[name="services[]"]').change(function(){
  //   serviceischecked();
  // });

  //document date text change
  $('#docdate').keyup(function(e){
    var docdate = new Date($(this).val());
    //Valide Document Date
    if(docdate == 'Invalid Date')
    { 
      $('#docdate-error').remove();
      $('.div-docdate').append('<span id="docdate-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter a valid date</span>');
    }
    else
    {
      $('#docdate-error').remove();
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
                                          '<input class="form-control input-small affect-total" type="text" name="price[]" id="price-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'" disabled>'+
                                        '</td>'+
                                        '<td>'+
                                          '<div class="input-group">'+
                                            '<input class="form-control input-small affect-total" type="text" name="discount[]" id="discount-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled data-service="" data-serviceid="" data-linenum="'+linenum+'">'+
                                            '<div class="input-group-prepend"><span class="input-group-text">%</span></div>'+
                                        '</div>'+
                                        '</td>'+   
                                        '<td>'+
                                          '<div class="input-group">'+
                                            '<input class="form-control input-small affect-total" type="text" name="discount_amt[]" id="discount_amt-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled data-service="" data-serviceid="" data-linenum="'+linenum+'">'+
                                        '</div>'+
                                        '</td>'+
                                        '<td><span class="service-total-amount" id="total-linenum-'+linenum+'">0.00</span></td>'+
                                        '<td><a href="" class="btn btn-sm btn-danger delete-item" id="delete-item" data-linenum="'+linenum+'"><i class="fa fa-trash"></i> Delete</a></td>'+
                                      '</tr>');
    linenum++;
        
    $('.select2').select2();

    //find services on table then remove them from the select option if exists
    // $('#table-services tbody tr td').find('.span-service').each(function(){
    //   var service = $(this).text();
    //   $('select').find('[data-service="'+service+'"]').remove();
      
    // });

    //count service select option
    var ctr = 0;
    $('[name="service"]').find('option').each(function(){
        ctr++;
    });


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

      
      //if service select option has no more item
      // if(ctr == 2)
      // {
      //   $('#add-item').addClass('disabled');    
      // }

      $.ajax({
        url: "{{ route('serviceprocedures') }}",
        method: "POST",
        data: {_token: "{{ csrf_token() }}", service_id: service_id},
        success: function(response){

          console.log(response);

          $.each(response.procedures, function( index, value ) {
            $('#procedure-linenum-'+ linenum).append('<option value="'+value.id+'" data-procedure="'+value.procedure+'" data-price="'+value.price+'" data-linenum="'+linenum+'">'+value.procedure+'</option>');
          }); 

        },
        error: function(response){

        }
      });

    });


    $('#table-services').on('change', 'tbody td [name="procedure"]', function(e){ 
      var linenum = $(this).find(':selected').data('linenum');
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var procedure = $(this).find(':selected').data('procedure');
      var price = $(this).find(':selected').data('price');
      var procedure_id = $(this).val();

      $('#procedures-linenum-'+linenum).val(procedure_id);
      $('#price-linenum-'+linenum).val(price);

      $('.div-procedure').after('<span class="span-service" id="span-procedure-linenum-'+linenum+'" data-procedure="'+procedure+'" data-service_id="'+procedure_id+'">'+procedure+'</span>')
      $('.div-procedure').remove();

      if($(this).val())
      {
        // $('#add-item').removeClass('disabled');
        $('#price-linenum-'+ linenum).removeAttr('disabled');
        $('#discount-linenum-'+ linenum).removeAttr('disabled');
        $('#discount_amt-linenum-'+ linenum).removeAttr('disabled');
      }

      //Remove class disabled on Add Item Button 
      $('#add-item').removeClass('disabled'); 

      //Remove attribute disabled on button Add
      $('#btn-add').removeAttr('disabled'); 

      $('#total-linenum-'+linenum).empty().append(parseFloat(price).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

    });
    
    //service price text change
    $('#table-services').on('keyup', 'tbody td input[name="price[]"]', function(e){
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service;
      var discount_per_service;
      var discount_amt_per_service;

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

      //if discount % has value
      if($('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = parseFloat($('#discount-linenum-'+ linenum).val()).toFixed(2) / 100;
      }
      else
      {
        discount_per_service = 0.00;
      }

      //if discount amount has value
      if($('#discount_amt-linenum-'+ linenum).val())
      {
        discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+ linenum).val()).toFixed(2);
      }
      else
      {
        discount_amt_per_service = 0.00;
      }
          
      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

          
      //disable/enable discount textbox
      if(price_per_service > 0){
        $('#discount-linenum-'+ linenum).removeAttr('disabled');
        $('#discount_amt-linenum-'+ linenum).removeAttr('disabled');
      }
      else
      {
        $('#discount-linenum-'+ linenum).attr('disabled', true);
        $('#discount_amt-linenum-'+ linenum).attr('disabled', true);
      }

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();
          
    });


    //service discount text change
    $('#table-services').on('keyup', 'tbody td input[name="discount[]"]', function(e){
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = parseFloat($('#price-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($(this).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);

      //if discount % has value
      if($(this).val())
      {
        discount_per_service = parseFloat($(this).val()).toFixed(2) / 100;
      }
      else
      {
        discount_per_service = 0.00;
      }

      //if discount amount has value
      if($('#discount_amt-linenum-'+linenum).val())
      {
        discount_amt_per_service = parseFloat($('#discount_amt-linenum-'+linenum).val()).toFixed(2);
      }
      else
      {
        discount_amt_per_service = 0.00;
      }

      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));
          
      //call function getGrandTotal
      getGrandTotal();

    });

    //service discount amount text change
    $('#table-services').on('keyup', 'tbody td input[name="discount_amt[]"]', function(e){
      var linenum = $(this).data('linenum');
      var service = $(this).data('service');
      var service_id = $(this).data('serviceid');
      var price_per_service = parseFloat($('#price-linenum-'+linenum).val()).toFixed(2);
      var discount_per_service = parseFloat($('#discount-linenum'+linenum).val()).toFixed(2) / 100;
      var discount_amt_per_service = parseFloat($(this).val()).toFixed(2);

      //if discount % has value
      if($('#discount-linenum-'+ linenum).val())
      {
        discount_per_service = parseFloat($('#discount-linenum-'+ linenum).val()).toFixed(2) / 100;
      }
      else
      {
        discount_per_service = 0.00;
      }

      //if discount amount has value
      if($(this).val())
      {
        discount_amt_per_service = parseFloat($(this).val()).toFixed(2);
      }
      else
      {
        discount_amt_per_service = 0.00;
      }
   
      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#total-linenum-'+linenum).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();

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
      $('#table-services tbody tr td').find('select').each(function(){
         //$(this)   //select box of same row
         hasDropDown = true
      });
      // alert(hasDropDown);
      if(hasDropDown == false)
      {
        $('#add-item').removeClass('disabled');
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

    var docdate = new Date($('#docdate').val());

    e.preventDefault();
    
    //patient validation error
    if(!$('#patient').val())
    { 
      $('#patient-error').remove();
      $('.div-patient').append('<span id="patient-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please select patient</span>');
      $(".div-patient").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger'); 
    }

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
        
    var data = $('#patientserviceform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});
    data.push({name: "grand_total", value: $('.service-grand-total').text()});

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

              $('.service-total-amount').each(function () { 
                $(this).empty().append("0.00");
              });

              $('.service-grand-total').empty().append('0.00');

              $('#table-services tbody').empty();

            }                 
        },
        error: function(response){
          console.log(response);
        }
    });
  
  });

  $('[data-mask]').inputmask();
  $('.select2').select2();

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

});
</script>
@endsection

