
@extends('layouts.main')
@section('title', 'Dashboard')
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
                  <div class="form-group col-md-4">
                    <label for="">Filter by Service: </label>
                    <select class="form-control select2" name="service" id="service" style="width: 100%;">
                      <option selected="selected" value="0">All Services</option>
                      @foreach($services as $service)
                      <option value="{{ $service->service }}" data-service="{{ $service->service }}" data-serviceid="{{ $service->id }}">{{ $service->service}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <label>Filter Date From:</label>
                    <div class="input-group date" id="filter-date-from" data-target-input="nearest">
                      <input type="text" id="date-from" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" data-target="#filter-date-from" value="{{ date('m/d/Y') }}" readonly/>
                      <div class="input-group-append" data-target="#filter-date-from" data-toggle="datetimepicker">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-4">
                    <label>Filter Date To:</label>
                    <div class="input-group date" id="filter-date-to" data-target-input="nearest">
                      <input type="text" id="date-to" class="form-control datetimepicker-input" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" data-target="#filter-date-to" value="{{ date('m/d/Y') }}" readonly/>
                        <div class="input-group-append" data-target="#filter-date-to" data-toggle="datetimepicker">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="table-scrollable col-md-12 table-responsive">
                    <table id="transactions-table" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th width="40px">#</th>
                          <th>Document Date</th>
                          <th>Patient/Organization</th>
                          <th>Service</th>
                          <th>Code Name</th>
                          <th>Procedure</th>
                          <th>Amount (PHP)</th>
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
                          <th> <span id="grand_total">0.00</span> </th>
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

    // get_transactions();
    
    $('.select2').select2();
    
    // var table =  $('#transactions-table').DataTable();
    
    $('#service').on('change', function () {

        // table.columns(3).search( this.value ).draw();

        // var column_amounts = table.columns(4).nodes()[0];
        
        // console.log(column_amounts);

        // $.each(column_amounts, function(index, value){
        //   alert(value.textContent);
        // });
        get_transactions();
    });


    $("#filter-date-from, #filter-date-to").on("change.datetimepicker", function(e){
      get_transactions();
    });

    // $('#date_from, #date_to').keyup(function(e){
    //   // get_transactions();
    // });

    

    // $.fn.dataTable.ext.search.push(
    // function (settings, data, dataIndex) {
    //     var FilterStart = $('#date_from').val();
    //     var FilterEnd = $('#date_to').val();
    //     var DataTableStart = data[1].trim();
    //     var DataTableEnd = data[1].trim();
    //     if (FilterStart == '' || FilterEnd == '') {
    //         return true;
    //     }
    //     if (DataTableStart >= FilterStart && DataTableEnd <= FilterEnd)
    //     {
    //         return true;
    //     }
    //     else {
    //         return false;
    //     }
        
    // });

    //  $('#transactions-table').DataTable({
    //     "responsive": true,
    //     "autoWidth": false,
		//     "processing": true,
    //     "searching": false,
    //     "bPaginate": false,
    //     "bLengthChange": false,
    //     "bDestroy": true,
    //     "order": [],
    //     "columnDefs": [{
    //                       "targets": [0, 1, 2, 3, 4,5],
    //                       "orderable": false
    //                     },] 
    // });

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

    $('[data-mask]').inputmask();


    function get_transactions()
    { 

      var serviceid = $('#service').find(':selected').data('serviceid'); 
      var date_from = $('#date-from').val();
      var date_to = $('#date-to').val();  

      $.ajax({
          url: "{{ route('gettransactions') }}",
          method: "POST",
          data: { _token: "{{ csrf_token() }}", serviceid: serviceid, date_from: date_from, date_to: date_to  },
          success: function(response){
            // console.log(response);

            if(response.transactions)
            { 
              $('#grand_total').empty().append(parseFloat(response.grand_total).toFixed(2));

              $('#transactions-table tbody').empty();

              $.each(response.transactions, function(index, value){
                index++;
                $('#transactions-table tbody').append(
                  '<tr>'+
                    '<td>'+index+'</td>'+
                    '<td>'+value.docdate+'</td>'+
                    '<td>'+value.name+'</td>'+
                    '<td>'+value.service+'</td>'+
                    '<td>'+value.code+'</td>'+
                    '<td>'+value.procedure+'</td>'+
                    '<td>'+value.total_amount+'</td>'+
                  '</tr>'
                );

              });

            }
            else
            {
              $('#grand_total').empty().append('{{ number_format($grand_total, 2, '.','') }}');
            }


            if(response.transactions.length == 0)
            {
              $('#transactions-table tbody').append('<tr><td class="dataTables_empty text-center" colspan="7">No data available in table</td></tr>');
            }

          },
          error: function(response){
            console.log(response);
          }
      });
    }

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
      if(data.action == 'create-patient-services' || data.action == 'edit-patient-services' || data.action == 'cancel-patient-services' || data.action == 'edit-service-amount')
      {
        get_transactions();
      }

    });
        
	});

</script>
@endsection

