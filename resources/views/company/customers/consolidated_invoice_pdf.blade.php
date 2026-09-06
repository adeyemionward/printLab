<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family: Arial, sans-serif; color: #333;">
    <!-- Invoice Header -->
    <tr bgcolor="#E3E3E3">
        <td style="padding: 20px;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <!-- Brand Row -->
                            <tr>
                                <td height="69">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="50%" style="font-weight: bolder; font-size: 24px;">
                                                <img src="https://printlabs.com.ng/img/printlab.PNG" alt="Printlabs Logo" width="180" title="Printlabs Logo" />
                                                <br><br>
                                                ORDER INVOICE
                                            </td>
                                            <td width="50%" align="right" style="font-size: 14px; line-height: 1.5;">
                                                <strong style="font-size: 16px;">PRINTLABS LTD</strong><br>
                                                No 14 Akinremi Street, Anifowoshe<br>
                                                Ikeja, Lagos<br>
                                                support@printlabs.com.ng
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <!-- Bill To & Invoice Meta -->
                            <tr>
                                <td height="69" style="padding-top: 15px;">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="55%" valign="top" style="font-size: 14px; line-height: 1.5;">
                                                <span style="font-weight: bold; font-size: 15px;">BILL TO:</span><br>
                                                <strong>{{ $customer->company_name ?? ($customer->firstname . ' ' . $customer->lastname) }}</strong><br>
                                                {{ $customer->address ?? 'Address Not Provided' }}<br>
                                                Phone: {{ $customer->phone ?? 'N/A' }}
                                            </td>
                                            <td width="45%" align="right" valign="top" style="font-size: 14px; line-height: 1.5;">
                                                <span style="font-weight: bold; font-size: 15px;">INVOICE REF:</span><br>
                                                PL-CON-{{ $customer->id }}-{{ date('Ymd') }}<br>
                                                <span style="font-weight: bold; font-size: 15px;">PERIOD:</span><br>
                                                {{ request('date_from', date('Y-01-01')) }} to {{ request('date_to', date('Y-m-d')) }}<br>
                                                <span style="font-weight: bold; font-size: 15px;">DATE:</span><br>
                                                {{ date('Y-m-d') }}
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="20"><hr style="border: 0; border-top: 1px solid #ccc;"></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr><td height="20"></td></tr>

    <!-- Consolidated Orders Table -->
    <tr>
        <td>
            <table width="100%" border="1" cellpadding="6" cellspacing="0" style="border-collapse: collapse; border-color: #ccc; font-size: 13px;">
                <thead>
                    <tr bgcolor="#E3E3E3" style="font-weight: bold;">
                        <th align="center" width="5%">S/N</th>
                        <th align="left" width="23%" style="padding-left: 10px;">Order No</th>
                        <th align="center" width="16%">Date</th>
                        <th align="right" width="18%">Total Cost</th>
                        <th align="right" width="18%">Amount Paid</th>
                        <th align="right" width="20%" style="padding-right: 10px;">Outstanding</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $grandTotalCost = 0;
                        $grandTotalPaid = 0;
                        $grandTotalOutstanding = 0;
                    @endphp

                    @forelse ($job_orders as $index => $val)
                        @php
                            $order_cost = (float) str_replace(',', '', $val->total_cost ?? 0);
                            $paid_amount = (float) str_replace(',', '', $val->amount_paid ?? 0);
                            $outstanding = max(0, $order_cost - $paid_amount);

                            $grandTotalCost += $order_cost;
                            $grandTotalPaid += $paid_amount;
                            $grandTotalOutstanding += $outstanding;
                        @endphp
                        <tr>
                            <td align="center">{{ $index + 1 }}</td>
                            <td align="left" style="padding-left: 10px;">
                                <strong>#{{ $val->order_no }}</strong><br>
                                <span style="font-size: 11px; color: #555;">
                                    ({{ $val->total_jobs ?? 1 }} {{ \Illuminate\Support\Str::plural('Job', $val->total_jobs ?? 1) }})
                                </span>
                            </td>
                            <td align="center">{{ $val->created_at ? \Carbon\Carbon::parse($val->created_at)->format('d/m/Y') : 'N/A' }}</td>
                            <td align="right">{{ App\Functions\Functions::formatCurrency($order_cost) }}</td>
                            <td align="right" style="color: green;">{{ App\Functions\Functions::formatCurrency($paid_amount) }}</td>
                            <td align="right" style="padding-right: 10px; font-weight: bold; color: {{ $outstanding > 0 ? '#d9534f' : '#333' }};">
                                {{ App\Functions\Functions::formatCurrency($outstanding) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" align="center" style="padding: 15px;">No orders found for this customer in the selected range.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </td>
    </tr>

    <tr><td height="10"></td></tr>

    <!-- Payment Account Details & Total Cost -->
    <tr>
        <td>
            <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; border-color: #ccc; font-size: 13px;">
                <tr>
                    <td width="50%" bgcolor="#E3E3E3" valign="top" style="padding-left: 15px; line-height: 1.5;">
                        <span style="font-weight: bold;">PAYMENT DETAILS:</span><br>
                        Bank: <strong>ECOBANK</strong><br>
                        Acc/No (Naira): <strong>4933060877</strong><br>
                        Account Name: <strong>PRINTLABS LTD</strong>
                    </td>
                    <td width="50%" align="right" valign="middle" style="padding-right: 15px; font-size: 16px;">
                        <span style="font-weight: bold;">Total Billed:</span><br>
                        <span style="font-size: 20px; font-weight: bold;">
                            {{ App\Functions\Functions::formatCurrency($grandTotalCost) }}
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <!-- Paid vs Outstanding Balance Due -->
    <tr>
        <td>
            <table width="100%" border="1" cellpadding="8" cellspacing="0" style="border-collapse: collapse; border-color: #ccc; font-size: 15px;">
                <tr>
                    <td width="50%" align="right" style="padding-right: 15px; color: green;">
                        <span style="font-weight: bold;">Total Amount Paid:</span><br>
                        <span style="font-size: 18px; font-weight: bold;">
                            {{ App\Functions\Functions::formatCurrency($grandTotalPaid) }}
                        </span>
                    </td>
                    <td width="50%" align="right" bgcolor="#FFF3F3" style="padding-right: 15px; color: #c9302c;">
                        <span style="font-weight: bold;">Total Balance Due:</span><br>
                        <span style="font-size: 22px; font-weight: bold;">
                            {{ App\Functions\Functions::formatCurrency($grandTotalOutstanding) }}
                        </span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
