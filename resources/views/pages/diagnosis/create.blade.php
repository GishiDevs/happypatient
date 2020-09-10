
@extends('layouts.main')
@section('title', 'Add Diagnosis')
@section('main_content')                                
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Patient Diagnosis</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Add Diagnosis</li>
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
                <h3 class="card-title">Add Diagnosis </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" id="diagnosisform">
                <div class="card-body">
                  <!-- <div class="row">
                    <div class="form-group col-md-4">
                      <label for="lastname">Lastname</label> <span class="text-danger">*</span>
                      <input type="text" name="lastname" class="form-control" id="lastname" placeholder="Enter lastname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="firstname">Firstname</label> <span class="text-danger">*</span>
                      <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Enter firstname">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="middlename">Middlename</label>
                      <input type="text" class="form-control" name="middlename" id="middlename" placeholder="Enter middlename">
                    </div>
                  </div> -->
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">

$(document).ready(function () {

  

});
</script>
@endsection

