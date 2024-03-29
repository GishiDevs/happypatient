
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
              <li class="breadcrumb-item"><a href="{{ route('patientservice.edit', $patient_service->id) }}">Patient Services</a></li>
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
            <form role="form"  method="POST" id="diagnosisform">
              @csrf
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Patient Diagnosis </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="patient">Patient: </label>
                      <div>{{ strtoupper($patient_service->name) }}</div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="date">Diagnose Date: </label>
                      <div>{{ $patient_service->docdate }}</div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="age">Age: </label>
                      <div class="age"></div>
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
                      <label for="bloodpressure">O2 Sat:</label>
                      <div>{{ $patient_service->o2_sat }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="temperature">Pulse Rate:</label>
                      <div>{{ $patient_service->pulserate }}</div>
                    </div>
                    <div class="form-group col-md-3">
                      <label for="weight">LMP:</label>
                      <div>{{ $patient_service->lmp }}</div>
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
                      <div>{{ $patient_service->file_no }}</div>
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
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter title" value="{{ $patient_service->title }}">
                      </div>
                    </div>
                  </div>
                  <label for="content">Content</label>
                  <div class="mb-3 div-content">
                    <textarea name="content" id="content" placeholder="Place some text here"> {!! $patient_service->content !!}</textarea>
                  </div>

                  <hr>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="content">Select Signatories:</label>
                      @foreach($service_signatories as $item)
                        <div class="col-md-4">
                          <div class="custom-control custom-checkbox">
                            <input class="custom-control-input" name="signatories[]" type="checkbox" id="checkbox-userid-{{ $item->userid }}" value="{{ $item->userid }}" @if(in_array($item->userid, $diagnosis_signatories)) checked @endif>
                            <label for="checkbox-userid-{{ $item->userid }}" class="custom-control-label">{{ $item->users->name }}</label>
                          </div>
                        </div>
                       @endforeach
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  @can('diagnosis-edit')
                  <button type="submit" id="btn-update" class="btn btn-primary">Update & Preview</button>
                  @endcan
                  <button type="submit" id="btn-preview" class="btn btn-primary">Preview</button>
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

<script type="text/javascript" src="{{ asset('dist/js/ckeditor_style.js') }}"></script>

<script type="text/javascript">

$(document).ready(function () {

  var dob = '{{ $patient_service->birthdate }}';
  var birthdate = dob.split('/');
  var bdate = birthdate[2] + '-' + birthdate[0] + '-' + birthdate[1];
  var getdocdate = '{{ $patient_service->docdate }}'.split('/');
  var documentdate = getdocdate[2] + '-' + getdocdate[0] + '-' + getdocdate[1];
  var docdate = moment(documentdate, 'YYYY-MM-DD');
  var age = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'year');

  $('#age').val(age);
  $('.age').empty().append(age);

  $('#docdate').on('keyup', function(){
    getdocdate = $('#docdate').val().split('/');
    documentdate = getdocdate[2] + '-' + getdocdate[0] + '-' + getdocdate[1];
    docdate = moment(documentdate, 'YYYY-MM-DD');
    age = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'year');
    $('#age').val(age);
    $('.age').empty().append(age);
  });

  $('#btn-preview').click(function(e){
    e.preventDefault();
    //download pdf
    // $(location).attr('href', "{{ route('diagnosis.print', $patient_service->ps_items_id)}}");
    window.open("{{ route('diagnosis.print', $patient_service->ps_items_id)}}", '_blank');
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

        var content = CKEDITOR.instances.content.getData();
        var data = $('#diagnosisform').serializeArray();
        data.push({name: "_token", value: "{{ csrf_token() }}"});
        data.push({name: "content", value: content});
        
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

              //download pdf
              // $(location).attr('href', "{{ route('diagnosis.print', $patient_service->ps_items_id)}}");
              window.open("{{ route('diagnosis.print', $patient_service->ps_items_id)}}", '_blank');
              $('#content-error').remove();
            }
            else if(response.content)
            {
              $('#content-error').remove();
              $('.div-content').append('<span id="content-error" class="text-danger" style="width: 100%; margin-top: .25rem; font-size: 80%;">Please enter some content</span>');
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



});
</script>
@endsection

