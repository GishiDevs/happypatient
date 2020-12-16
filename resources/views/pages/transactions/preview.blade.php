
@extends('layouts.main')
@section('title', 'Transactions')
@section('main_content')
  
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <!-- <div class="col-sm-6">
            <h1>Transactions</h1>
            <h5>Date: <strong>@if($date_from == $date_to) {{ $date_to }} @else {{ $date_from }} to {{ $date_to }}  @endif</strong></h5>
          </div> -->
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
                <h5><strong>Transactions list dated @if($date_from == $date_to) {{ $date_to }} @else {{ $date_from }} to {{ $date_to }}  @endif</strong></h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="table-scrollable col-md-12 table-responsive">
                    <table id="transactions" class="table table-bordered table-hover">
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
<!-- /.content-wrapper -->
<script>

  $(document).ready(function() {
    var grand_total_column = 1;
    var services = [];
    var columns = [
                      { "data": "service"},
                      { "data": "total_amount"},
                  ];

    var dataSrc = [ 'service', 'name'];
    var columnTarget = [];
    var isCheckup = '{{ $isCheckup }}';
    
    $('footer').attr('hidden', true);
    $('nav').attr('hidden', true);
    $('aside').remove();
                  
    
    get_transactions();

    function get_transactions()
    {

      var date_from = "{{ $date_from }}";
      var date_to = "{{ $date_to }}";
      var str = '{{ $services }}';
      // var services = str.split(',');
      if(str)
      {
        services = str.split(',');
      }

      console.log(str);
      console.log(services);

      if(services.length)
      { 

        columns = [
          {"data": "name"},
          {"data": "total_amount"},
        ];

        grand_total_column = 1;
        dataSrc = ['service'];

        if(isCheckup == 'true')
        {
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

      }   

      var dt = $('#transactions').DataTable({
          "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],
          "searching": false,
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "destroy": true,
          "serverSide": true,
          "info": false,         // Will show "1 to n of n entries" Text at bottom
          "lengthChange": false, // Will Disabled Record number per page
          "paging": false,
          "ajax": {
            url: "{{ route('getreports') }}",
            type: "POST",
            data: { _token: "{{ csrf_token() }}", services: services, date_from: date_from, date_to: date_to  },
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

