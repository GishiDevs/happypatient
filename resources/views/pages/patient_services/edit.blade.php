
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
                  @if($patientservice->cancelled == 'Y')
                  <div class="row  mb-4">
                    <div class="col-md">
                      <span class="float-right"><strong>Status: <span class="badge bg-danger">CANCELLED</span></strong></span>
                    </div>
                  </div>
                  @endif
                  <div class="row">
                    <div class="form-group col-md-4 div-patient">
                      <label for="patient">@if($patientservice->type == 'individual') Patient @else Organization @endif</label>
                      @if($patientservice->type == 'individual')
                      <div>{{ strtoupper($patientservice->name) }}</div>
                      @else
                      <div class="input-group">
                        <input type="text" class="form-control" name="organization" id="organization" value="{{ $patientservice->name }}">
                      </div>
                      @endif
                    </div>
                    <!-- <div class="form-group col-md-4 ">
                      <label for="OfficialReceipt">Official Receipt No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="or_number" id="or_number" value="{{ $patientservice->or_number }}">
                      </div>
                    </div>   -->
                    <div class="form-group col-md-4">
                      <label for="bloodpressure">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure" value="{{ $patientservice->bloodpressure }}">
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
                      <label for="pulserate">Pulse Rate</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="pulserate" id="pulserate" placeholder="0" value="{{ $patientservice->pulserate }}">
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
                    <div class="form-group col-md-4">
                      <label for="temperature">Temperature</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="temperature" id="temperature" placeholder="00.0" value="{{ $patientservice->temperature }}">
                        <div class="input-group-append">
                          <span class="input-group-text">°C</span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="title">Referring Physician</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="physician" id="physician" placeholder="Enter physician" value="{{ $patientservice->physician }}">
                      </div>
                    </div>

                    <div class="form-group col-md-4">
                      <label for="o2_sat">O2 Sat</label>
                      <div class="input-group">
                        <input class="form-control" type="text" name="o2_sat" id="o2_sat" placeholder="0.00" value="{{ $patientservice->o2_sat }}">
                        <div class="input-group-append">
                          <span class="input-group-text">%</span>
                        </div>
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="lmp">LMP</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="lmp" id="lmp" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" @if($patientservice->lmp)value="{{ date('m/d/Y', strtotime($patientservice->lmp)) }}" @endif>
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
                          <th>Medicine (PHP)</th>
                          <th>Discount (%)</th>
                          <th>Discount (PHP)</th>
                          <th>Total (PHP)</th>
                          @if($patientservice->type == 'individual')
                          <th>Status</th>
                          @endif
                          @if($patientservice->cancelled == 'N')
                          <th id="th-actions">Actions</th>
                          @endif
                        </thead>
                        <tbody>
                        @foreach($patientserviceitems as $services)
                        <tr id="row-id-{{$services->id}}">
                          <td>{{ $services->service }}</td>
                          <td>
                            <span class="span-procedure" data-id="{{ $services->procedure_id }}">
                              @if($services->is_multiple == 'Y')
                                {{ $services->description }}
                              @else
                                {{ $services->code }}
                              @endif
                            </span>
                          </td>
                          <td><span id="span-price-{{ $services->id }}">{{ $services->price }}</span><input type="text" class="form-control" name="price" id="price-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->price }}" hidden> </td>
                          <td><span id="span-medicine_amt-{{ $services->id }}">{{ $services->medicine_amt }}</span><input type="text" class="form-control" name="medicine_amt" id="medicine_amt-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->medicine_amt }}" hidden> </td>
                          <td><span id="span-discount-{{ $services->id }}">{{ $services->discount }}</span><input type="text" class="form-control" name="discount" id="discount-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->discount }}" hidden> </td>
                          <td><span id="span-discount_amt-{{ $services->id }}">{{ $services->discount_amt }}</span><input type="text" class="form-control" name="discount_amt" id="discount_amt-id-{{ $services->id }}" data-id="{{ $services->id }}" placeholder="0.00" value="{{ $services->discount_amt }}"  hidden> </td>
                          <td><span class="service-total-amount" id="span-total_amount-{{ $services->id }}">{{ $services->total_amount }}</span></td>
                          @if($services->type == 'individual')
                          <td>
                              @if($services->status == 'diagnosed' || $services->status == 'receipted')
                                <span class="badge bg-success">done</span>
                              @elseif($services->status == 'pending')
                                <span class="badge bg-warning">{{ $services->status }}</span>
                              @elseif($services->status == 'cancelled')
                                <span class="badge bg-danger">{{ $services->status }}</span>
                              @endif
                          </td>
                          @endif
                          @if($patientservice->cancelled == 'N')
                          <td id="td-actions">
                              @if($services->docdate >= date('Y-m-d'))
                                @can('amount-edit')
                                <a href="" class="btn btn-xs btn-info btn-edit-amount" id="btn-edit-{{ $services->id }}" data-id="{{ $services->id }}" data-service="{{ $services->service }}"><i class="fa fa-edit"></i> Edit</a>
                                <a href="" class="btn btn-xs btn-primary" id="btn-update-{{ $services->id }}" data-id="{{ $services->id }}" data-service="{{ $services->service }}" hidden>Update</a>
                                <a href="" class="btn btn-xs btn-secondary" id="btn-cancel-{{ $services->id }}" data-id="{{ $services->id }}" data-service="{{ $services->service }}" hidden>Cancel</a>
                                @endcan
                                @can('patientservices-item-remove')
                                <a href="" class="btn btn-xs btn-danger btn-remove-item" id="btn-remove-item-{{ $services->id }}" data-id="{{ $services->id }}" data-service="{{ $services->service }}"><i class="fa fa-trash"></i> Remove</a>
                                @endcan
                              @endif
                              @if(($services->status == 'diagnosed' || $services->status == 'receipted') && $services->type == 'individual')
                                <a href="{{ route('diagnosis.edit',$services->id) }}" id="btn-view-{{ $services->id }}" class="btn btn-xs btn-info" id="btn-view"><i class="fa fa-eye"></i> View</a>
                              @elseif($services->status == 'pending' && $services->type == 'individual' && $services->service)
                                @can('diagnosis-create')
                                  @if($services->service == 'Check-up')
                                  <a href="{{ route('diagnosis.create',$services->id) }}" id="btn-diagnose-{{ $services->id }}" class="btn btn-xs btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i>  Receipt</a>
                                  @elseif($services->to_diagnose == 'Y')
                                  <a href="{{ route('diagnosis.create',$services->id) }}" id="btn-diagnose-{{ $services->id }}" class="btn btn-xs btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i>  Diagnose</a>
                                  @endif
                                @endif
                              @endif
                          </td>
                          @endif
                        </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                          <tr>
                            <td class="text-right" colspan="6">
                              <strong><span class="pull-right">Grand Total :</span></strong>
                            </td>
                            <td><strong><span class="service-grand-total">{{ $patientservice->grand_total}}</span></strong></td>
                            @if($patientservice->type == 'individual')
                            <td></td>
                            @endif
                            @if($patientservice->cancelled == 'N')
                            <td>
                              @if($patientservice->docdate >= date('Y-m-d'))
                              <a href="" class="btn btn-xs btn-primary add-item" id="add-item" data-toggle="modal" data-target="#modal-service"><i class="fa fa-plus"></i> Add Item</a>
                              @endif
                            </td>
                            @endif
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
                        <textarea class="form-control" name="note" id="note" style="resize: none;">{{ $patientservice->note }}</textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  @if($patientservice->cancelled == 'N')
                    @can('patientservices-edit')
                    <button type="submit" id="btn-update" class="btn btn-primary" disabled>Update</button>
                    @endcan
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
<div class="modal fade" id="modal-service">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">New Service Procedure</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form role="form" id="new-service-form">
        <div class="card-body">
          <div class="row">
            <div class="form-group col-md-12">
              <label for="new-service">Service</label> <span class="text-danger">*</span>
              <select class="form-control select2" name="new-service" id="new-service" style="width: 100%;">
                <option selected="selected" value="" disabled>Select Service</option>'+
                @foreach($services_all as $service)
                <option value="{{ $service->id }}" data-service="{{ $service->service}}">{{ $service->service}}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="new-procedure">Procedure</label> <span class="text-danger">*</span>
              <select class="form-control select2" name="new-procedure" id="new-procedure" style="width: 100%;" disabled>
                <option selected="selected" value="" disabled>Select Procedure</option>
              </select>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="select2-description">Description</label>
              <select class="form-control select2" multiple="multiple" name="select2-description" id="select2-description" style="width: 100%;" disabled>
              </select>
              <input type="text" name="new-description" class="form-control" id="new-description" hidden>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="price">Price (PHP)</label> <span class="text-danger">*</span>
              <input type="text" name="new-price" class="form-control" id="new-price" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled>
            </div>
          </div>
          <div class="row" hidden>
            <div class="form-group col-md-12">
              <label for="medicine_amt">Medicine Amount (PHP)t</label>
              <input type="text" name="new-medicine_amt" class="form-control" id="new-medicine_amt" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="discount">Discount (%)</label>
              <div class="input-group">
                <input class="form-control input-small affect-total" type="text" name="new-discount" id="new-discount" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled>
                <div class="input-group-prepend"><span class="input-group-text">%</span></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="discount_amt">Discount Amount (PHP)</label>
              <input type="text" name="new-discount_amt" class="form-control" id="new-discount_amt" placeholder="0.00" data-inputmask-inputformat="0.00" data-mask disabled>
            </div>
          </div>
          <div class="row">
            <div class="form-group col-md-12">
              <label for="discount_amt">Total Amount: <span id="new-total_amount"> 0.00</span></label>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="modal-footer">
          <button type="reset" id="btn-cancel-modal" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" id="btn-save-modal" class="btn btn-primary">Save</button>
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

    $('#btn-update').click(function(e){

      e.preventDefault();

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

      e.preventDefault();

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

    $('#new-service-form').validate({
      rules: {
        "new-service": {
          required: true,
        },
        "new-procedure": {
          required: true,
        },
        "new-price": {
          number: true,
          required: true,
        },
      },
      messages: {
        "new-service": {
          required: "Please select service",
        },
        "new-procedure": {
          required: "Please select procedure",
        },
        "new-price": {
          required: "Please enter a price",
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

        $('#btn-save-modal').attr('disabled', true);

        var data = $('#new-service-form').serializeArray();
        data.push({ name: '_token', value: '{{ csrf_token() }}'});
        data.push({ name: 'total_amount', value: $('#new-total_amount').text() });

        $.ajax({
          url: "{{ route('patientservice.add_item', $patientservice->id) }}",
          method: "POST",
          data: data,
          success: function(response){
            console.log(response);

            if(response.success)
            {

              reset_modal();

              $('#modal-service').modal('toggle');

              Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Record has successfully added',
                    showConfirmButton: false,
                    timer: 2500
                });

              $('#table-services tbody').append(
                            '<tr id="row-id-'+response.service_item.id+'">'+
                              '<td>'+response.service_item.service+'</td>'+
                              '<td><span class="span-procedure" data-id="'+response.service_item.procedure_id+'">'+(response.service_item.is_multiple == 'Y' ? response.service_item.description : response.service_item.code)+'</span></td>'+
                              '<td><span id="span-price-'+response.service_item.id+'">'+response.service_item.price+'</span><input type="text" class="form-control" name="price" id="price-id-'+response.service_item.id+'" data-id="'+response.service_item.id+'" placeholder="0.00" value="'+response.service_item.price+'" hidden> </td>'+
                              '<td><span id="span-medicine_amt-'+response.service_item.id+'">'+response.service_item.medicine_amt+'</span><input type="text" class="form-control" name="medicine_amt" id="medicine_amt-id-'+response.service_item.id+'" data-id="'+response.service_item.id+'" placeholder="0.00" value="'+response.service_item.medicine_amt+'" hidden> </td>'+
                              '<td><span id="span-discount-'+response.service_item.id+'">'+response.service_item.discount+'</span><input type="text" class="form-control" name="discount" id="discount-id-'+response.service_item.id+'" data-id="'+response.service_item.id+'" placeholder="0.00" value="'+response.service_item.discount+'" hidden> </td>'+
                              '<td><span id="span-discount_amt-'+response.service_item.id+'">'+response.service_item.discount_amt+'</span><input type="text" class="form-control" name="discount_amt" id="discount_amt-id-'+response.service_item.id+'" data-id="'+response.service_item.id+'" placeholder="0.00" value="'+response.service_item.discount_amt+'"  hidden> </td>'+
                              '<td><span class="service-total-amount" id="span-total_amount-'+response.service_item.id+'">'+response.service_item.total_amount+'</span></td>'+
                              '<td>'+ (response.service_item.to_diagnose == "Y" ? '<span class="badge bg-warning">pending</span>' : '') +'</td>'+
                              '<td id="td-actions">'+
                                '<a href="" class="btn btn-xs btn-info btn-edit-amount" id="btn-edit-'+response.service_item.id+'" data-id="'+response.service_item.id+'" data-service="'+response.service_item.service+'" style="margin-right: .170rem;"><i class="fa fa-edit"></i> Edit</a>'+
                                '<a href="" class="btn btn-xs btn-primary" id="btn-update-'+response.service_item.id+'" data-id="'+response.service_item.id+'" data-service="'+response.service_item.service+'" style="margin-right: .170rem;" hidden>Update</a>'+
                                '<a href="" class="btn btn-xs btn-secondary" id="btn-cancel-'+response.service_item.id+'" data-id="'+response.service_item.id+'" data-service="'+response.service_item.service+'" hidden>Cancel</a>'+
                                @can('patientservices-item-remove')
                                  '<a href="" class="btn btn-xs btn-danger btn-remove-item" id="btn-remove-item-'+response.service_item.id+'" data-id="'+response.service_item.id+'" data-service="'+response.service_item.service+'"><i class="fa fa-trash"></i> Remove</a> '+
                                @endcan
                                @can('diagnosis-create')
                                  (response.service_item.service == 'Check-up' ? '<a href="/diagnosis/create/'+response.service_item.id+'" id="btn-diagnose-'+response.service_item.id+'" class="btn btn-xs btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i>  Receipt</a>': '') +
                                  (response.service_item.service != 'Check-up' && response.service_item.to_diagnose == 'Y' ? '<a href="/diagnosis/create/'+response.service_item.id+'" id="btn-diagnose-'+response.service_item.id+'" class="btn btn-xs btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i>  Diagnose</a>': '') +
                                @endcan
                              '</td>'+
                            '</tr>');
              // location.reload();
              table_actions();
              getGrandTotal();

            }

            $('#btn-save-modal').removeAttr('disabled');

          },
          error: function(response){
            console.log(response);
          }

        });
      }

    });


  table_actions();

  function table_actions()
  {
    $('#table-services').on('click', 'tbody td .btn-edit-amount', function(e){

      e.preventDefault();

      var ps_item_id = $(this).data('id');
      var service = $(this).data('service');

      $("#btn-update-"+ps_item_id).removeAttr('hidden');
      $("#btn-cancel-"+ps_item_id).removeAttr('hidden');
      $("#btn-edit-"+ps_item_id).attr('hidden', true);
      $("#btn-remove-item-"+ps_item_id).attr('hidden', true);
      $("#btn-view-"+ps_item_id).attr('hidden', true);
      $("#btn-diagnose-"+ps_item_id).attr('hidden', true);

      $('#price-id-'+ps_item_id).removeAttr('hidden');
      $('#discount-id-'+ps_item_id).removeAttr('hidden');
      $('#discount_amt-id-'+ps_item_id).removeAttr('hidden');

      if(service == 'Check-up')
      {
        $('#medicine_amt-id-'+ps_item_id).removeAttr('hidden');
        $('#span-medicine_amt-'+ps_item_id).attr('hidden', true);
      }


      $('#span-price-'+ps_item_id).attr('hidden', true);
      $('#span-discount-'+ps_item_id).attr('hidden', true);
      $('#span-discount_amt-'+ps_item_id).attr('hidden', true);



      $("#btn-update-"+ps_item_id).click(function(e){

        e.preventDefault();

        var ps_item_id = $(this).data('id');
        var price = $('#price-id-'+ps_item_id).val();
        var medicine_amt = $('#medicine_amt-id-'+ps_item_id).val();
        var discount = $('#discount-id-'+ps_item_id).val();
        var discount_amt = $('#discount_amt-id-'+ps_item_id).val();
        var total_amount = $('#span-total_amount-'+ps_item_id).text();
        var grand_total = $('.service-grand-total').text();


        if(!price)
        {
          price = 0.00;
        }

        if(!medicine_amt)
        {
          medicine_amt = 0.00;
        }

        if(!discount)
        {
          discount = 0.00;
        }

        if(!discount_amt)
        {
          discount_amt = 0.00;
        }

        $.ajax({
          url: "{{ route('patientservice.update_price') }}",
          method: "POST",
          data: {
                  _token: "{{ csrf_token() }}",
                  ps_item_id: ps_item_id,
                  price: price,
                  medicine_amt: medicine_amt,
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
                title: 'Amount has been updated',
                showConfirmButton: false,
                timer: 2500
              });

              console.log('asd');

              $('#price-id-'+ps_item_id).val(parseFloat(price).toFixed(2)).attr('hidden', true);
              $('#medicine_amt-id-'+ps_item_id).val(parseFloat(medicine_amt).toFixed(2)).attr('hidden', true);
              $('#discount-id-'+ps_item_id).val(parseFloat(discount).toFixed(2)).attr('hidden', true);
              $('#discount_amt-id-'+ps_item_id).val(parseFloat(discount_amt).toFixed(2)).attr('hidden', true);

              $('#span-price-'+ps_item_id).empty().append(parseFloat(price).toFixed(2));
              $('#span-medicine_amt-'+ps_item_id).empty().append(parseFloat(medicine_amt).toFixed(2));
              $('#span-discount-'+ps_item_id).empty().append(parseFloat(discount).toFixed(2));
              $('#span-discount_amt-'+ps_item_id).empty().append(parseFloat(discount_amt).toFixed(2));

              $('#span-price-'+ps_item_id).removeAttr('hidden');
              $('#span-medicine_amt-'+ps_item_id).removeAttr('hidden');
              $('#span-discount-'+ps_item_id).removeAttr('hidden');
              $('#span-discount_amt-'+ps_item_id).removeAttr('hidden');

              $("#btn-update-"+ps_item_id).attr('hidden', true);
              $("#btn-cancel-"+ps_item_id).attr('hidden', true);
              $("#btn-edit-"+ps_item_id).removeAttr('hidden');
              $("#btn-remove-item-"+ps_item_id).removeAttr('hidden');
              $("#btn-view-"+ps_item_id).removeAttr('hidden');
              $("#btn-diagnose-"+ps_item_id).removeAttr('hidden');

              getGrandTotal();

            }

          },
          error: function(response){
            console.log(response);
          }
        });

      });

      $("#btn-cancel-"+ps_item_id).click(function(e){

        e.preventDefault();

        var ps_item_id = $(this).data('id');

        reset(ps_item_id);

      });

    });

    $('#table-services').on('click', 'tbody td .btn-remove-item', function(e){

        e.preventDefault();

        var ps_items_id = $(this).data('id');

        Swal.fire({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#6c757d',
          confirmButtonText: 'Remove!'
        }).then((result) => {
          if (result.value) {

            $.ajax({
              url: "{{ route('patientservice.remove_item') }}",
              method: "POST",
              data: { _token: "{{ csrf_token() }}", ps_items_id: ps_items_id },
              success: function(response){
                console.log(response);

                if(response.success)
                {
                  Swal.fire(
                    'Removed!',
                    'Item has been removed.',
                    'success'
                  );
                  $('#row-id-'+ps_items_id).remove();
                  getGrandTotal();
                }

              },
              error: function(response){
                console.log(response);
              }
            });

          }
        });


      });

    //price text change
    $('#table-services').on('keyup input', 'tbody td input[name="price"]', function(e){

        // alert($(this).closest('td').parent()[0].sectionRowIndex);
        var ps_item_id = $(this).data('id');

        //call function compute_amounts
        compute_amounts(ps_item_id);

        //call function getGrandTotal
        getGrandTotal();

    });

    //medicine amount text change
    $('#table-services').on('keyup input', 'tbody td input[name="medicine_amt"]', function(e){

      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var ps_item_id = $(this).data('id');

      //call function compute_amounts
      compute_amounts(ps_item_id);

      //call function getGrandTotal
      getGrandTotal();

    });

    //discount text change
    $('#table-services').on('keyup input', 'tbody td input[name="discount"]', function(e){

      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var ps_item_id = $(this).data('id');

      //call function compute_amounts
      compute_amounts(ps_item_id);

      //call function getGrandTotal
      getGrandTotal();

    });

    //discount amount text change
    $('#table-services').on('keyup input', 'tbody td input[name="discount_amt"]', function(e){

      // alert($(this).closest('td').parent()[0].sectionRowIndex);
      var ps_item_id = $(this).data('id');

      //call function compute_amounts
      compute_amounts(ps_item_id);

      //call function getGrandTotal
      getGrandTotal();

    });

    //table elements input masks
    $('[name="price"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('[name="medicine_amt"]').inputmask('decimal', {
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

    $('#new-service').on('change', function(e){

      $('#new-procedure').removeAttr('disabled');

      $('#new-procedure').empty().append('<option selected="selected" value="" disabled>Select Procedure</option>');

      var procedures_id = [];  

      // insert all procedure id into variable used for filtering select option  
      $.each($('.span-procedure'), function(index, data){ 
        procedures_id[index] = parseInt(data.dataset.id);
      }); 
      
      $.each($('[name="description"]').find(':selected'), function(index, data){
        if($(this).val())
        {
          procedures_id[parseInt($(this).val())] = parseInt($(this).val());
        }
      });

      @foreach($procedures_all as $procedure)

        var id = parseInt("{{ $procedure->id }}");

        if($(this).val() == "{{ $procedure->serviceid }}" && !procedures_id.includes(id))
        {
          $('#new-procedure').append('<option value="{{ $procedure->id }}" data-service_id="{{ $procedure->serviceid }}" data-code="{{ $procedure->code }}" data-procedure="{{ $procedure->procedure }}" data-price="{{ $procedure->price }}"  data-is_multiple="{{ $procedure->is_multiple }}">{{ $procedure->code }}</option>');
        }

      @endforeach  

    });

  }

  $('#new-procedure').on('change', function(e){

    var price = $(this).find(':selected').data('price');
    var discount = $(this).find(':selected').data('discount');
    var discount_amt = $(this).find(':selected').data('discount_amt');
    var is_multiple = $(this).find(':selected').data('is_multiple');
    var procedure_id = $(this).val();
    var service_id = $('#new-service').val();

    $('#new-price').val(price);
    $('#new-discount').val(discount);
    $('#new-discount_amt').val(discount_amt);

    $('#new-price').removeAttr('disabled');
    $('#new-discount').removeAttr('disabled');
    $('#new-discount_amt').removeAttr('disabled');

    $('#new-total_amount').empty().append(price);

    if(is_multiple == 'Y')
    {
      $('#select2-description').removeAttr('disabled');
    }

    $('#select2-description').empty();

    @foreach($procedures_all as $procedure)

      if(service_id == "{{ $procedure->serviceid }}" && procedure_id != "{{ $procedure->id }}")
      {
        $('#select2-description').append('<option value="{{ $procedure->id }}" data-code="{{ $procedure->code }}" data-procedure="{{ $procedure->procedure }}" data-price="{{ $procedure->price }}">{{ $procedure->code }}</option>');
      }

    @endforeach

  });

  $('#select2-description').on('change', function(e){

    var price = $(this).find(':selected').data('price');
    var discount = $(this).find(':selected').data('discount');
    var discount_amt = $(this).find(':selected').data('discount_amt');
    var is_multiple = $(this).find(':selected').data('is_multiple');
    var procedure_id = $(this).val();
    var service_id = $('#new-service').val();
    var price_per_service = 0.00;
    var description = [];

    $.each($(this).find(':selected'), function(index, data){
      price_per_service = parseFloat(price_per_service) + parseFloat(this.dataset.price);
      description[index] = this.dataset.code;
    });

    // if description multiple select has value
    if($(this).find(':selected').length)
    {
      $('#new-description').val(description.join());
      $('#new-price').val(price_per_service);
    }
    else
    {
      $('#new-description').val('');
      $('#new-price').val(0);
    }

    compute_new_service();

  });

  //new price text change
  $('#new-price').on('keyup input', function(e){

    if($(this).val())
    {
      $('#new-discount').removeAttr('disabled');
      $('#new-discount_amt').removeAttr('disabled');
    }
    else
    {
      $('#new-discount').attr('disabled', true);
      $('#new-discount_amt').attr('disabled', true);
    }

    compute_new_service();

  });

  //new medicine amount text change
  $('#new-medicine_amt').on('keyup input', function(e){

    compute_new_service();

  });

  //new discount text change
  $('#new-discount').on('keyup input', function(e){

    compute_new_service();

  });

  //new discount amount text change
  $('#new-discount_amt').on('keyup input', function(e){

    compute_new_service();

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

    // alert(parseFloat(sum).toFixed(2));

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

  // compute the amounts of the edited service procedure
  function compute_amounts(ps_item_id)
  {
      var price = $('#price-id-'+ps_item_id).val();
      var medicine_amt = $('#medicine_amt-id-'+ps_item_id).val();
      var discount = $('#discount-id-'+ps_item_id).val();
      var discount_amt = $('#discount_amt-id-'+ps_item_id).val();

      var price_per_service;
      var medicine_amt_per_service;
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

      //if medicine amount has value
      if(medicine_amt)
      {
        medicine_amt_per_service = parseFloat(medicine_amt).toFixed(2);
      }
      else
      {
        medicine_amt_per_service = 0;
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
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#span-total_amount-'+ps_item_id).empty().append(parseFloat(total).toFixed(2));

      if(parseFloat(total) > 0 )
      {
        $('#btn-update-'+ps_item_id).removeClass('disabled');
        $('#span-total_amount-'+ps_item_id).removeClass('text-danger');
      }
      else
      {
        $('#btn-update-'+ps_item_id).addClass('disabled');
        $('#span-total_amount-'+ps_item_id).addClass('text-danger');
      }

  }

  // compute the amounts of the new service procedure
  function compute_new_service()
  {
      var price = $('#new-price').val();
      var medicine_amt = $('#new-medicine_amt').val();
      var discount = $('#new-discount').val();
      var discount_amt = $('#new-discount_amt').val();

      var price_per_service;
      var medicine_amt_per_service;
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

      //if medicine amount has value
      if(medicine_amt)
      {
        medicine_amt_per_service = parseFloat(medicine_amt).toFixed(2);
      }
      else
      {
        medicine_amt_per_service = 0;
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
      var total = parseFloat(price_per_service) + parseFloat(medicine_amt_per_service) - parseFloat(discount_amount) - parseFloat(discount_amt_per_service);

      //append total amount
      $('#new-total_amount').empty().append(parseFloat(total).toFixed(2));

      if(parseFloat(total) > 0 )
      {
        $('#btn-save-modal').removeAttr('disabled');
        $('#new-total_amount').removeClass('text-danger');
      }
      else
      {
        $('#btn-save-modal').attr('disabled', true);
        $('#new-total_amount').addClass('text-danger');
      }
  }

  // Reset row fields to default
  function reset(ps_item_id)
  {
      var price = $('#span-price-'+ps_item_id).text();
      var medicine_amt = $('#span-medicine_amt-'+ps_item_id).text();
      var discount = $('#span-discount-'+ps_item_id).text();
      var discount_amt = $('#span-discount_amt-'+ps_item_id).text();

      $('#price-id-'+ps_item_id).val(parseFloat(price).toFixed(2)).attr('hidden', true);
      $('#medicine_amt-id-'+ps_item_id).val(parseFloat(medicine_amt).toFixed(2)).attr('hidden', true);
      $('#discount-id-'+ps_item_id).val(parseFloat(discount).toFixed(2)).attr('hidden', true);
      $('#discount_amt-id-'+ps_item_id).val(parseFloat(discount_amt).toFixed(2)).attr('hidden', true);

      $('#btn-update-'+ps_item_id).removeClass('disabled');
      $('#span-total_amount-'+ps_item_id).removeClass('text-danger');
      $("#btn-update-"+ps_item_id).attr('hidden', true);
      $("#btn-cancel-"+ps_item_id).attr('hidden', true);
      $("#btn-edit-"+ps_item_id).removeAttr('hidden');
      $("#btn-remove-item-"+ps_item_id).removeAttr('hidden');
      $("#btn-view-"+ps_item_id).removeAttr('hidden');
      $("#btn-diagnose-"+ps_item_id).removeAttr('hidden');

      $('#price-id-'+ps_item_id).attr('hidden', true);
      $('#medicine_amt-id-'+ps_item_id).attr('hidden', true);
      $('#discount-id-'+ps_item_id).attr('hidden', true);
      $('#discount_amt-id-'+ps_item_id).attr('hidden', true);

      $('#span-price-'+ps_item_id).removeAttr('hidden');
      $('#span-medicine_amt-'+ps_item_id).removeAttr('hidden');
      $('#span-discount-'+ps_item_id).removeAttr('hidden');
      $('#span-discount_amt-'+ps_item_id).removeAttr('hidden');


      var discount_amount = parseFloat(price) * (parseFloat(discount).toFixed(2) / 100);
      var total = parseFloat(price) + parseFloat(medicine_amt) - parseFloat(discount_amount) - parseFloat(discount_amt);

      //append total amount
      $('#span-total_amount-'+ps_item_id).empty().append(parseFloat(total).toFixed(2));

      //call function getGrandTotal
      getGrandTotal();
  }

  $('#btn-cancel-modal, #add-item').click(function(e){
    e.preventDefault();
    reset_modal();
  });

  $('#new-service').on('change', function(e){

    $("[aria-labelledby='select2-new-service-container']").removeAttr('style');
    $('#new-service-error').remove();

  });

  $('#new-procedure').on('change', function(e){

    $("[aria-labelledby='select2-new-procedure-container']").removeAttr('style');
    $('#new-procedure-error').remove();

  });

  function reset_modal()
  {
    $('#new-service-form')[0].reset();
    $('#select2-new-service-container').empty().append('Select Service');
    $('#select2-new-procedure-container').empty().append('Select Procedure');
    $('#new-procedure').attr('disabled', true);
    $('#new-price').attr('disabled', true);
    $('#new-discount').attr('disabled', true);
    $('#new-discount_amt').attr('disabled', true);
    $('#new-total_amount').empty().append('0.00');

    $("[aria-labelledby='select2-new-service-container']").removeAttr('style');
    $('#new-service-error').remove();

    $("[aria-labelledby='select2-new-procedure-container']").removeAttr('style');
    $('#new-procedure-error').remove();

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


    $('[name="new-price"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('[name="new-medicine_amt"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });
    $('[name="new-discount"]').inputmask('decimal', {
      rightAlign: true,
      integerDigits:3,
      digits:2,
      allowMinus:false

    });
    $('[name="new-discount_amt"]').inputmask('decimal', {
      rightAlign: true,
      digits:2,
      allowMinus:false
    });

    $('.select2').select2();

});
</script>
@endsection

