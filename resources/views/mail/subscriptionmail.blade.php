<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="x-apple-diasble-message-reformatting">
	<title>Printsoft</title>
	<style type="text/css">
		body {
			margin: 0;
			background-color: #f0f0f0;
		}

		table {
			border-spacing: 0;
		}

		td {
			padding: 0;
		}

		img {
			border: 0;
		}

		.wrapper {
			width: 100%;
			table-layout: fixed;
			background-color: #f0f0f0;
			padding-bottom: 60px;
		}

		.main {
			background-color: #ffffff;
			margin: 0 auto;
			width: 100%;
			max-width: 600px;
			border-spacing: 0;
			font-family: sans-serif;
			color: #4a4a4a;
		}

        .main2 {
			background-color: #e2dbdb;
			margin: 0 auto;
			width: 100%;
			max-width: 600px;
			border-spacing: 0;
			font-family: sans-serif;
			color: #4a4a4a;
		}

		.two-columns {
			text-align: center;
			font-size: 0;
		}

		.two-columns>.column {
			width: 100%;
			max-width: 300%;
			display: inline-block;
			vertical-align: top;
		}
		.center{
			text-align: center;
		}
        a{
            text-decoration: none;
        }
        .withdrawal{
            font-weight:bold;

        }
	</style>
</head>

<body>

	<center class="wrapper">
		<table class="main" width="100%">
			<!-- COMPANY COLOR BORDER -->
			<tr>
				<td height="8" style="background-color: #2a2a72;"></td>
			</tr>

			<!-- LOGO SECTION -->
			<tr>
				<td style="padding: 30px 0;">
					<table width="100%">
						<tr>
							<td align="center">
								<a href="www.printlabs.com.ng">
									<img src="https://printlabs.com.ng/img/printlab.PNG" alt="printlabs logo" width="180" title="printlabs logo" />
								</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<!-- COMPANY COLOR BORDER -->
			<tr>
				<td height="2" style="background-color: #2a2a72;"></td>
			</tr>

			<!-- TITLE -->
			<tr class="center">
				<td>
					<table width="100%">
						<h2 style="font-size: larger; font-weight: 600; padding: 0 20px; color:#2a2a72; text-transform:uppercase">
                           Subscription Email
						</h2>
					</table>
				</td>
			</tr>

            <tr>
				<td>
					<table width="100%">
						<h2 style=" font-weight: 400; padding: 0 20px; text-align:left">
              				Hello, {{$name}}
						</h2>
                        <p style=" padding: 0 20px; text-align:left">Thank you for your interest in our software. <br>
                            You have successfully created an account. Kindly make payment to the account details below to activate your account</p>
					</table>
				</td>
			</tr>

            {{-- message --}}
            <tr>
				<td>
					<table style="padding-left: 30px;" width="100%">

                        <tr>
                            <td style=" font-weight: 600; padding-top: 20px;">Name: {{$name}}</td>
						</tr>
                        <tr>
                            <td style=" font-weight: 600; padding-top: 20px;">Email: {{$email}}</td>
						</tr>
                        <tr>
                            <td style="font-weight: 600; padding-top: 20px;">Payment Mode: {{$payment_plan}}</td>
						</tr>
                        <tr>
                            <td style="font-weight: 600; padding-top: 20px;">Payment Plan: {{$payment_mode}}</td>
						</tr>
						</tr>
					</table>
				</td>
			</tr>
            <br>
            <tr>
				<td>
                     <br>
					<table style="padding-left: 30px;" width="100%">
						<h2 style=" font-weight: 400; padding-left: 30px; color:red ">
              				Bank Account Details
						</h2>
                        {{-- @if (!is_null($banks) && (is_array($banks) || is_object($banks))) --}}
                            @forelse ($banks as $bank)
                                <tr>
                                    <td style="font-weight: 600; padding-top: 10px;">Bank Name: {{$bank->bank_name}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding-top: 20px;">Bank Account No: {{$bank->account_no}}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: 600; padding-top: 20px;">Bank Account Name: {{$bank->account_name}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td style="font-weight: 600; padding-top: 20px;">Bank Details Not Available...</td>
                                </tr>
                            </hr>
                            @endforelse
                        {{-- @else
                            <!-- This content will be displayed if $banks is null or not an array/object -->
                            <tr><td>No banks found</td></tr>
                        @endif --}}

					</table>
				</td>
			</tr>

			<!-- GRAY BORDER -->
			<tr>
				<td height="5" style="background-color: #f7fafc;"></td>
			</tr>
            <br> <br>
			<!-- SOCIAL ICON SECTION -->
            <table class="main2" width="100%" style="margin-top: 20px;">

			<!-- FOOTER SECTION -->

			<tr>
				<td  class="center">
					<table style="padding-left: 30px; margin-bottom: 20px;" width="100%">
						<tr class="center">
							<td style="font-size: small; font-weight: 600; color: #4a4a4a; padding-top: 10px;">
								Kindly send us a message if you have made the payment, on <a  href="mailto:info@printlabs.com.ng">info@printlabs.com.ng</a>
							</td>
						</tr>

						<tr class="center">
							<td style="font-size: small; font-weight: 600; color: #4a4a4a; padding-top: 10px;">
								 Thanks for using PrintLSoft.
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="center">
					<table width="100%">

						<img style="margin-bottom: 40px;" width="65" src="https://printlabs.com.ng/img/printlab.PNG" alt="printlabs logo" />
					</table>
				</td>
			</tr>
        </table>
		</table>
	</center>
</body>

</html>
