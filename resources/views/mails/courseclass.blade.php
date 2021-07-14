<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Course Show Email</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800" rel="stylesheet">
    <style type="text/css">
        .bg-table thead th{
            background-color: #e9e9e9;
            padding: 10px 10px;
            font-family: Arial, Helvetica, sans-serif;
            color: #000;
            font-weight: 500;;
        }
        .bg-table tbody tr td{padding: 10px 10px;}
        html {margin: 0 auto;padding: 0;}
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
            border-top: 1px solid #5D6975;;
        }

        #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
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
                        <a href="#" style="text-decoration: none;display: block;"><img editable="true" src="{{ asset('assets/eduplaycloud/email/logo.png') }}" style="display: block;width:180px;margin-bottom: 0px;" alt="Eduplaycloud"></a>
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
            <h3 style="font-family: 'Open Sans', sans-serif; font-size: 16px; color: #212121;margin: 0 0 10px 0;font-weight: bold;">Hello {{ $receiverEmail }}</h3>
            <p style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #212121;margin: 0 0 10px 0;">Click here <a href="{{ $register_url }}">Register</a> go to register page.</p>
            <p style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #212121;margin: 0 0 10px 0;">Click here <a href="{{ $class_url }}">Courseclass</a> to show courseclass page.</p>
        </td>
    </tr>
    <!--End Content-->

    <!--Start Footer-->
    <tr>
        <td style="padding: 0;" bgcolor="#ff9028">
            <table style="width: 770px;" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td align="center" style="font-family: 'Open Sans', sans-serif; font-size: 14px; color: #fff;line-height: 21px;padding: 10px 35px;text-align: center;">
                        {{--  <p style="margin-top: 0;">This message was sent to <a href="#" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #522801;text-decoration: none;font-weight: 600;">{{env('MAIL_FROM')}}</a>. You may <a href="#" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #522801;text-decoration: none;font-weight: 600;">unsubscibe</a> from these emails at any time, Please add <a href="#" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #522801;text-decoration: none;font-weight: 600;">no-reply@abc.com</a> to your address book to ensure our emails are delivered correctly.</p>
                        <p style="margin-top: 0;margin-bottom: 0;"><a href="{{ route('privacy-policy') }}" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #522801;text-decoration: none;font-weight: 600;">Privacy Policy</a> &nbsp; | &nbsp; <a href="#" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #522801;text-decoration: none;font-weight: 600;">Terms of Service</a></p>  --}}
                        <p style="margin-top: 0;margin-bottom: 0;">Copyright © {{ date('Y') }} Eduplaycloud</p>
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