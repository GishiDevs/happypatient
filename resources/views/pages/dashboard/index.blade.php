
@extends('layouts.main')
@section('title', 'Dashboard')
@section('main_content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Dashboard</h1>
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
                {{-- <h3 class="card-title">Patient record list for today {{ date('Y-m-d') }}</h3> --}}
                <h3 class="card-title">Patient record list for {!! htmlspecialchars_decode(date('j<\s\up>S</\s\up> F Y', strtotime(date('Y-m-d')))) !!}</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="patient-table" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="30px">#</th>
                      <th>ID</th>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th width="50px">Status</th>
                    </tr>
                  </thead>
                  <!-- <tfoot>
                    <tr>
                      <th>Document Date</th>
                      <th>Patient Name</th>
                      <th>Service</th>
                      <th>Status</th>
                    </tr>
                  </tfoot> -->
                </table>

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

  </div>

  <script>

  $(document).ready(function() {

			// $('#tax-table').DataTable();
	  $('#patient-table').DataTable({
        "responsive": true,
        "autoWidth": false,
		    "processing": true,
		    "serverSide": true,
		    "ajax": "{{ route('patientservice.servicesperuser') }}",
		    "bDestroy": true,
		    "columns": [
                    { "data": "DT_RowIndex"},
                    { "data": "id"},
		    		        { "data": "docdate"},
		    		        { "data": "patientname"},
		    		        { "data": "service"},
                    { "data": "status"}
		    ],
        "order": [[ 1, "asc" ], 
                  [ 2, "asc" ], 
                  [ 4, "asc" ], 
                  [ 3, "asc" ]
        ],

        "columnDefs": [
          { "visible": false, "targets": 1 },
          { "targets": 0,"orderable": false }

        ]
        // "bSort" : false 
        
        
        
    });
	});

</script>

@endsection

