
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
                <div class="table-scrollable col-md-12 table-responsive">
                  <table id="transactions-table" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="40px" class="no-sort">#</th>
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
                        <th>{{ number_format($grand_total, 2, '.','') }}</th>
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

        
	});

</script>
@endsection

