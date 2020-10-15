
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
                <h3 class="card-title">Edit Patient Services</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="patientserviceform" method="POST">
                @csrf
                <div class="card-body">
                  <div class="row"> 
                    <div class="form-group col-md-4 div-patient">
                      <label for="patient">@if($patientservice->type == 'individual') Patient @else Organization @endif</label>  
                      @if($patientservice->type == 'individual') 
                      <h5>{{ $patientservice->name }}</h5>
                      @else  
                      <div class="input-group">
                        <input type="text" class="form-control" name="organization" id="organization" value="{{ $patientservice->name }}">
                      </div>
                      @endif
                    </div>
                    <div class="form-group col-md-4 ">
                      <label for="OfficialReceipt">Official Receipt No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="or_number" id="or_number" value="{{ $patientservice->or_number }}">
                      </div>
                    </div>  
                    <div class="form-group col-md-4 div-docdate">
                      <label for="selectPatient">Document Date </label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" value="{{ date('m/d/Y', strtotime($patientservice->docdate)) }}">
                      </div>
                    </div>    
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="bloodpressure">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure" value="{{ $patientservice->bloodpressure }}">
                      </div>
                    </div> 
                    <div class="form-group col-md-4">
                      <label for="temperature">Temperature</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="temperature" id="temperature" placeholder="00.0" value="{{ $patientservice->temperature }}">
                        <div class="input-group-append">
                          <span class="input-group-text">°C</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="weight">Weight</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="weight" id="weight" placeholder="0.00" value="{{ $patientservice->weight }}"> 
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
                          <th>Procedures</th>
                          <th>Price (PHP)</th>
                          <th>Discount (%)</th>
                          <th>Discount (PHP)</th>
                          <th>Total Amount (PHP)</th>
                          @if($patientservice->type == 'individual')
                          <th>Status</th>
                          @endif
                          <th width="180px" id="th-actions">Actions</th>
                        </thead>
                        <tbody>			
                        @foreach($patientserviceitems as $services)
                        <tr>
                          <td>{{ $services->service }}</td>
                          <td>{{ $services->procedure }}</td>
                          <td><span id="span-price-{{ $services->id }}">{{ $services->price }}</span><input type="text" class="form-control" name="price" id="price-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->price }}" hidden> </td>
                          <td><span id="span-discount-{{ $services->id }}">{{ $services->discount }}</span><input type="text" class="form-control" name="discount" id="discount-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->discount }}" hidden> </td>
                          <td><span id="span-discount_amt-{{ $services->id }}">{{ $services->discount_amt }}</span><input type="text" class="form-control" name="discount_amt" id="discount_amt-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->discount_amt }}"  hidden> </td>
                          <td><span class="service-total-amount" id="span-total_amount-{{ $services->id }}">{{ $services->total_amount }}</span></td>
                          @if($services->type == 'individual')
                          <td>
                              @if($services->status == 'diagnosed')
                                <span class="badge bg-success">{{ $services->status }}</span>
                              @elseif($services->status == 'pending')
                                <span class="badge bg-warning">{{ $services->status }}</span>
                              @elseif($services->status == 'cancelled')
                                <span class="badge bg-danger">{{ $services->status }}</span>
                              @endif
                          </td>
                          @endif
                          <td id="td-actions">
                              @if($services->docdate == date('Y-m-d'))
                                @can('amount-edit')
                                <a href="{{ route('patientservice.update_price') }}" class="btn btn-sm btn-info" id="btn-edit" data-id="{{ $services->id }}"><i class="fa fa-edit"></i> Edit</a> 
                                @endcan
                              @endif
                              @if($services->status == 'diagnosed' && $services->type == 'individual')
                                <a href="{{ route('diagnosis.edit',$services->id) }}" class="btn btn-sm btn-info" id="btn-view"><i class="fa fa-eye"></i> View</a> 
                              @elseif($services->status == 'pending' && $services->type == 'individual')
                                @can('diagnosis-create')
                                <a href="{{ route('diagnosis.create',$services->id) }}" class="btn btn-sm btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i> Diagnose</a>
                                @endif
                              @endif 
                          </td>
                        </tr>
                        @endforeach									
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="5">
                              <strong><span class="pull-right">Grand Total :</span></strong>
                            </td>
                            <td><strong><span class="service-grand-total">{{ $patientservice->grand_total}}</span></strong></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>						
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="Notes">Notes</label>
                      <div class="input-group">
                        <textarea class="form-control" name="note" id="note" style="resize: none;">{{ $patientservice->note }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  @can('patientservices-edit')
                  <button type="submit" id="btn-update" class="btn btn-primary" disabled>Update</button>
                  @endcan
                  @if($patientservice->cancelled == 'N')
                    @can('patientservices-cancel')
                    <button type="submit" id="btn-cancel" class="btn btn-danger float-right">Cancel</button>
                    @endcan
                  @endif
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
  
    $('#btn-update').click(function(e){ 

      $('#patientserviceform').attr('action', '{{ route("patientservice.update",$patientservice->id) }}');

      Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Record has been updated',
            showConfirmButton: false,
            timer: 2500
          });

      setTimeout($('#patientserviceform').submit(), 2000);
      
    });

    $('#btn-cancel').click(function(e){

      $('#patientserviceform').attr('action', '{{ route("patientservice.cancel",$patientservice->id) }}');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Cancel record!'
      }).then((result) => {
        if (result.value) {
          Swal.fire(
                  'Cancelled!',
                  'Record has been cancelled.',
                  'success'
                );
          
          setTimeout($('#patientserviceform').submit(), 2000);
        }
      });

    });

    $('#patientserviceform').on('change input',function(e){
    
    $('#btn-update').attr('disabled', false);
   
  });

  $('#table-services').on('click', 'tbody td #btn-edit', function(e){
    e.preventDefault();
    var ps_item_id = $(this).data('id');
    var price = $('#price-id-'+ps_item_id).val();
    var discount = $('#discount-id-'+ps_item_id).val();
    var discount_amt = $('#discount_amt-id-'+ps_item_id).val();
    var total_amount = $('#span-total_amount-'+ps_item_id).text();
    var grand_total = $('.service-grand-total').text();

    $('#price-id-'+ps_item_id).removeAttr('hidden');
    $('#discount-id-'+ps_item_id).removeAttr('hidden');
    $('#discount_amt-id-'+ps_item_id).removeAttr('hidden');

    $('#span-price-'+ps_item_id).attr('hidden', true);
    $('#span-discount-'+ps_item_id).attr('hidden', true);
    $('#span-discount_amt-'+ps_item_id).attr('hidden', true);

    if($(this).text() == 'Update')
    {

      $.ajax({
        url: "{{ route('patientservice.update_price') }}",
        method: "POST",
        data: {
                _token: "{{ csrf_token() }}", 
                ps_item_id: ps_item_id, 
                price: price, 
                discount: discount, 
                discount_amt: discount_amt,
                total_amount: total_amount
               },
        success: function(response){
          console.log(response);
          
          if(response.success)
          {

            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Record has been updated',
              showConfirmButton: false,
              timer: 2500
            });
            
            
            $('#price-id-'+ps_item_id).attr('hidden', true);
            $('#discount-id-'+ps_item_id).attr('hidden', true);
            $('#discount_amt-id-'+ps_item_id).attr('hidden', true);
            
            $('#span-price-'+ps_item_id).empty().append(price);
            $('#span-discount-'+ps_item_id).empty().append(discount);
            $('#span-discount_amt-'+ps_item_id).empty().append(discount_amt);

            $('#span-price-'+ps_item_id).removeAttr('hidden');
            $('#span-discount-'+ps_item_id).removeAttr('hidden');
            $('#span-discount_amt-'+ps_item_id).removeAttr('hidden');

            getGrandTotal();

          }

        },
        error: function(response){
          console.log(response);
        }
      });

      $(this).empty().append('<i class="fa fa-edit"></i> Edit');

    }
    else
    {
      $(this).empty().append('Update');
    }
  });

  //price text change
  $('#table-services').on('keyup', 'tbody td input[name="price"]', function(e){
    
      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var ps_item_id = $(this).data('id');
      var price = $('#price-id-'+ps_item_id).val();
      var discount = $('#discount-id-'+ps_item_id).val();
      var discount_amt = $('#discount_amt-id-'+ps_item_id).val();

      var price_per_service;
      var discount_per_service;
      var discount_amt_per_service;

      //if price has value
      if(price)
      {
        price_per_service = parseFloat(price).toFixed(2);
      }
      else
      {
        price_per_service = 0;
      }

      //if discount % has value
      if(discount)
      {
        discount_per_service = parseFloat(discount).toFixed(2) / 100;
      }
      else
      {
        discount_per_service = 0.00;
      }

      //if discount amount has value
      if(discount_amt)
      {
        discount_amt_per_service = parseFloat(discount_amt).toFixed(2);
      }
      else
      {
        discount_amt_per_service = 0.00;
      }
          
      var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
      var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#span-total_amount-'+ps_item_id).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();
          
  });

  //discount text change
  $('#table-services').on('keyup', 'tbody td input[name="discount"]', function(e){
    
    // alert($(this).closest('td').parent()[0].sectionRowIndex);
    var ps_item_id = $(this).data('id');
    var price = $('#price-id-'+ps_item_id).val();
    var discount = $('#discount-id-'+ps_item_id).val();
    var discount_amt = $('#discount_amt-id-'+ps_item_id).val();

    var price_per_service;
    var discount_per_service;
    var discount_amt_per_service;

    //if price has value
    if(price)
    {
      price_per_service = parseFloat(price).toFixed(2);
    }
    else
    {
      price_per_service = 0;
    }

    //if discount % has value
    if(discount)
    {
      discount_per_service = parseFloat(discount).toFixed(2) / 100;
    }
    else
    {
      discount_per_service = 0.00;
    }

    //if discount amount has value
    if(discount_amt)
    {
      discount_amt_per_service = parseFloat(discount_amt).toFixed(2);
    }
    else
    {
      discount_amt_per_service = 0.00;
    }
        
    var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
    var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

    //append total amount
    $('#span-total_amount-'+ps_item_id).empty().append(parseFloat(total).toFixed(2));

    //call function getGrandTotal
    getGrandTotal();
        
  });

  //discount amount text change
  $('#table-services').on('keyup', 'tbody td input[name="discount_amt"]', function(e){
    
    // alert($(this).closest('td').parent()[0].sectionRowIndex);
    var ps_item_id = $(this).data('id');
    var price = $('#price-id-'+ps_item_id).val();
    var discount = $('#discount-id-'+ps_item_id).val();
    var discount_amt = $('#discount_amt-id-'+ps_item_id).val();

    var price_per_service;
    var discount_per_service;
    var discount_amt_per_service;

    //if price has value
    if(price)
    {
      price_per_service = parseFloat(price).toFixed(2);
    }
    else
    {
      price_per_service = 0;
    }

    //if discount % has value
    if(discount)
    {
      discount_per_service = parseFloat(discount).toFixed(2) / 100;
    }
    else
    {
      discount_per_service = 0.00;
    }

    //if discount amount has value
    if(discount_amt)
    {
      discount_amt_per_service = parseFloat(discount_amt).toFixed(2);
    }
    else
    {
      discount_amt_per_service = 0.00;
    }
        
    var discount_amount = parseFloat(price_per_service) * parseFloat(discount_per_service);
    var total = parseFloat(price_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

    //append total amount
    $('#span-total_amount-'+ps_item_id).empty().append(parseFloat(total).toFixed(2));

    //call function getGrandTotal
    getGrandTotal();
        
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

    
    //table elements input masks
    $('[name="price"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('[name="discount"]').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false
        
    });
    $('[name="discount_amt"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('#discount').inputmask('decimal', {
      rightAlign: true
        
    });

});
</script>
@endsection

