
@extends('layouts.main')
@section('title', 'Transactions')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>Transactions</h1> -->
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
                <h3 class="card-title">Transactions list for {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime(date('Y-m-d')))) !!}</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="table-scrollable col-md-12 table-bordered table-responsive">
                    <table id="transactions" class="table table-hover">
                      <thead>
                        <tr>
                          <th class="no-sort">Service</th>
                          <th class="no-sort">Amount (PHP)</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th class="text-right">Grand Total:</th>
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
    
    function get_transactions()
    { 

      var dt = $('#transactions').DataTable({
          // "lengthMenu": [[20, 30, 50, -1], [20, 30, 50, "All"]],
          "searching": false,
          "responsive": true,
          "autoWidth": false,
          "processing": true,
          "destroy": true,
          "serverSide": true,
          "ajax": "",
          "bDestroy": true,
          "columns": "",
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
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 1 ).footer() ).html(pageTotal.toFixed(2));
        }

      });

    }

    $('.main-footer').remove();

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
      if(data.action == 'create-patient-services' || data.action == 'edit-patient-services' || data.action == 'cancel-patient-services' 
         || data.action == 'edit-service-amount' || data.action == 'edit-service-amount')
      {
        get_transactions();
      }

    });
        
	});

</script>
@endsection

