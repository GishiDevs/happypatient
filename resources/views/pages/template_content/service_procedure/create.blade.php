
@extends('layouts.main')
@section('title', 'Template Content')
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
              <li class="breadcrumb-item active">Template Content</li>
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
            <form role="form" data-url="{{ route('content.update', $template_content->procedureid) }}" method="POST" id="procedure-template-form">
              @csrf
              <!-- jquery validation -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Template Content </h3>
                </div>
                <div class="card-body pad col-md-12">
                  <label for="content">Content</label>
                  <div class="mb-3 div-content"> 
                    <textarea name="content" id="content" placeholder="Place some text here"
                                    style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;">
                      {{ $template_content->content }}                
                    </textarea>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-footer">
                  <button type="submit" id="btn-save" class="btn btn-primary">Save</button>
                  <button type="button" id="btn-preview" data-url="{{ route('content.preview', $template_content->procedureid) }}" class="btn btn-primary">Preview</button>
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
  
  $('#btn-save').click(function(e){
       
      e.preventDefault();

      var content = CKEDITOR.instances.content.getData();
      var url = $('#procedure-template-form').data('url'); 

      $.ajax({
        url: url,
        method: "POSt",
        data: { _token: "{{ csrf_token() }}", content: content },
        success: function(response){

          console.log(response);

          if(response.success)
          {
            // Sweet Alert
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Record has successfully added',
              showConfirmButton: false,
              timer: 2500
            });

            // window.location = "{{ route('serviceprocedure.index') }}";

          }
        },
        error: function(response){
          
        }
      });

      

      // var data = $('#procedure-template-form').serializeArray();
      // data.push({name: "_token", value: "{{ csrf_token() }}"});

      //   $.ajax({
      //     url: "{{ route('content.update', $template_content->procedureid) }}",
      //     method: "POST",
      //     data: data,
      //     success: function(response){
      //       console.log(response);

      //       if(response.success)
      //       {
              
      //         // Sweet Alert
      //         Swal.fire({
      //           position: 'center',
      //           icon: 'success',
      //           title: 'Record has successfully added',
      //           showConfirmButton: false,
      //           timer: 2500
      //         });

      //         $(location).attr('href', "{{ route('serviceprocedure.index')}}");
      //       }

      //     },
      //     error: function(response){
      //       console.log(response);
      //     }
      //   });

  });

  $('#btn-preview').click(function(e){

    var url = $(this).data('url');

    window.open(url, '_blank');
    
  });
  

  //CKeditor
  // ClassicEditor.create( document.querySelector( '#content' ) )
  //              .catch( error => {
  //                 console.error( error );
  //              });
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

