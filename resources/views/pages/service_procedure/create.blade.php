
@extends('layouts.main')
@section('title', 'Service Procedure')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Service Procedure</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('serviceprocedure.index') }}">Service Procedure</a></li>
              <li class="breadcrumb-item">Create Service Procedure</li>
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
                <h3 class="card-title">Add Service Procedure</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="serviceprocedureform">
                <div class="card-body">
                  <div class="row"> 
                    <div class="form-group col-md-4 div-service">
                      <label for="service">Service</label>
                      <!-- <div class="input-group"> -->
                        <select class="form-control select2" name="service" id="service">
                          <option selected="selected" value="" disabled>Select Service</option>
                          @foreach($services as $service)
                          <option value="{{ $service->id }}">{{ $service->service }}</option>
                          @endforeach
                        </select>
                        <!-- <div class="input-group-append">
                          <a href="" class="input-group-text btn-primary" id="btn-add-service" data-toggle="modal" data-target="#modal-service">
                            <i class="fa fa-plus"></i>
                          </a>
                        </div> -->
                      <!-- </div> -->
                      
                    </div>           
                  </div>
                  <hr>
                  <div class="row">
                    <div class="table-scrollable col-md-10 table-responsive">
                      <table class="table table-striped table-bordered table-hover no-footer-border" id="table-services">
                        <thead>
                          <th width="300px">Code Name</th>
                          <th>Procedure</th>
                          <th width="150px">Price (PHP)</th>
                          <th width="150px">To Diagnose</th>
                          <th width="130px">Action</th>
                        </thead>
                        <tbody>												
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4" style="border: none;"></td>
                            <td style="border: none;"><a href="" class="btn btn-sm btn-primary add-item" id="add-item"><i class="fa fa-plus"></i> Add Item</a></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>			
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
              <div class="card-footer">
                <button type="submit" id="btn-add" class="btn btn-primary">Add</button>
              </div>
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
<div class="modal fade" id="modal-service">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="serviceform">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="lastname">Service</label> <span class="text-danger">*</span>
              <input type="text" name="service" class="form-control service-text-modal" id="service-text-modal" placeholder="Enter service" autofocus>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-4">
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="status-active" name="status" value="active" checked>
                  <label for="status-active" class="custom-control-label">Active</label>
                </div>
                <div class="custom-control custom-radio">
                  <input class="custom-control-input" type="radio" id="status-inactive" name="status" value="inactive">
                  <label for="status-inactive" class="custom-control-label">Inactive</label>
                </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="modal-footer">
          <button type="reset" id="btn-cancel" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="btn-save" class="btn btn-primary">Save</button> 
        </div>
      </form>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<script type="text/javascript">

