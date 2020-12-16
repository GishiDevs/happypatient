
@extends('layouts.main')
@section('title', 'Transactions')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Transactions</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                {{-- <h3 class="card-title">Transactions for today {{ date('Y-m-d') }}</h3> --}}
                <h3 class="card-title">Transactions list for {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime(date('Y-m-d')))) !!}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-12">
                    <button type="button" id="btn-preview" class="btn btn-primary float-right">
                      <i class="fa fa-print"></i> Preview 
                    </button>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-flex justify-content-center">
                    <div class="card">
                      <div class="card-header d-flex justify-content-center">
                        <h5 class="card-title m-0">Filter by Service</h5>
                      </div>
                      <div class="card-body">
                        <div class="form-group col-md-12">
                          <div class="form-group">
                            <div class="row">
                            @foreach($services as $service)
                              <div class="col-md-4">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" name="service[]" type="checkbox" id="checkbox-serviceid-{{ $service->id }}" value="{{ $service->id }}" data-service="{{ $service->service }}">
                                  <label for="checkbox-serviceid-{{ $service->id }}" class="custom-control-label">{{ $service->service }}</label>
                                </div>
                              </div>
                            @endforeach
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 d-flex justify-content-center mt-3">
                    <div class="form-group mr-5">
                      <label>Filter Date From:</label>
                      <div class="input-group date" id="filter-date-from" data-target-input="nearest">
                        <input type="text" id="date-from" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="{{ date('m/d/Y') }}" data-target="#filter-date-from" readonly/>
                        <div class="input-group-append" data-target="#filter-date-from" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Filter Date To:</label>
                      <div class="input-group date" id="filter-date-to" data-target-input="nearest">
                        <input type="text" id="date-to" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="{{ date('m/d/Y') }}" data-target="#filter-date-to" readonly/>
                          <div class="input-group-append" data-target="#filter-date-to" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="table-scrollable col-md-12 table-responsive">
                    <table id="transactions" class="table table-hover">
                      <thead>
                        <tr>
                          <th id="th-name" class="no-sort" hidden>Name</th>
                          <th id="th-service" class="no-sort">Service</th>
                          <th id="th-code" class="no-sort" hidden>Code Name</th>
                          <th id="th-procedure" class="no-sort" hidden>Doctor/Specialist</th>
                          <th id="th-price" class="no-sort" hidden>Price (PHP)</th>
                          <th id="th-medicine_amt" class="no-sort" hidden>Medicine Amt (PHP)</th>
                          <th id="th-discount" class="no-sort" hidden>Discount (%)</th>
                          <th id="th-discount_amt" class="no-sort" hidden>Discount (PHP)</th>
                          <th id="th-total_amount" class="no-sort">Total (PHP)</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td class="text-right"><strong>Grand Total:</strong></th>
                          <td> <span id="grand_total"><strong>0.00</strong></span> </th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script>

  $(document).ready(function() {
    
    var grand_total_column = 1;
    var isCheckup = false;
    var services = [];
    // var columns = [
    //                   { "data": "name"},
    //                   { "data": "service"},
    //                   { "data": "code"},
    //                   { "data": "procedure"},
    //                   { "data": "price"},
    //                   { "data": "medicine_amt"},
    //                   { "data": "discount"},
    //                   { "data": "discount_amt"},
    //                   { "data": "total_amount"},
    //               ];
    var columns = [
                      { "data": "service"},
                      { "data": "total_amount"},
                  ];

    var dataSrc = [ 'service', 'name'];
    var columnTarget = [];

    $('.select2').select2();

    // get_transactions();

    $("#filter-date-from, #filter-date-to").on("change.datetimepicker", function(e){
      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();

      // if date-from or date-to texfield has value
      if(date_from || date_to)
      {
        get_transactions();
      }

      console.log(columns);

    });

  
    $('#filter-date-from').datetimepicker({
        format: 'L',
        useCurrent: false,
        ignoreReadonly: true

    });

    $('#filter-date-to').datetimepicker({
        format: 'L',
        useCurrent: false,
        ignoreReadonly: true
    });

    get_transactions();

    $('.custom-checkbox [name="service[]"]').click(function(){

      $('#transactions tfoot').empty().append('<tr>'+
                                                '<td class="text-right"><strong>Grand Total:</strong></th>'+
                                                '<td> <span id="grand_total"><strong>0.00</strong></span> </th>'+
                                              '</tr>');
      $('#transactions').DataTable().clear();

      services = [];

      dataSrc = [];

      grand_total_column = 1; 

      columns = [
                      { "data": "service"},
                      { "data": "total_amount"},
                  ];
      

      $.each($("input[name='service[]']:checked"), function(){
        services.push($(this).val());
      });

      // console.log(services);
        $('#th-service').removeAttr('hidden');
        $('#th-name').attr('hidden', true);
        $('#th-code').attr('hidden', true);
        $('#th-procedure').attr('hidden', true);
        $('#th-price').attr('hidden', true);
        $('#th-medicine_amt').attr('hidden', true);

      if(services.length)
      { 

        columns = [
          {"data": "name"},
          {"data": "total_amount"},
        ];

        grand_total_column = 1;
        dataSrc = ['service'];

        if($(this).data('service') == 'Check-up')
        { 
          
          //set value true when service filter is Check-up
          isCheckup = true;

          $('[name="service[]"').each(function(){
            if($(this).data('service') != 'Check-up')
            {
              $(this).prop('checked', false);
            }
          });

          $('#transactions tfoot').empty().append('<tr>'+
                                                  '<td class="text-right" colspan="3"><strong>Grand Total:</strong></th>'+
                                                  '<td> <span id="grand_total"><strong>0.00</strong></span> </th>'+
                                                '</tr>');
          columns = [
                      { "data": "procedure"},
                      { "data": "price"},
                      { "data": "medicine_amt"},
                      { "data": "total_amount"},
                    ];    

          grand_total_column = 3; 
          dataSrc = ['service', 'procedure'];
          $('#th-service').attr('hidden', true);
          $('#th-procedure').removeAttr('hidden');
          $('#th-price').removeAttr('hidden');
          $('#th-medicine_amt').removeAttr('hidden');

        }
        else
        {
          $('[name="service[]"').each(function(){
            if($(this).data('service') == 'Check-up')
            {
              $(this).prop('checked', false);
            }
          });

          isCheckup = false;
          
        }

      }

      get_transactions();

    });

    $('[data-mask]').inputmask();

    function get_transactions()
    {

      var serviceid = $('#service').find(':selected').data('serviceid');
      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();
      var grand_total = 0;
      var services = [];

      $.each($("input[name='service[]']:checked"), function(){
        services.push($(this).val());
      });

      // if date-from or date-to texfield has no value
      if(!date_to)
      {
        date_to = "{{ date('m/d/Y') }}";
      }

      if(!date_from)
      {
        date_from = "{{ date('m/d/Y') }}";
      }

      var dt = $('#transactions').DataTable({
          "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],
          "searching": false,
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "destroy": true,
          "serverSide": true,
          "ajax": {
            url: "{{ route('getreports') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", services: services, serviceid: serviceid, date_from: date_from, date_to: date_to  },
            // success: function(response){
            //   console.log(response);
            // },
            // error: function(response){
            //   console.log(response);
            // },
            
          },
          "bDestroy": true,
          "columns": columns,
          order: [],
          rowGroup: {
              dataSrc: dataSrc,

              startRender: function(rows, group, group_index) {

                var group_label = group;

                if(group_index == 0)
                {
                  // group_label = rows.data()[0]['docdate']  + ' - ' + rows.data()[0]['name'].toUpperCase() ;
                  group_label = rows.data()[0]['service'].toUpperCase();
                }
                
                // $('.dtrg-level-1').remove();
                return group_label.bold();

              },

              endRender: function(rows, group, group_index) {
                // return null;
                if(services.length == 0)
                { 
                  $('.dtrg-level-0').remove();
                }
                $('.dtrg-level-1').remove();
              },
          },
          columnDefs: [
            {
              targets: columnTarget,
              visible: false
            },
            {
              targets: 'no-sort', orderable : false
            },
            
          ],
          footerCallback: function ( row, data, start, end, display ) {

            var api = this.api(), data;

            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };


            // Total over this page
            pageTotal = api
                .column( grand_total_column )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

            // Update footer
            $( api.column( grand_total_column ).footer() ).html(pageTotal.toFixed(2).bold());

          }

      });


    }

    $('#btn-preview').click(function(e){
      e.preventDefault();
      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();
      var services = [];

      $.each($("input[name='service[]']:checked"), function(){
        services.push($(this).val());
      });

      // if date-from or date-to texfield has no value
      if(!date_to)
      {
        date_to = "{{ date('m/d/Y') }}";
      }

      if(!date_from)
      {
        date_from = "{{ date('m/d/Y') }}";
      }
  
      window.open("reports/preview?services="+services+"&date_from="+date_from+"&date_to="+date_to+"&isCheckup="+isCheckup, '_blank');

    });

    // PUSHER

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher( "{{ env('PUSHER_APP_KEY') }}" , {
      cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
      encrypted: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('happypatient-event');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('App\\Events\\EventNotification', function(data) {

      console.log(data.action);

      //PUSHER - refresh data when table patient_services or patient_service_items has changes
      if(data.action == 'edit-patient' || data.action == 'create-patient-services' || data.action == 'edit-patient-services' || data.action == 'cancel-patient-services'
         || data.action == 'edit-service-amount' || data.action == 'add-service-item' || data.action == 'remove-service-item')
      {
        get_transactions();
      }

    });

	});

</script>
@endsection

