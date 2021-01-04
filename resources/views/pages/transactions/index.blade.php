
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
                  <!-- <div class="form-group col-md-4">
                    <label for="">Filter by Service: </label>
                    <select class="form-control select2" name="service" id="service" style="width: 100%;">
                      <option selected="selected" value="0">All Services</option>
                      @foreach($services as $service)
                      <option value="{{ $service->service }}" data-service="{{ $service->service }}" data-serviceid="{{ $service->id }}">{{ $service->service}}</option>
                      @endforeach
                    </select>
                  </div> -->
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
                                    <input class="custom-control-input" name="service[]" type="checkbox" id="checkbox-serviceid-{{ $service->id }}" value="{{ $service->id }}">
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
                  <!-- <div class="form-group col-md-4">
                    <label>Filter Date From:</label>
                    <div class="input-group date" id="filter-date-from" data-target-input="nearest">
                      <input type="text" id="date-from" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="{{ date('m/d/Y') }}" data-target="#filter-date-from" readonly/>
                      <div class="input-group-append" data-target="#filter-date-from" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label>Filter Date To:</label>
                    <div class="input-group date" id="filter-date-to" data-target-input="nearest">
                      <input type="text" id="date-to" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="{{ date('m/d/Y') }}" data-target="#filter-date-to" readonly/>
                        <div class="input-group-append" data-target="#filter-date-to" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                  </div> -->
                </div>
                <div class="row">
                  <div class="table-scrollable col-md-12 table-responsive">
                    <table id="transactions" class="table table-hover">
                      <thead>
                        <tr>
                          <th class="no-sort">ID</th>
                          <th class="no-sort">Document Date</th>
                          <th class="no-sort">Patient/Organization</th>
                          <th class="no-sort">Service</th>
                          <th class="no-sort">Name</th>
                          <th class="no-sort">Procedure</th>
                          <th class="no-sort">Amount (PHP)</th>
                          <th class="no-sort">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- @foreach($transactions as $index => $transaction)
                        <tr>
                          <td>{{ $index+1 }}</td>
                          <td>{{ $transaction->docdate }}</td>
                          <td>{{ $transaction->name }}</td>
                          <td>{{ $transaction->service }}</td>
                          <td>{{ $transaction->procedure }}</td>
                          <td>{{ $transaction->total_amount }}</td>
                        </tr>
                        @endforeach -->
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="text-right" colspan="6">Grand Total:</th>
                          <th colspan="2"> <span id="grand_total">0.00</span> </th>
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

    $('.select2').select2();

    // get_transactions();

    // $("#filter-date-from, #filter-date-to").on("change.datetimepicker", function(e){
    //   var date_from = $('#date-from').val();
    //   var date_to = $('#date-to').val();

    //   // if date-from or date-to texfield has value
    //   if(date_from || date_to)
    //   {
    //     get_transactions();
    //   }

    // });

    // $('#service').on('change', function () {
    //   get_transactions();
    // });
    // $('#filter-date-from').datetimepicker({
    //     format: 'L',
    //     useCurrent: false,
    //     ignoreReadonly: true

    // });

    // $('#filter-date-to').datetimepicker({
    //     format: 'L',
    //     useCurrent: false,
    //     ignoreReadonly: true
    // });



    get_transactions();

    $('.custom-checkbox [name="service[]"]').click(function(){
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
          "searching": true,
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "destroy": true,
          "serverSide": true,
          "ajax": {
            url: "{{ route('gettransactions') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", services: services, serviceid: serviceid, date_from: date_from, date_to: date_to  },
            // success: function(response){
            //   console.log(response);
            // }
          },
          "bDestroy": true,
          "columns": [
                      { "data": "id"},
                      { "data": "docdate"},
                      { "data": "name"},
                      { "data": "service"},
                      { "data": "code"},
                      { "data": "code"},
                      { "data": "total_amount"},
                      { "data": "status"},

          ],
          order: [],
          rowGroup: {
              dataSrc: [ 'id' , 'name', 'service' ],

              startRender: function(rows, group, group_index) {

                var group_label = group;

                if(group_index == 0)
                {
                  // group_label = rows.data()[0]['docdate']  + ' - ' + rows.data()[0]['name'].toUpperCase() ;
                  group_label = rows.data()[0]['name'].toUpperCase() ;
                }

                $('.dtrg-level-1').remove();

                return group_label.bold();

              },

              endRender: function(rows, group, group_index) {
                // return null;
              },
          },
          columnDefs: [
            {
              targets: [ 0, 1, 2, 3 ],
              visible: false
            },
            {
              targets: 'no-sort', orderable : false
            },
            {
              targets: 4,
              render: function( data ) {
                return '';
              }
            },
            {
              targets: 6,
              render: function( data ) {
                var check_if_decimal = (data - Math.floor( data ));
                var total_amount = new Intl.NumberFormat().format( data );

                if(!check_if_decimal)
                {
                  total_amount = total_amount + '.00';
                }
                
                return total_amount;
              }
            },
            {
              targets: 7,
              render: function ( data ) {
                  if(data == 'diagnosed' || data == 'receipted')
                  {
                    return '<span class="badge bg-success">done</span>';
                  }
                  else if(data == 'pending')
                  {
                    return '<span class="badge bg-warning">'+data+'</span>';
                  }
                  else if(data == 'cancelled')
                  {
                    return '<span class="badge bg-danger">'+data+'</span>';
                  }

                }
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
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );


            var page_total = new Intl.NumberFormat().format( pageTotal );
            var check_if_decimal = (pageTotal - Math.floor( pageTotal ));

            if(!check_if_decimal)
            {
              page_total = page_total + '.00';
            }      

            // Update footer
            $( api.column( 6 ).footer() ).html(page_total);
        }

      });

    }

    $('.btn-group a').click(function(e){
      e.preventDefault();
      var param = $(this).data('param');
      window.location = '/transactions_preview/'+param;
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

