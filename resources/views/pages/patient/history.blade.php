
@extends('layouts.main')
@section('title', 'Patient Services')
@section('main_content')
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patient History</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('patient.index') }}">Patient Record</a></li>
              <li class="breadcrumb-item active">History</li>
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
                <h3 class="card-title">Patient History</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="patientserviceform" method="POST">
                @csrf
                <div class="card-body">
                  <div class="row"> 
                    <div class="form-group col-md-3">
                      <label for="patient">Patient Name:</label>
                      <div>{{ strtoupper($patient->lastname . ',  ' . $patient->firstname . ' ' . $patient->middlename) }}</div>
                    </div>  
                    <div class="form-group col-md-3">
                      <label for="birthdate">Birthdate:</label>
                      <div>{{ $patient->birthdate}}</div>
                    </div>   
                    <!-- <div class="form-group col-md-3">
                      <label for="age">Age:</label>
                      <div>{{ $patient->age}}</div>
                    </div>       -->
                    <div class="form-group col-md-3">
                      <label for="gender">Gender:</label>
                      <div>{{ strtoupper($patient->gender) }}</div>
                    </div>  
                    <div class="form-group col-md-3">
                      <label for="civilstatus">Civil Status:</label>
                      <div>{{ strtoupper($patient->civilstatus) }}</div>
                    </div>
                  </div>
                  <!-- <div class="row"> 
                    <div class="form-group col-md-3">
                      <label for="gender">Gender:</label>
                      <div>{{ $patient->gender }}</div>
                    </div>  
                    <div class="form-group col-md-3">
                      <label for="civilstatus">Civil Status:</label>
                      <div>{{ $patient->civilstatus }}</div>
                    </div>   
                    <div class="form-group col-md-3">
                      <label for="weight">Weight (Kg):</label>
                      <div>{{ $patient->weight}}</div>
                    </div>      
                  </div> -->
                  <hr>
                  <div class="row"> 
                    <div class="form-group col-md-3">
                      <label for="landline">Landline:</label>
                      <div>{{ $patient->landline }}</div>
                    </div>  
                    <div class="form-group col-md-3">
                      <label for="mobile">Mobile:</label>
                      <div>{{ $patient->mobile }}</div>
                    </div>   
                    <div class="form-group col-md-3">
                      <label for="email">Email:</label>
                      <div>{{ $patient->email}}</div>
                    </div>      
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="address">Address:</label>
                      <div>{{ $patient->address }}</div>
                    </div>  
                  </div>
                  <div class="row"> 
                    <div class="form-group col-md-3">
                      <label for="provice">Province:</label>
                      <div>{{ $patient->province }}</div>
                    </div>   
                    <div class="form-group col-md-3">
                      <label for="city">City:</label>
                      <div>{{ $patient->city}}</div>
                    </div>    
                    <div class="form-group col-md-3">
                      <label for="barangay">Barangay:</label>
                      <div>{{ $patient->barangay}}</div>
                    </div>  
                  </div>
                  <hr>
                  <div class="row">
                    <div class="table-scrollable col-md-12 table-responsive">
                      <table class="table table-striped table-bordered table-hover" id="table-services">
                        <thead>
                          <!-- <th>Official Receipt No.</th> -->
                          <th>Document Date</th>
                          <th>Services</th>
                          <th>Procedures</th>
                          <th>Price (PHP)</th>
                          <th>Medicine (PHP)</th>
                          <th>Discount (%)</th>
                          <th>Discount (PHP)</th>
                          <th>Total (PHP)</th>
                          <th>Status</th>
                          <th width="100px"  class="no-sort">Action</th>
                        </thead>
                        <tbody>			
                        @foreach($patientservices as $services)
                        <tr>
                          <!-- <td>{{ $services->or_number }}</td> -->
                          <td>{{ $services->docdate }}</td>
                          <td>{{ $services->service }}</td>
                          <td>
                            @if($services->service == 'Check-up')
                              {{ $services->procedure }}
                            @elseif($services->is_multiple == 'Y')
                              {{ $services->description }}
                            @else
                              {{ $services->code }}
                            @endif
                          </td>
                          <td>{{ number_format($services->price, 2, '.', ',') }}</td>
                          <td>{{ $services->medicine_amt }}</td>
                          <td>{{ $services->discount }}</td>
                          <td>{{ $services->discount_amt }}</td>
                          <td>{{ number_format($services->total_amount, 2, '.', ',') }}</td>
                          <td>
                              @if($services->status == 'diagnosed' || $services->status == 'receipted')
                              <span class="badge bg-success">done</span>
                              @elseif($services->status == 'pending')
                              <span class="badge bg-warning">{{ $services->status }}</span>
                              @elseif($services->status == 'cancelled')
                              <span class="badge bg-danger">{{ $services->status }}</span>
                              @endif
                          </td>
                          <td>
                              @if($services->status == 'diagnosed' || $services->status == 'receipted')
                                <a href="{{ route('diagnosis.edit',$services->id) }}" class="btn btn-xs btn-info" id="btn-view"><i class="fa fa-eye"></i> View</a> 
                              @elseif($services->status == 'pending')
                                @can('diagnosis-create')
                                <a href="{{ route('diagnosis.create',$services->id) }}" class="btn btn-xs btn-success" id="btn-create-diagnosis"><i class="fa fa-edit"></i> @if($services->service == 'Check-up') Receipt @else Diagnose @endif</a>
                                @endcan
                              @endif 
                          </td>
                        </tr>
                        @endforeach									
                        </tbody>
                      </table>
                    </div>				
                  </div>
                </div>
                <!-- <div class="card-footer">
                  <button type="submit" id="btn-update" class="btn btn-primary" disabled>Update</button>
                </div> -->
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
  
  // $('#table-services').DataTable({
  //       "responsive": true,
  //       "autoWidth": false,
	// 	    "processing": true,
  //       "columnDefs": [{
  //                         "targets": "no-sort",
  //                         "orderable": false
  //                       }] 
  //   });
});
</script>
@endsection

