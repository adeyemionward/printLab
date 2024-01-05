
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



<body bgcolor="#CCCCCC" onload="window.print()">
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td bgcolor="#FFFFFF" style="padding: 20px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td height="132" align="center">
                {{-- <img src="{{asset('public/images/logo1.png')}}" width="103" height="94" style="display: block;" /> --}}
                <span style="font-weight: bold;">FOODAKS</span><br />
               Address: Ijoko, Agbado, Ogun State <br />
               Phone: 08035531409 <br />
               {{-- gps@gmail.com </td> --}}
            </tr>
          <tr>
            <td align="center" bgcolor="#000000" style="letter-spacing: 0.3em; padding: 2px; color: #FFF; font-weight: bold; font-size: 15px;">RECEIPT</td>
            </tr>
            <td>
              <table width="900" border="1" align="right" cellpadding="0" cellspacing="0">
              <tr>
                <td width="32%" height="28" bgcolor="#E3E3E3">&nbsp;Sale ID #</td>
                <td width="68%">&nbsp;{request()->invoice} </td>
                </tr>
              <tr>
                <td height="30" bgcolor="#E3E3E3">&nbsp;Date</td>
                <td>&nbsp; @php echo 220000 @endphp </td>
                </tr>
                <tr>
                <td height="30" bgcolor="#E3E3E3">&nbsp;Status</td>
                <td>&nbsp;<b> Paid ({ucwords($purchased1->payment_mode)}) </b></td>
                </tr>
              <tr>
                <td height="30" bgcolor="#E3E3E3">&nbsp;Sales Rep</td>
                <td>&nbsp; {$purchased1->staffName->name}</td>
                </tr>
              </table>
            </td>
            </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
          </table>
        </td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td bgcolor="#E3E3E3" height="28">Item</td>
            <td bgcolor="#E3E3E3">Rate</td>
            <td bgcolor="#E3E3E3">Quantity</td>
            <td bgcolor="#E3E3E3">Amount</td>
          </tr>
          <?php $total_amount = 0; ?>
          {{-- @foreach ($purchased as $row)

            @if($row->price_type == 'retail')
                @php $productprice = $row->productPrice->rprice @endphp
            @else
                @php $productprice = $row->productPrice->wprice @endphp
            @endif --}}

            <tr>
                <td align="left">{$row->productName->name}</td>
                <td align="left"> &#8358;{number_format($productprice)} </td>


                <td align="center">{$row->quantity}</td>
                <td align="left">&#8358;{number_format($productprice * $row->quantity)}</td>
               {{-- <?php $total_amount += $productprice * $row->quantity ?> --}}
            </tr>
          {{-- @endforeach --}}

        </table>
    </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td height="69"><table width="900" border="1" align="right" cellpadding="0" cellspacing="0">

          <tr>
            <td width="29%" height="29" bgcolor="#E3E3E3">&nbsp;Total Amount</td>
            <td width="71%" align="right">&nbsp;<span style="font-size:20px; font-weight:bold; padding-right:10px">&#8358;{number_format($total_amount)}</span></td>
          </tr>
        </table></td>
      </tr>
      {{-- <tr align="center">
        <td align="center"><img src="http://127.0.0.1:8000/barcode?code=1222" /><br>#{{request()->invoice}}</td>
      </tr> --}}
      <tr align="center">
        <td align="center">Thank you for your patronage</td>
      </tr>
      <tr align="center">
        <td align="center"><span class="copy_type">Customer Copy</span><span style="font-size:10px;">print date:  <?php echo gmdate('d/m/Y h:i:s') ?></span></td>
      </tr>
    </table>
    </td>
  </tr>
</table>

</table>
</body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@if(Session::has("flash_success"))
        {{-- <script>
            toastr.success("{!! Session::get('flash_success') !!}");
        </script> --}}
        <script>
            Swal.fire(
                'Purchase Successful',

            )
        </script>
    @endif
