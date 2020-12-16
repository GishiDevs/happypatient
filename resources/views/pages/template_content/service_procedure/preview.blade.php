<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Template Preview</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <!-- Moment Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

    <style>

        @font-face {
            font-family: "Candara";
            src: url('{{ asset('dist/fonts/Candara.woff2') }}') format('woff2'),
                    url('{{ asset('dist/fonts/Candara.woff') }}') format('woff');
            font-style: normal;
            font-weight: normal;
        }

        .font-candara {
            font-family: 'Candara';
        }

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
            color-adjust: exact !important;                 /*Firefox*/
        }

        p {
            margin-bottom: 0;
        }
        
        .bg-darkk {
            background-color: lightgrey;
        }

        figure table {
        border-collapse: collapse !important;
        }

        figure table td{
        border: 1px solid black !important;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        {{-- <img class="img-fluid" src="{{ asset('dist/img/docsHeader/docsHeader.png') }}"> --}}

        <div class="d-flex flex-row justify-content-center justify-content-xl-center align-items-xl-start">
            <div><img src="{{ asset('dist/img/docsHeader/hpdc_logo.png') }}" style="height: 160px;" /></div>
            <div class="mt-2"><img src="{{ asset('dist/img/docsHeader/separator.png') }}" /></div>
            <div class="d-flex flex-column align-items-xl-start mt-3 ml-3">
                <div><img src="{{ asset('dist/img/docsHeader/hpdc_description.png') }}" /></div>
                <div class="mt-2"><img src="{{ asset('dist/img/docsHeader/hpdc_address.png') }}" /></div>
                <div class="d-flex justify-content-sm-center align-items-sm-center w-100 mt-3 bg-darkk text-primary text-uppercase"
                    style="height: 50px;">
                    <h2 class="my-0">Report</h2>
                </div>
            </div>
        </div>

        <div class="font-candara text-uppercase font-weight-bold font-italic" style="font-size: 17px;">
            <div class="container">
                <div class="d-flex d-sm-flex flex-row justify-content-sm-end">
                    <p class="my-0 mr-5">Date:</p>
                    <p class="my-0">File#:</p>
                </div>
                <div class="d-flex flex-row justify-content-lg-start align-items-lg-center">
                    <p class="my-0">Name of patient: </p>
                </div>
                <div class="d-flex flex-column justify-content-lg-start align-items-lg-start pl-5 ml-5 mt-3 font-weight-light">
                    <div class="d-flex justify-content-between" style="width: 400px;">
                        <p class="my-0">Age:
                            <span style="font-size: 17px" id="age"></span>
                        </p>
                        <p class="my-0">Gender:</p>
                        <p class="my-0">C.S.: </p>
                    </div>
                    <p class="my-0">Address:</p>
                    <p class="my-0">referring physician:</p>
                </div>
            </div>
        </div>

        <div class="container mt-2">
            <div class="text-center border-top border-bottom border-dark py-2">
                <h4 class="text-break text-uppercase text-info my-0">sample title</h4>
            </div>

            <div class="font-candara">
                {!! $template_content->content !!}
            </div>

        </div>

    </div>

    <!-- JS, Popper.js, and jQuery -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
    </script>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
    </script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>


</body>

</html>

