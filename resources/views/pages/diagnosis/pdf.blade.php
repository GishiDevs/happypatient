<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Print Preview | {{ $patient_service->service }}</title>
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

        p {
            margin-bottom: 0;
        }

        .color-violet {
            color: #7030a0;
        }

        .user_name {
            font-size: 15px;

        }

        .user_subtitle {
            width: 250px;
            font-size: 12px;

        }

        .font-candara {
            font-family: 'Candara';
        }

        * {
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari */
            color-adjust: exact !important;                 /*Firefox*/
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

        <div class="d-flex flex-row justify-content-center justify-content-xl-center align-items-xl-start">
            <div><img src="{{ asset('dist/img/docsHeader/hpdc_logo.png') }}" style="height: 160px;" /></div>
            <div class="mt-2"><img src="{{ asset('dist/img/docsHeader/separator.png') }}" /></div>
            <div class="d-flex flex-column align-items-xl-start mt-3 ml-3">
                <div><img src="{{ asset('dist/img/docsHeader/hpdc_description.png') }}" /></div>
                <div class="mt-2"><img src="{{ asset('dist/img/docsHeader/hpdc_address.png') }}" /></div>
                <div class="d-flex justify-content-sm-center align-items-sm-center w-100 mt-3 bg-darkk text-primary text-uppercase"
                    style="height: 50px;">
                    <h2 class="my-0">{{ $patient_service->service }} Report</h2>
                </div>
            </div>
        </div>

        <div class="font-candara text-uppercase font-weight-bold font-italic" style="font-size: 17px;">
            <div class="container">
                <div class="d-flex d-sm-flex flex-row justify-content-sm-end">
                    <p class="my-0 mr-5">Date: {{ $patient_service->docdate }}</p>
                    <p class="my-0">File#: {{ $patient_service->file_no }}</p>
                </div>
                <div class="d-flex flex-row justify-content-lg-start align-items-lg-center">
                    <p class="my-0">Name of patient: {{ strtoupper($patient_service->name) }}</p>
                </div>
                <div class="d-flex flex-column justify-content-lg-start align-items-lg-start pl-5 ml-5 mt-3 font-weight-light">
                    <div class="d-flex justify-content-between" style="width: 400px;">
                        <p class="my-0">Age:
                            <span style="font-size: 17px" id="age"></span>
                        </p>
                        <p class="my-0">Gender: {{ strtoupper($patient_service->gender) }}</p>
                        <p class="my-0">C.S.: {{ strtoupper($patient_service->civilstatus) }}</p>
                    </div>
                    <p class="my-0">Address: {{ $patient_service->address . ' ' . $patient_service->location}}</p>
                    <p class="my-0">referring physician: {{ strtoupper($patient_service->physician) }}</p>
                </div>
            </div>
        </div>

        <div class="container mt-2">
            <div class="text-center border-top border-bottom border-dark py-2">
                <h4 class="text-break text-uppercase text-info my-0">{{ $patient_service->title }}</h4>
            </div>

            <div class="{{ "off" === "on" ? "d-flex justify-content-around" : "d-flex flex-column" }}">

            <div class="font-candara" style="font-size: 18px;">
                {!! $patient_service->content !!}
            </div>

            <div class="color-violet mt-3 d-flex justify-content-around align-items-sm-center">

                <div class="{{ $patient_service->service === "Laboratory" ? "d-sm-block" : "d-sm-none" }} d-flex flex-column justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img class="img-fluid" src="{{ asset('dist/img/docsHeader/geraldine.png') }}" /></div>
                    <div class="text-nowrap">
                        <h6 class="text-uppercase font-weight-bold user_name my-0">GERALDINE M. AGPES, MD, FPSP</h6>
                    </div>
                    <div class="user_subtitle text-break text-center">
                        <p class="text-center my-0">Pathologist</p>
                        <p class="text-center my-0">License# : 0093398</p>
                    </div>
                </div>

                @foreach($diagnosis_signatories as $item)

                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <div class="d-flex flex-column justify-content-center align-items-center">
                            <img class="img-fluid" src="{{ asset('dist/img/docsHeader/default.png') }}" /></div>
                        <div class="text-nowrap">
                            <h6 class="text-uppercase font-weight-bold user_name my-0">{{ $item->users->name }}</h6>
                        </div>
                        <div class="user_subtitle text-break text-center">
                            <p class="text-center my-0">{{ $item->users->description }}</p>
                            <p class="text-center my-0">License# : {{ $item->users->license }}</p>
                        </div>
                    </div>

                @endforeach


                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <img class="img-fluid" src="{{ asset('dist/img/docsHeader/default.png') }}" /></div>
                    <div class="text-nowrap">
                        <h6 class="text-uppercase font-weight-bold user_name my-0"> {{ Auth::user()->name }}</h6>
                    </div>
                    <div class="user_subtitle text-break text-center">
                        <p class="text-center my-0">{{ Auth::user()->description }}</p>
                        <p class="text-center my-0">License# : {{ Auth::user()->license }}</p>
                    </div>
                </div>

            </div>

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
    <script>
        var dob = '{{ $patient_service->birthdate }}';
        var birthdate = dob.split('/');
        var bdate = birthdate[2] + '-' + birthdate[0] + '-' + birthdate[1];
        var getdocdate = '{{ $patient_service->docdate }}'.split('/');
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

        $('#age').empty().append(age);

    </script>

</body>

</html>
