<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Verify Your Account</title>
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
					{{-- <td style="text-align: left;padding: 0;" height="3px" bgcolor="#ff9028"></td> --}}      
          <td style="padding: 0;" bgcolor="#ff9028">
              <table style="width: 770px;" border="0" cellpadding="0" cellspacing="0">
                  <tbody>
                  <tr>
                      <td align="center" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #fff;line-height: 21px;padding: 10px 35px;text-align: center;">
                          <p style="margin-top: 0;margin-bottom: 0;color: #ffffff;text-align: center;"><h3>Weekliy Students Highlights</h3></p>
                      </td>
                  </tr>
                  </tbody>
              </table>
          </td>
				</tr>
				<!--End Header-->
				<!--Start Content-->
				<tr>
					<td style="text-align: left;padding: 0;" height="8px"></td>
				</tr>
				<tr>
					<td style="text-align: left;">
              <h3>Hello {{ $user->name }}</h3>
              <p style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #212121;margin: 0 0 10px 0;">Here are the Highlights from your Students from {{ $fromDate }} to {{ $toDate }} UTC on Eduplaycloud</p>
              <br>
              <p style="display: block;text-align: center;">

              <table style="width: 770px;" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td>
                    <h3>Your Students</h3>
                  </td>
                </tr>
                <tr>
                  <td>Ordered by total points earned this week.</td>
                  <td style="text-align: right;padding: 0;" ><a href="{{$url}}">More Students activity</a></td>
                </tr>

                @foreach($students as $student )
                <tr>
                  <td>{{ $student->name }}</td>
                  <td style="text-align: right;padding: 0;">Encourage {{ $student->name }} and</td>
                </tr>
                <tr>
                  <td>+ {{ $student->totalpoints }} points</td>
                  <td style="text-align: right;padding: 0;" ><a href="">More Students activity</a></td>
                </tr>
                @endforeach

                {{-- <tr>
                  <td>tahauw</td>
                  <td style="text-align: right;padding: 0;">Encourage tahauw and</td>
                </tr>
                <tr>
                  <td>+ 0 points</td>
                  <td style="text-align: right;padding: 0;" ><a href="">More Students activity</a></td>
                </tr>
              </table> --}}
              {{-- <a href="#" style="font-family: 'Open Sans', sans-serif;font-size: 15px;color: #fff;border-radius: 5px;background-color: #3498db;padding: 8px 24px;text-decoration: none;display: inline-block;margin-bottom: 15px;">Activate Your Account</a></p> --}}
					</td>
				</tr>
				<!--End Content-->
				<!--Start Footer-->
              <tr>
                  <td style="padding: 0;" bgcolor="#ff9028">
                      <table style="width: 770px;" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                          <tr>
                              <td align="center" style="font-family: 'Open Sans', sans-serif; font-size: 13px; color: #fff;line-height: 21px;padding: 10px 35px;text-align: center;">
                                  <p style="margin-top: 0;margin-bottom: 0;color: #ffffff;text-align: center;">Copyright © 2019 Eduplaycloud</p>
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
