
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
            <form role="form" id="diagnosisform">
              @csrf
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Add Diagnosis </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="patient">Patient: </label>
                      <div>{{ strtoupper($patient_service->name) }}</div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="docdate">Diagnose Date</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" class="form-control" name="docdate" id="docdate" data-inputmask-alias="datetime" data-inputmask-inputformat="mm/dd/yyyy" data-mask placeholder="mm/dd/yyyy" value="{{ date('m/d/Y') }}">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="age">Age: </label>
                      <div class='age'></div>
                      <input type="text" class="form-control" name="age" id="age" hidden>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="gender">Gender:</label>
                      <div>{{ strtoupper($patient_service->gender) }}</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="civil">Civil Status: </label>
                      <div>{{ strtoupper($patient_service->civilstatus) }}</div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="mobile">Mobile #: </label>
                      <div>{{ $patient_service->mobile }}</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="mobile">Address: </label>
                      <div>{{ $patient_service->address . ' ' . $patient_service->location}}</div>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="bloodpressure">Blood Pressure:</label>
                      <div>{{ $patient_service->bloodpressure }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="temperature">Temperature (°C):</label>
                      <div>{{ $patient_service->temperature }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="weight">Weight (Kg):</label>
                      <div>{{ $patient_service->weight }}</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-3">
                      <label for="service">Service: </label>
                      <div>{{ $patient_service->service }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="procedure">Procedure: </label>
                      <div>{{ $patient_service->procedure }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="file#">File #: </label>
                      <div>{{ $file_no }} <input type="text" name="file_no" value="{{ $file_no }}" hidden></div>
                    </div>
                  </div>    
                  <hr>
                  <div class="row">
                    <div class="form-group col-md-6">
                      <label for="notes">Notes:</label>
                      <div class="input-group">
                        <div>{{ $patient_service->note }}</div>
                      </div>
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
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="title">Title</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value='{{ $patient_service->procedure }}'>
                      </div>
                    </div>
                  </div> 
                  <label for="content">Content</label>
                  <div class="mb-3 div-content"> 
                    <textarea name="content" id="content" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      {{ $patient_service->content }}
                    </textarea>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  <button type="submit" id="btn-add" class="btn btn-primary">Add & Preview</button>
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

  var dob = '{{ $patient_service->birthdate }}';
  var birthdate = dob.split('/');
  var bdate = birthdate[2] + '-' + birthdate[0] + '-' + birthdate[1];
  var getdocdate = $('#docdate').val().split('/');
  var documentdate = getdocdate[2] + '-' + getdocdate[0] + '-' + getdocdate[1];
  var docdate = moment(documentdate, 'YYYY-MM-DD');
  var year_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'year');
  var month_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'month');
  var day_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'day');
  var age = year_old;

  if(year_old == 0)
  { 
    age = month_old + ' MOS.'

    if(month_old == 0)
    {
      age = day_old + ' DAYS'
    }

  }

  $('#age').val(age);
  $('.age').empty().append(age);

  $('#docdate').on('keyup', function(){
    getdocdate = $('#docdate').val().split('/');
    documentdate = getdocdate[2] + '-' + getdocdate[0] + '-' + getdocdate[1];
    docdate = moment(documentdate, 'YYYY-MM-DD');
    year_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'year');
    month_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'month');
    day_old = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'day');

    if(year_old == 0)
    { 
      age = month_old + ' MOS.'

      if(month_old == 0)
      {
        age = day_old + ' DAYS'
      }

    }

    $('#age').val(age);
    $('.age').empty().append(age);
  });


  $('#btn-add').click(function(e){

    // e.preventDefault();

    if(!$('[name="content"]').val())
    { 
      $('#content-error').remove();
      $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
    }
  
    
    //Patient Form Validation
    $('#diagnosisform').validate({
      rules: {
        // physician: {
        //   required: true,
        // },
        bloodpressure: {
          required: true,
        },
        title: {
          required: true,
        },
      },
      messages: {
        // physician: {
        //   required: "Please enter physician",
        // },
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

        $('#btn-add').attr('disabled', true);

        var data = $('#diagnosisform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        
        $.ajax({
          url: "{{ route('diagnosis.store', $patient_service->ps_items_id) }}",
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

              // $(location).attr('href', "{{ route('diagnosis.print', $patient_service->ps_items_id)}}");
              window.open("{{ route('diagnosis.print', $patient_service->ps_items_id)}}", '_blank');
              $(location).attr('href', "{{ route('dashboard.index')}}");
              $('#content-error').remove();
            }
            else if(response.content)
            {
              $('#content-error').remove();
              $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
            }

            $('#btn-add').removeAttr('disabled');
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

  $('[data-mask]').inputmask();

});
</script>
@endsection

