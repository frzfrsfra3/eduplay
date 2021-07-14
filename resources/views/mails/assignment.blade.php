@php
$exam = App\Models\Exam::find($id);
$questions = $exam->examquestions()->orderBy('examquestions.sort_order', 'asc')->get();
$topics = $exam->topics;
@endphp
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>Exercise Show Email</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <style type="text/css">
        .bg-table thead th {
            background-color: #e9e9e9;
            padding: 10px 10px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-weight: 500;
            ;
        }

        .bg-table tbody tr td {
            padding: 10px 10px;
        }

        html {
            margin: 0 auto;
            padding: 0;
        }

        body {
            position: relative;
            width: 770px;
            margin: 0 auto;
            color: #001028;
            background: #FFFFFF;
            font-size: 12px;
            font-family: 'Open Sans', sans-serif;
            padding: 0;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        table tr:nth-child(2n-1) td {
            /*background: #F5F5F5;*/
        }

        table th,
        table td {
            /*text-align: center;*/
            word-break: break-all;
        }

        table th {
            padding: 3px 10px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            font-weight: normal;
        }

        table .service,
        table .desc {
            /*text-align: left;*/
        }

        table td {
            padding: 3px 10px;
            /*text-align: left;*/
        }

        table td.service,
        table td.desc {
            vertical-align: top;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table td.grand {
            border-top: 1px solid #5D6975;
            ;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
        }

        .play-button {
            padding: 12px;
            font-size: 18px;
            background: #63c5f4;
            display: block;
            text-align: center;
            text-decoration: none;
            color: #fff;
            border-radius: 10px;
            width: 300px;
            margin: 10px auto;
        }

        .badge-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .badge-list li {
            display: inline-block;
            padding: 5px;
            background: #777;
            color: #fff;
            border-radius: 4px;
            margin: 3px;
        }
    </style>
</head>

<body>
    <!--Start Header-->
    <table border="0" cellpadding="0" cellspacing="0" style="width: 770px;">
        <tbody>
            <tr>
                <td align="center" style="padding: 10px 0;">
                    <table border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td valign="middle" style="text-align: right;">
                                    <a href="{{ route('home') }}" target="_blank"
                                        style="text-decoration: none;display: block;"><img editable="true"
                                            src="{{ asset('assets/eduplaycloud/email/logo.png') }}"
                                            style="display: block;width:180px;margin-bottom: 0px;"
                                            alt="Eduplaycloud"></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="text-align: left;padding: 0;" height="3px" bgcolor="#ff9028"></td>
            </tr>
            <!--End Header-->
            <!--Start Content-->
            <tr>
                <td style="text-align: left;padding: 0;" height="8px"></td>
            </tr>
            <tr>
                <td style="text-align: left;">
                    <h3
                        style="font-family: 'Open Sans', sans-serif; font-size: 16px; color: #212121;margin: 0 0 10px 0;font-weight: bold;">
                        Hello Sir/Ma'am ,</h3>
                    <p>
                        <b>{{ Auth::user()->name }}</b> has shared an assingment with you, it will be valid just for 3
                        days, so play it now.
                    </p>


                </td>
            </tr>
            <tr>
                <td>
                    <h3>Title of assignment: {{ $exam->title }}</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Topics:</h4>
                    <ul class="badge-list">
                        @foreach ($topics as $topic)
                        <li> {{ $topic->topic_name }} </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <h4>Assignment Details:</h4>
                    <ul>
                        <li><b>Type:</b> {{ $exam->examtype }} </li>
                        <li><b>Questions Count:</b> {{ count($questions) }} </li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="play-button-container">
                        <a href="{{ $url }}" class="play-button">Play it Online !</a>
                    </div>
                </td>
            </tr>
            <!--End Content-->
            <!--Start Footer-->
            <tr>
                <td style="padding: 0;" bgcolor="#ff9028">
                    <table style="width: 770px;" border="0" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td align="center"
                                    style="font-family: 'Open Sans', sans-serif; font-size: 14px; color: #fff;line-height: 21px;padding: 10px 35px;text-align: center;">
                                    <p style="margin-top: 0;margin-bottom: 0;">Copyright ©
                                        {{  Carbon\Carbon::now()->year }} Eduplaycloud</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <!--End Footer-->
</body>

</html>