$(document).ready(function () {

  //Add Service
  $('#btn-save').click(function(e){
    e.preventDefault();

    $(this).attr('disabled', true);

    var data = $('#serviceform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});

    $.ajax({
        url: "{{ route('service.store') }}",
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
            $('#service').append('<option value="'+response.service.id+'">'+response.service.service+'</option>')
            $('#modal-service').modal('toggle');
            $('#service-text-modal-error').remove();
          }
          else
          { 
            $('#service-text-modal-error').remove();
            $('#service-text-modal').addClass('is-invalid');
            $('#service-text-modal').after('<span id="service-text-modal-error" class="error invalid-feedback">'+ response.service +'</span>');
          }

          $(this).removeAttr('disabled');

        },
        error: function(response){
          console.log(response);
        }
      });

  });


  //Remove error label when patient dropdown has value
  $('#service').on('change', function(e){
    $("[aria-labelledby='select2-service-container']").removeAttr('style');
    $('#service-error').remove();
  });

  var linenum = 1;
  //add new line item on services table
  $('#add-item').click(function(e){
    e.preventDefault();

    var x = linenum - 1
  
    $('#table-services tbody').append('<tr id="row-'+linenum+'">'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="code[]" id="code-linenum-'+linenum+'" data-linenum="'+linenum+'">'+
                                        '</td>'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="procedure[]" id="procedure-linenum-'+linenum+'" data-linenum="'+linenum+'">'+
                                        '</td>'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="price[]" id="price-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'">'+
                                        '</td>'+
                                        '<td style="text-align:center;">'+
                                          '<div class="custom-control custom-checkbox">'+
                                            '<input class="custom-control-input" name="to-diagnose" type="checkbox" id="check-to-diagnose-'+linenum+'" value="Y" data-linenum="'+linenum+'">'+
                                            '<label for="check-to-diagnose-'+linenum+'" class="custom-control-label"></label>'+
                                          '</div>'+
                                          '<input type="text" id="to-diagnose-linenum-'+linenum+'" name="to_diagnose[]" value="N" hidden>'+
                                        '</td>'+
                                        '<td><a href="" class="btn btn-sm btn-danger delete-item" id="delete-item" data-linenum="'+linenum+'"><i class="fa fa-trash"></i> Delete</a></td>'+
                                      '</tr>');
    linenum++;
        
    //disable add-item button by default
    $('#add-item').addClass('disabled');

    //disable btn-add button by default
    // $('#btn-add').attr('disabled', true);

    $('#service-table-error').remove();

    $('#table-services').on('keyup', 'tbody td [name="code[]"]', function(e){ 
      var linenum = $(this).data('linenum');

      if($(this).val() && $('#procedure-linenum-'+ linenum).val() && $('#price-linenum-'+ linenum).val())
      {
        $('#add-item').removeClass('disabled');

        $('#btn-add').removeAttr('disabled');
      }
      else
      {
        $('#add-item').addClass('disabled');

        // $('#btn-add').attr('disabled', true);
      }

    });
    
    $('#table-services').on('keyup', 'tbody td [name="procedure[]"]', function(e){ 
      var linenum = $(this).data('linenum');

      if($(this).val() && $('#code-linenum-'+ linenum).val() && $('#price-linenum-'+ linenum).val())
      {
        $('#add-item').removeClass('disabled');

        $('#btn-add').removeAttr('disabled');
      }
      else
      {
        $('#add-item').addClass('disabled');

        // $('#btn-add').attr('disabled', true);
      }

    });

    $('#table-services').on('keyup', 'tbody td [name="price[]"]', function(e){ 
      var linenum = $(this).data('linenum');

      if($(this).val() && $('#code-linenum-'+ linenum).val() && $('#procedure-linenum-'+ linenum).val())
      {
        $('#add-item').removeClass('disabled');
        
        $('#btn-add').removeAttr('disabled');
      }
      else
      {
        $('#add-item').addClass('disabled');

        // $('#btn-add').attr('disabled', true);
      }

    });


    $('#table-services').on('click', 'tbody td [name="to-diagnose"]', function(e){ 
      var linenum = $(this).data('linenum');
        
      if($(this).is(":checked")) {
        $('#to-diagnose-linenum-'+linenum).val('Y');
      }  

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

      $('#add-item').removeClass('disabled');

    });


    //table elements input masks
    $('[name="price[]"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });

  });
  

  // Add Services with Stepper
  $('#btn-add').click(function(e){

    $('#btn-add').attr('disabled', true);

    e.preventDefault();
    
    //patient validation error
    if(!$('#service').val())
    { 
      $('#service-error').remove();
      $('.div-service').append('<span id="service-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please select service</span>');
      $(".div-service").find('.select2-selection').css('border-color','#dc3545').addClass('text-danger'); 
    }

    //count table tbody rows
    var tr_length = $('#table-services tbody tr').length;

    if(tr_length == 0)
    {
      $('#service-table-error').remove();
      $('.table-scrollable').append('<span id="service-table-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please add at least 1 service procedure on the table</span>');
    }
        
    var data = $('#serviceprocedureform').serializeArray();
    data.push({name: "_token", value: "{{ csrf_token() }}"});

    $.ajax({
        url: "{{ route('serviceprocedure.store') }}",
        method: "POST",
        data: data,
        success: function(response){
            console.log(response);
            if(response.success)
            {   

              $('#serviceprocedureform')[0].reset();
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
              });  
              $('#select2-service-container').empty().append('Select Service');
              // $('#service option[value=""]').prop('selected', 'selected').change();
              $('#table-services tbody').empty();
              $('#service-table-error').remove();
              // $('#btn-add').attr('disabled' ,true);
            }

            if(response.procedures)
            {
              $('#service-table-error').remove();
              $('.table-scrollable').append('<span id="service-table-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">'+ response.procedures +'</span>');
            }

            $('#btn-add').removeAttr('disabled');
                        
        },
        error: function(response){
          console.log(response);
        }
    });
  
  });

  $('[data-mask]').inputmask();
  $('.select2').select2();

});
</script>
@endsection

