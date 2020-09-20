
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
                  <div class="row"> 
                    <div class="form-group col-md-3 div-patient">
                      <label for="patient">Patient:</label>
                      <h5>{{ $patientservice->patientname }}</h5>
                    </div>
                    <div class="form-group col-md-3 div-docdate">
                      <label for="selectPatient">Document Date: </label>
                      <h5>{{ date('m/d/Y', strtotime($patientservice->docdate)) }}</h5>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="bloodpressure">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure" value="{{ $patientservice->bloodpressure }}">
                      </div>
                    </div> 
                    <div class="form-group col-md-3">
                      <label for="OfficialReceipt">Official Receipt No.</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="or_number" id="or_number" value="{{ $patientservice->or_number }}">
                      </div>
                    </div>           
                  </div>
                  <hr>
                  <div class="row">
                    <div class="table-scrollable col-md-10">
                      <table class="table table-striped table-bordered table-hover" id="table-services">
                        <thead>
                          <th width="20%">Services</th>
                          <th width="15%">Price (PHP)</th>
                          <th width="15%">Discount</th>
                          <th width="15%">Total Amount (PHP)</th>
                          <th width="5%">Status</th>
                          <th width="5%">Action</th>
                        </thead>
                        <tbody>			
                        @foreach($patientserviceitems as $services)
                        <tr>
                          <td>{{ $services->service }}</td>
                          <td>{{ $services->price }}</td>
                          <td>{{ $services->discount }}</td>
                          <td>{{ $services->total_amount }}</td>
                          <td>
                              @if($services->status == 'diagnosed')
                                <span class="badge bg-success">{{ $services->status }}</span>
                              @elseif($services->status == 'pending')
                                <span class="badge bg-warning">{{ $services->status }}</span>
                              @elseif($services->status == 'cancelled')
                                <span class="badge bg-danger">{{ $services->status }}</span>
                              @endif
                          </td>
                          <td>
                              <a href="{{ route('diagnosis.edit',$services->id) }}" class="btn btn-sm btn-info @if($services->status == 'pending') disabled @endif" data-ps-items-id="{{ $services->id }}" data-action="view" id="btn-view"><i class="fa fa-eye"></i> View</a>  
                          </td>
                        </tr>
                        @endforeach									
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="3">
                              <strong><span class="pull-right">Grand Total :</span></strong>
                            </td>
                            <td><strong><span class="service-grand-total">{{ $patientservice->grand_total}}</span></strong></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="Notes">Notes</label>
                      <div class="input-group">
                        <textarea class="form-control" name="note" id="note" style="resize: none;">{{ $patientservice->note }}</textarea>
                      </div>
                    </div>						
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" id="btn-update" class="btn btn-primary" disabled>Update</button>
                  @if($patientservice->cancelled == 'N')
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
<script type="text/javascript">

$(document).ready(function () {
  
    $('#btn-update').click(function(e){ 

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

});
</script>
@endsection

