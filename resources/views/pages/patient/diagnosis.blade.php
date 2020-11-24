
@extends('layouts.main')
@section('title', 'Diagnosis')
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
              <li class="breadcrumb-item"><a href="{{ route('patient.history', $patient_service->patient_id) }}">Patient History</a></li>
              <li class="breadcrumb-item active">Diagnosis</li>
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
                  <h3 class="card-title">Patient Diagnosis </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="patient">Patient: </label>
                      <h5>{{ $patient_service->name }}</h5>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="date">Diagnose Date: </label>
                      <h5>{{ $patient_service->docdate }}</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="age">Age: </label>
                      <h5>{{ $patient_service->age }}</h5>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="gender">Gender</label>
                      <h5>{{ $patient_service->gender }}</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="civil">Civil Status: </label>
                      <h5>{{ $patient_service->civilstatus }}</h5>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="mobile">Mobile #: </label>
                      <h5>{{ $patient_service->mobile }}</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="mobile">Address: </label>
                      <h5>{{ $patient_service->address }}</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="service">Service: </label>
                      <h5>{{ $patient_service->service }}</h5>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="file#">File #: </label>
                      <h5>{{ $patient_service->file_no }}</h5>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="title">Referring Physician</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="physician" id="physician" placeholder="Enter physician" value="{{ $patient_service->physician }}">
                      </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="title">Blood Pressure</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="bloodpressure" id="bloodpressure" placeholder="Enter blood pressure" value="{{ $patient_service->bloodpressure }}">
                      </div>
                    </div>
                  </div> 
                  <hr> 
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="title">Title</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ $patient_service->title }}">
                      </div>
                    </div>
                  </div> 
                  <label for="content">Content</label>
                  <div class="mb-3 div-content"> 
                    <textarea name="content" id="content" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"> {!! $patient_service->content !!}</textarea>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  <button type="submit" id="btn-update" class="btn btn-primary" disabled>Update & Download PDF</button>
                  <button type="submit" id="btn-download" class="btn btn-primary">Download PDF</button>
                </div>
              </div>
            </form>
            <!-- /.card -->
          </div>
          <!--/.col (left) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">

$(document).ready(function () {
  
  $('#btn-download').click(function(e){
    e.preventDefault();
    $(location).attr('href', "{{ route('diagnosis.print', $patient_service->ps_items_id)}}");
  });
  
  $('#btn-update').click(function(e){

    // e.preventDefault();

    if(!$('[name="content"]').val())
    { 
      $('#content-error').remove();
      $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
    }
  
    
    //Patient Form Validation
    $('#diagnosisform').validate({
      rules: {
        physician: {
          required: true,
        },
        bloodpressure: {
          required: true,
        },
        title: {
          required: true,
        },
      },
      messages: {
        physician: {
          required: "Please enter physician",
        },
        bloodpressure: {
          required: "Please enter blood pressure",
        },
        title: {
          required: "Please enter title",
        },
      },
      errorElement: 'span',
      errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
      },
      highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
      },
      submitHandler: function(e){

        var data = $('#diagnosisform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        
        $.ajax({
          url: "{{ route('diagnosis.update', $patient_service->diagnoses_id) }}",
          method: "POST",
          data: data,
          success: function(response){
            console.log(response);

            if(response.success)
            {
              // Sweet Alert
              Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Record has been updated',
                showConfirmButton: false,
                timer: 2500
              });
              $(location).attr('href', "{{ route('diagnosis.print', $patient_service->ps_items_id)}}");
            }
          },
          error: function(response){
            console.log(response);
          }
        });
        

      }
    });
  });

  //CKeditor
  ClassicEditor.create( document.querySelector( '#content' ) )
               .catch( error => {
                  console.error( error );
               });

  // $('.textarea').summernote();
  // $('.textarea').summernote({
  //   callbacks: {
  //   onKeyup: function(e) {
  //     if(!$('[name="content"]').val())
  //     { 
  //       $('#content-error').remove();
  //       $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
  //     }
  //     else
  //     {
  //       $('#content-error').remove();
  //     }
  //   }
  // }
  // });

  $('#diagnosisform').on('change input',function(e){
    
    $('#btn-update').attr('disabled', false);
   
  });


});
</script>
@endsection

