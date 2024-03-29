
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
              <li class="breadcrumb-item"><a href="{{ route('service.index') }}">Service Record</a></li>
              <li class="breadcrumb-item">Create Service</li>
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
              <form role="form" id="serviceform">
                <div class="card-body">
                  <div class="row"> 
                    <div class="form-group col-md-3">
                      <label for="service">Service</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="service" id="service">
                      </div>
                    </div>           
                  </div>
                  <hr>
                  <div class="row">
                    <div class="table-scrollable col-md-6 table-responsive">
                      <table class="table table-striped table-bordered table-hover no-footer-border" id="table-services">
                        <thead>
                          <th>Procedure</th>
                          <th width="150px">Price (PHP)</th>
                          <th width="130px">Action</th>
                        </thead>
                        <tbody>												
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2" style="border: none;"></td>
                            <td style="border: none;"><a href="" class="btn btn-sm btn-primary add-item" id="add-item"><i class="fa fa-plus"></i> Add Item</a></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>			
                  </div>
                </div>
                <!-- /.card-body -->
              </form>
            </div>
            <div class="card-footer">
              <button type="submit" id="btn-add" class="btn btn-primary" disabled>Add</button>
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
  
  var linenum = 1;
  //add new line item on services table
  $('#add-item').click(function(e){
    e.preventDefault();

    var x = linenum - 1
  
    $('#table-services tbody').append('<tr id="row-'+linenum+'">'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="procedure[]" id="procedure-linenum-'+linenum+'" data-linenum="'+linenum+'">'+
                                        '</td>'+
                                        '<td>'+
                                          '<input class="form-control input-small affect-total" type="text" name="price[]" id="price-linenum-'+linenum+'" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask data-service="" data-serviceid="" data-linenum="'+linenum+'">'+
                                        '</td>'+
                                        '<td><a href="" class="btn btn-sm btn-danger delete-item" id="delete-item" data-linenum="'+linenum+'"><i class="fa fa-trash"></i> Delete</a></td>'+
                                      '</tr>');
    linenum++;
        
    //disable add-item button by default
    $('#add-item').addClass('disabled');

    //disable btn-add button by default
    $('#btn-add').attr('disabled', true);

    $('#service-table-error').remove();

    
    $('#table-services').on('keyup', 'tbody td [name="procedure[]"]', function(e){ 
      var linenum = $(this).data('linenum');

      if($(this).val() && $('#price-linenum-'+ linenum).val())
      {
        $('#add-item').removeClass('disabled');

        $('#btn-add').removeAttr('disabled');
      }
      else
      {
        $('#add-item').addClass('disabled');

        $('#btn-add').attr('disabled', true);
      }

    });

    $('#table-services').on('keyup', 'tbody td [name="price[]"]', function(e){ 
      var linenum = $(this).data('linenum');

      if($(this).val() && $('#procedure-linenum-'+ linenum).val())
      {
        $('#add-item').removeClass('disabled');
        
        $('#btn-add').removeAttr('disabled');
      }
      else
      {
        $('#add-item').addClass('disabled');

        $('#btn-add').attr('disabled', true);
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
    
    //count table tbody rows
    var tr_length = $('#table-services tbody tr').length;

    if(tr_length == 0)
    {
      $('#service-table-error').remove();
      $('.table-scrollable').append('<span id="service-table-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please add at least 1 service procedure on the table</span>');
    }
        
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
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
              });  

              $('#table-services tbody').empty();
            
            }
            else
            { 
              $('#service-error').remove();
              $('#service').addClass('is-invalid');
              $('#service').after('<span id="service-error" class="error invalid-feedback">'+ response.service +'</span>');
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

