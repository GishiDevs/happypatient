<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Untitled</title>
    <!-- CSS only -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    {{-- <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="assets/css/styles.css"> --}}
    <!-- Moment Plugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
</head>

<body>
    <div class="container-fluid">
        <img class="img-fluid" src="{{ asset('dist/img/docsHeader/docsHeader.png') }}">


        <div class="table-responsive" style="border-style: none;">
            <table class="table table-borderless table-sm">
                <thead class="invisible" style="border-style: none;">
                    <tr>
                        <th>Column 1</th>
                        <th>Column 1</th>
                        <th>Column 2</th>
                        <th>Column 2</th>
                    </tr>
                </thead>
                <tbody style="border-style: none;">
                    <tr style="border-style: none;border-color: rgb(255,255,255);border-top-style: none;">
                        <td style="border-style: none;border-color: rgba(33,37,41,0);height: 10px;"></td>
                        <td style="width: 25%;border-style: none;border-color: rgb(255,255,255);"></td>
                        <td style="width: 25%;border-style: none;border-color: rgb(255,255,255);"><strong style="font-size: 10PX;"><em>DATE:&nbsp;</em></strong><span style="font-size: 10PX;">{{ $patient_service->docdate }}</span></td>
                        <td style="width: 25%;border-style: none;"><strong style="font-size: 10PX;"><em>FILE #:&nbsp;</em></strong><span style="font-size: 10PX;">{{ $patient_service->file_no }}</span></td>
                    </tr>
                    <tr>
                        <td style="font-size: 12PX;width: 10%;" colspan="4"><strong><em>NAME OF PATIENT:&nbsp;</em></strong><span style="font-size: 12PX;">{{ $patient_service->name }}</span></td>
                    </tr>
                    <tr style="border-style: none;border-color: rgb(255,255,255);border-top-style: none;">
                        <td class="text-right" style="border-style: none;border-color: rgb(255,255,255);"><strong style="font-size: 10PX;"><em>AGE:&nbsp;</em></strong><span style="font-size: 10PX;" id="age"></span></td>
                        <td class="text-center" style="border-style: none;border-color: rgb(255,255,255);"><strong style="font-size: 10PX;"><em>GENDER:&nbsp;</em></strong><span style="font-size: 10PX;">{{ $patient_service->gender }}</span></td>
                        <td style="border-style: none;"><strong style="font-size: 10PX;"><em>C.S.&nbsp;</em></strong><span style="font-size: 10PX;">{{ $patient_service->civilstatus }}</span></td>
                    </tr>
                    <tr style="border-style: none;border-color: rgb(255,255,255);border-top-style: none;">
                        <td class="text-right" style="border-style: none;border-color: rgb(255,255,255);"><strong style="font-size: 10PX;"><em>ADDRESS :</em></strong></td>
                        <td class="text-left" style="border-style: none;border-color: rgb(255,255,255);padding: 0;padding-top: 4.8PX;" colspan="3"><span style="font-size: 10PX;">{{ $patient_service->address }}</span></td>
                    </tr>
                    <tr style="border-style: none;border-color: rgb(255,255,255);border-top-style: none;">
                        <td class="text-right" style="border-style: none;border-color: rgb(255,255,255);"><strong style="font-size: 10PX;"><em>REFERRING PHYSICIAN:&nbsp;</em></strong></td>
                        <td class="text-left" style="border-style: none;border-color: rgb(255,255,255);padding: 0;padding-top: 4.8PX;" colspan="3"><span style="font-size: 10PX;">{{ $patient_service->physician }}</span></td>
                    </tr>
                    <tr></tr>
                    <tr>
                        <td class="text-uppercase text-center text-danger" colspan="4" style="height: 25px;"></td>
                    </tr>
                    <tr>
                        <td class="text-uppercase" colspan="4" style="height: 10px;border-width: 1px;border-top-style: solid;"></td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-center text-danger" style="font-size: 12px;text-align: center;" colspan="4"><strong style="font-size: 12px;">{{ $patient_service->title }}</strong></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 10px;border-width: 1px;border-bottom-style: solid;"></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 25px;border-style: none;"></td>
                    </tr>
                    <tr>
                        <!-- <td class="text-uppercase text-center text-danger" style="font-size: 12px;text-align: center;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);"
                            colspan="4">
                            <p style="color: rgb(0,0,0);text-align: left;">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Arcu non odio euismod lacinia at. Non odio euismod lacinia at quis risus sed vulputate odio. Lorem
                                ipsum dolor sit amet consectetur adipiscing elit ut aliquam. Arcu cursus vitae congue mauris rhoncus. Semper quis lectus nulla at. In arcu cursus euismod quis viverra. Sed nisi lacus sed viverra tellus. Dui faucibus in
                                ornare quam viverra. Neque ornare aenean euismod elementum nisi quis eleifend.<br></p>
                        </td> -->
                        <td colspan="4">
                            <p style="color: rgb(0,0,0);text-align: left;">{!! $patient_service->content !!}</p>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="height: 25px;border-style: none;"></td>
                    </tr>
                    <!-- <tr>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"
                            colspan="4">
                            <h1 style="text-align: left;font-size: 12px;font-weight: bold;">IMPRESSION:</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"
                            colspan="4">
                            <ul style="text-align: left;">
                                <li>Item 1</li>
                                <li>Item 2</li>
                                <li>Item 3</li>
                                <li>Item 4</li>
                            </ul>
                        </td>
                    </tr> -->
                    <tr>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"
                            colspan="4">
                            <h1 style="text-align: center;font-size: 10px;font-weight: bold;color: rgb(79,67,222);">DOCTOR FULL NAME</h1>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"></td>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"
                            colspan="2"><span style="font-size: 8px;color: rgb(51,43,142);">{{ Auth::user()->name }}</span></td>
                        <td class="text-uppercase text-center" style="font-size: 12px;text-align: left;color: rgb(0,0,0);border-style: none;border-color: rgb(255,255,255);border-top-width: 1px;border-top-color: rgb(0,0,0);border-bottom-color: rgb(0,0,0);font-weight: normal;"></td>
                    </tr>
                </tbody>
            </table>
        </div>


    </div>

    {{-- <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script> --}}


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
        var age = docdate.diff(moment(bdate, 'YYYY-MM-DD'), 'year');

        $('#age').append(age);

    </script>

</body>

</html>
