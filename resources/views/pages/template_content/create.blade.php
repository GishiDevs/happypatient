
@extends('layouts.main')
@section('title', 'Add Template Content')
@section('main_content')                                
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Template Content</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item"><a href="{{ route('serviceprocedure.index') }}">Service Procedure Record</a></li>
              <li class="breadcrumb-item active">Add Template Content</li>
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
            <form role="form" id="diagnosisform">
              <!-- @csrf -->
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Template Content </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <label for="content">Content</label>
                  <div class="mb-3 div-content"> 
                    <textarea name="content" id="content" class="textarea" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  <button type="submit" id="btn-add" class="btn btn-primary">Add</button>
                  <!-- <button type="submit" id="btn-download" class="btn btn-primary">Download</button> -->
                </div>
              </div>
            </form>
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

 

  $('#btn-add').click(function(e){

    // e.preventDefault();
        
        $.ajax({
          url: "",
          method: "POST",
          data: data,
          success: function(response){
            console.log(response);

            if(response.success)
            {
              $('#diagnosisform')[0].reset();
              
              // Sweet Alert
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has successfully added',
                showConfirmButton: false,
                timer: 2500
              });
            }

          },
          error: function(response){
            console.log(response);
          }
        });

  });

  // $('.textarea').summernote();
  $('.textarea').summernote({
    callbacks: {
    onKeyup: function(e) {
      if(!$('[name="content"]').val())
      { 
        $('#content-error').remove();
        $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
      }
      else
      {
        $('#content-error').remove();
      }
    }
  }
  });

});
</script>
@endsection

