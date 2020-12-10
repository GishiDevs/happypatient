
@extends('layouts.main')
@section('title', 'Template Content')
@section('main_content')                                
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Medical Certificate Content</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Medical Certificate Content</li>
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
            <form role="form" action="{{ route('certificate.template.store') }}" method="POST" id="certificate-template-form">
              @csrf
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Template Content </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <div class="row">
                    <div class="form-group col-md-4">
                      <label for="lastname">Template Name</label> <span class="text-danger">*</span>
                      <input type="text" name="template_name" class="form-control" id="template_name" placeholder="Enter template name">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <label for="content">Content</label>
                      <div class="mb-3 div-content"> 
                        <textarea name="content" id="content" placeholder="Place some text here"
                                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  <button type="submit" id="btn-save" class="btn btn-primary">Save</button>
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
<script type="text/javascript" src="{{ asset('dist/js/ckeditor_style.js') }}"></script>
<script type="text/javascript">

$(document).ready(function () {

  let content;

  //CKeditor
  // ClassicEditor.create( document.querySelector( '#content' ) )
  //              .then( newContent => {
  //               content = newContent;
  //              })
  //              .catch( error => {
  //                 console.error( error );
  //              });

  $('#template_name').keyup(function(){
    if($(this).val())
    {
      $('#template_name').removeClass('is-invalid');
      $('#template_name-error').remove();
    }
  });

  $('#btn-save').click(function(e){

    e.preventDefault();

    if($('#template_name').val())
    { 
      // console.log(content.getData());
      $('#certificate-template-form').submit();

      // Sweet Alert
      Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Record has successfully added',
        showConfirmButton: false,
        timer: 2500
      });

    }
    else
    { 
      $('#template_name-error').remove();
      $('#template_name').addClass('is-invalid');
      $('#template_name').after('<span id="template_name-error" class="error invalid-feedback">Template Name is required</span>');
    }

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

});
</script>
@endsection

