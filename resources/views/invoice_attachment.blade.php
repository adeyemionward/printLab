
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Retail Sales Receipt</title>
  <style>
    .copy_type {
        display: block;
        font-weight: bold;
        font-size: 11px;
    }

    .pagebreak {
        background: black;
        page-break-after: always;
    }
  </style>
</head>



<body >
<table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr  bgcolor="#E3E3E3" >
        <td  style="padding: 20px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="0"cellpadding="0" cellspacing="0">
                            <tr >
                                <td height="69">
                                    <table width="500"  cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50" height="29"  style="font-weight:bolder; font-size:25px"><img src="https://printlabs.com.ng/img/printlab.PNG" alt="printlabs logo" width="180" title="printlabs logo" /> <br><br>INVOICE</td>
                                        {{-- <td width="50" height="29"  style="font-weight:bolder; font-size:25px">INVOICE</td> --}}
                                        <td width="50" align="right" height="29" style="font-size:25px; padding-right:50px"> </span><br> <span style="font-size: 16px">2, Anifowoshe Avenue <br> Ikeja, Lagos</span></span></td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td height="69">
                                    <table width="500"  align="right" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="50" ><span style="font-size:15px; "> <span style="font-weight: bold; font-size:15px">BILL TO: </span><br> <span style="font-size: 16px">{{$userDetails->company_name}} <br> {{$userDetails->address}} <br> </span></span></td>
                                        <td width="50" align="right" style="padding-right: 50px">&nbsp;<span style="font-size:15px;  padding-right:0px"> <span style="font-weight: bold; font-size:15px">INVOICE </span><br> <span style="font-size: 14px">000{{$orderDetails->id}} </span><br> <span style="font-weight: bold; font-size:15px">DATE <br> </span> <span style="font-size: 14px"><?php echo date('Y-m-d') ?> </span> </span></span></td>
                                    </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="50">
                                    <hr>
                                </td>
                            </tr>
                        </table>
                    <td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr><br>
      <tr>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td bgcolor="#E3E3E3" height="28" style="padding-left: 20px">Item</td>
                <td bgcolor="#E3E3E3" height="28" align="right">Quantity</td>
                <td bgcolor="#E3E3E3" height="28"  align="right">Payment&nbsp;Type</td>
                <td bgcolor="#E3E3E3" height="28" align="right">Amount&nbsp;Paid</td>
                <td bgcolor="#E3E3E3" height="28" align="right" style="padding-right: 20px">Total&nbsp;Amount</td>
            </tr>

            <tr>
                <td align="left" width="20" style="padding-left: 20px">{{$orderDetails->job_order_name}}</td>
                <td align="right" width="25">{{$orderDetails->quantity}}</td>
                <td align="right" width="25"> {{$payment_type}}</td>
                <td align="right" width="15"> #{{$amount_paid}}</td>
                <td align="right" width="15" style="padding-right: 20px">#{{$orderDetails->total_cost}}</td>
            </tr>
        </table>
    </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="69"><table width="500" border="1" align="right" cellpadding="0" cellspacing="0">

          <tr>
            <td width="70" height="29" bgcolor="#E3E3E3" style="padding-left: 20px; padding-top:10px"><span style="font-weight: bold">PAYMENT&nbsp;DETAILS</span> <br><br> Bank : First Bank <br> Acc/No: 01111111111 <br>Account Name: PRINTLABS</td>
            <td width="30" align="right">&nbsp;<span style="font-size:20px; padding-right:10px"><span style="font-weight:bold; ">Total Amount:</span> #{{$orderDetails->total_cost}} <br> <span style="font-weight:bold; ">Total Balance:</span> #{{$orderDetails->total_cost - $amount_paid}}</span></td>
          </tr>
        </table></td>
      </tr>
      <br> <br>
      <tr align="center">
        <td align="center"> Powered By: PrintLabs <br> Thank you for your patronage </td>
      </tr>

    </table>
    </td>
  </tr>
</table>
</body>
</html>
