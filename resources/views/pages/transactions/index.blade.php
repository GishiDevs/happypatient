
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
                <div class="form-group col-md-3">
                  <label for="">Filter by Service: </label>
                  <select class="form-control select2" name="service" id="service" style="width: 100%;">
                    <option selected="selected" value="">All Services</option>
                    @foreach($services as $service)
                    <option value="{{ $service->service }}" data-service="{{ $service->service}}" data-serviceid="{{ $service->serviceid}}">{{ $service->service}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="table-scrollable col-md-12">
                  <table id="transactions-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="40px">#</th>
                        <th>Patient Name</th>
                        <th>Service</th>
                        <th>Procedure</th>
                        <th>Amount (PHP)</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($transactions as $index => $transaction)
                      <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $transaction->patientname }}</td>
                        <td>{{ $transaction->service }}</td>
                        <td>{{ $transaction->procedure }}</td>
                        <td>{{ $transaction->total_amount }}</td>
                      </tr>
                      @endforeach
                    </tbody>
                    <tfoot>
                      <tr>
                        <th colspan="4">Grand Total:</th>
                        <th> <span id="grand_total">{{ number_format($grand_total, 2, '.','') }}</span> </th>
                      </tr>
                    </tfoot>
                  </table>
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
    
    var table =  $('#transactions-table').DataTable();
    
     $('#service').on('change', function () {

        table.columns(2).search( this.value ).draw();

        // var column_amounts = table.columns(4).nodes()[0];
        
        // console.log(column_amounts);

        // $.each(column_amounts, function(index, value){
        //   alert(value.textContent);
        // });

        var serviceid = $(this).find(':selected').data('serviceid'); 
          alert(serviceid);
        $.ajax({
          url: "{{ route('gettotalamount') }}",
          method: "POST",
          data: {_token: "{{ csrf_token() }}", serviceid: serviceid },
          success: function(response){
            console.log(response);
          },
          error: function(response){
            console.log(response);
          }
        });


     });

     $('#transactions-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
        "searching": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bDestroy": true,
        "order": [],
        "columnDefs": [{
                          "targets": [0, 1, 2, 3, 4],
                          "orderable": false
                        },] 
    });


        
	});

  

</script>
@endsection

