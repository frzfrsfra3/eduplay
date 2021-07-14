@php
$exerciseset = App\Models\Exerciseset::find($id);
$questions = $exerciseset->question
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

        .play-button-container{ 
            position: relative;
            top: -150px;
        }
        .play-button {
            padding: 12px;
            font-size: 18px;
            border:2px solid #ff9028;
            display: block;
            text-align: center;
            text-decoration: none;
            color: #fff;
            border-radius: 2px;
            width: 200px;
            margin: 10px auto;
            font-size: 21px;
            overflow: hidden;
            transition: all 0.2s ease 0s;
            text-transform: uppercase;
            letter-spacing: 6px;
        }
        .play-button:hover {
            background-color: #ff9028;
            color : #fff; 
            transform: scale(1.1);
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

        .details-list {
            margin : 0;
            list-style-type: none;
        }
        .details-list li{
            padding: 3px;
            text-transform: uppercase;
            display: inline-block;
        }
        .details-list li b{
            color : #ff9028;
        }
        .details-list li::after {
            content: '|';
            margin-left: 10px;
            color:#ff9028;
            font-weight: bold;
            font-size: 12px;
        }
        .details-list li:last-child::after {
            content: '';
            margin-left: 10px;
            color:#ff9028;
            font-weight: bold;
        }
        .exerciseset-img-container {
            background-color: #fff;
            padding: 10px;
            text-align: center;
            max-height: 200px;
            overflow: hidden;
            border-radius: 2px;
            filter: brightness(0.6);
            box-shadow: 2px 4px 15px #ccc;

        }
        .exerciseset-img-container img {
            width: 70%;
            border-radius: 40px;
            filter: blur(6px);
            transition: all 5s ease 0.1s;
        }
        .exerciseset-img-container:hover img {
            width: 70%;
            border-radius: 40px;
            filter: blur(6px);
            transform: scale(5);
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
                    <h2>{{ $exerciseset->title }}</h2>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <h3>Exercise Details:</h3>
                    <ul class="details-list">
                        <li><b>Price:</b>
                            @if ($exerciseset->price != 0)
                                ${{ $exerciseset->price }}
                            @else
                                @lang('exercisesets.free')
                            @endif    
                        </li>
                        <li><b>Questions:</b> {{ count($questions) }} </li>
                        <li><b>Duration:</b> {{ gmdate("H:i:s", $exerciseset->question->sum('maxtime')) }}</li>
                        @if($exerciseset->discipline)
                        <li>
                            <b>Curriculum:</b> {{  str_limit(@$exerciseset->discipline->discipline_name, '50') }}
                        </li>
                        <li>
                            <b>Topic:</b> {{  str_limit(@$exerciseset->topic->topic_name, '50') }}
                        </li>
                        @endif 
                    </ul>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="exerciseset-img-container">
                        @php
                        if (isset($exerciseset->exerciseset_image) && !empty($exerciseset->exerciseset_image)) 
                        {
                            if (strlen($exerciseset->exerciseset_image) > 0 && File::exists(public_path()."/uploads/exercisesets/".$exerciseset->exerciseset_image)) 
                                $exercisesetImage = '/uploads/exercisesets/'.$exerciseset->exerciseset_image;
                            else 
                                $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                        } else {
                            $exercisesetImage = 'assets/eduplaycloud/image/exers_prfl.png';
                        }
                        @endphp
                        <img src="{{ asset($exercisesetImage) }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="play-button-container">
                        <a href="{{ $url }}" class="play-button">Practice</a>
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