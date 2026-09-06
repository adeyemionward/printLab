<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Printlabs Invoice - #000{{ request()->order_no ?? ($order1->order_no ?? '') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #2b2f38;
            line-height: 1.5;
            background-color: #f7f9fb;
            margin: 0;
            padding: 30px 15px;
        }

        .invoice-card {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border: 1px solid #eef0f4;
        }

        .table-layout {
            width: 100%;
            border-collapse: collapse;
        }

        /* Header Elements */
        .brand-title {
            font-size: 26px;
            font-weight: 700;
            letter-spacing: -0.5px;
            color: #111827;
            margin: 12px 0 0 0;
        }

        .company-info {
            font-size: 13px;
            color: #64748b;
            line-height: 1.6;
        }

        .invoice-badge {
            display: inline-block;
            background-color: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 6px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Metadata & Customer Sections */
        .section-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            margin-bottom: 6px;
        }

        .client-name {
            font-size: 15px;
            font-weight: 700;
            color: #1e293b;
        }

        .client-details {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

        .meta-value {
            font-size: 14px;
            color: #1e293b;
            font-weight: 600;
        }

        .divider {
            border: 0;
            border-top: 1px solid #f1f5f9;
            margin: 28px 0;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .items-table th {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #64748b;
            font-weight: 700;
            padding: 12px 14px;
            border-bottom: 2px solid #f1f5f9;
            background: #fafbfc;
        }

        .items-table td {
            font-size: 13px;
            color: #334155;
            padding: 14px;
            border-bottom: 1px solid #f1f5f9;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        /* Settlement Box */
        .settlement-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 18px 20px;
            margin-top: 24px;
        }

        .bank-details {
            font-size: 12px;
            color: #475569;
            line-height: 1.7;
        }

        .summary-label {
            font-size: 13px;
            color: #64748b;
        }

        .summary-value {
            font-size: 14px;
            font-weight: 600;
            color: #1e293b;
        }

        .balance-value {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .balance-due-pill {
            color: #dc2626;
            font-weight: 700;
        }

        .paid-pill {
            color: #16a34a;
            font-weight: 600;
        }

        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }
            .invoice-card {
                box-shadow: none;
                border: none;
                padding: 20px 0;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="invoice-card">
    <!-- Brand Header -->
    <table class="table-layout" style="margin-bottom: 24px;">
        <tr>
            <td valign="top" style="width: 55%;">
                <img src="https://printlabs.com.ng/img/printlab.PNG" alt="Printlabs Logo" width="160" style="display: block;" />
                <h1 class="brand-title">Invoice</h1>
            </td>
            <td valign="top" align="right" style="width: 45%;" class="company-info">
                <strong style="color: #1e293b; font-size: 14px;">Printlabs Ltd</strong><br>
                No 14 Akinremi Street, Anifowoshe<br>
                Ikeja, Lagos State<br>
                contact@printlabs.com.ng
            </td>
        </tr>
    </table>

    <hr class="divider" style="margin-top: 0;">

    <!-- Bill To & Metadata -->
    <table class="table-layout" style="margin-bottom: 10px;">
        <tr>
            <td valign="top" style="width: 55%;">
                <div class="section-label">Billed To</div>
                <div class="client-name">{{ $order1->user->company_name ?? ($order1->user->firstname . ' ' . $order1->user->lastname) }}</div>
                <div class="client-details" style="margin-top: 4px;">
                    {!! nl2br(e($order1->user->address ?? 'Address not specified')) !!}
                    @if(!empty($order1->user->phone))
                        <br>{{ $order1->user->phone }}
                    @endif
                </div>
            </td>
            <td valign="top" align="right" style="width: 45%;">
                <div class="section-label">Invoice Details</div>
                <table style="display: inline-table; border-collapse: collapse;">
                    <tr>
                        <td align="right" class="client-details" style="padding-right: 12px;">Invoice No:</td>
                        <td align="right" class="meta-value">#000{{ request()->order_no ?? $order1->order_no }}</td>
                    </tr>
                    <tr>
                        <td align="right" class="client-details" style="padding-right: 12px; padding-top: 4px;">Issued Date:</td>
                        <td align="right" class="meta-value" style="padding-top: 4px;">{{ date('d M, Y') }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Order Items Table -->
    @php
        $totalCost = 0;
        foreach ($orderDetails as $val) {
            $totalCost += (float) str_replace(',', '', $val->total_cost ?? 0);
        }
        $paidAmount = (float) str_replace(',', '', $totalAmountPaid ?? 0);
        $balance = max(0, $totalCost - $paidAmount);
    @endphp

    <table class="items-table" style="margin-top: 24px;">
        <thead>
            <tr>
                <th align="left" style="border-top-left-radius: 6px; padding-left: 14px;">Item Description</th>
                <th align="center" style="width: 14%;">Qty</th>
                <th align="right" style="width: 22%;">Rate</th>
                <th align="right" style="width: 24%; border-top-right-radius: 6px; padding-right: 14px;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $val)
                @php
                    $itemTotal = (float) str_replace(',', '', $val->total_cost ?? 0);
                    $qty = max(1, (int) ($val->quantity ?? 1));
                    $unitPrice = $itemTotal / $qty;
                @endphp
                <tr>
                    <td align="left" style="font-weight: 600; color: #1e293b;">
                        {{ $val->job_order_name }}
                    </td>
                    <td align="center" style="color: #64748b;">
                        {{ $val->quantity }}
                    </td>
                    <td align="right" style="color: #64748b;">
                        {{ App\Functions\Functions::formatCurrency($unitPrice) }}
                    </td>
                    <td align="right" style="font-weight: 600; color: #1e293b; padding-right: 14px;">
                        {{ App\Functions\Functions::formatCurrency($itemTotal) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Settlement Card: Payment Information & Totals -->
    <div class="settlement-card">
        <table class="table-layout">
            <tr>
                <!-- Bank Instructions -->
                <td valign="top" style="width: 50%; padding-right: 15px;">
                    <div class="section-label">Payment Instructions</div>
                    <div class="bank-details" style="margin-top: 6px;">
                        <strong>ECOBANK NIGERIA</strong><br>
                        Account No: <span style="font-family: monospace; font-size: 13px; font-weight: 700; color: #0f172a;">4933060877</span><br>
                        Account Name: <strong>Printlabs Ltd</strong>
                    </div>
                </td>

                <!-- Reconciliation Summary -->
                <td valign="top" style="width: 50%;">
                    <table class="table-layout">
                        <tr>
                            <td class="summary-label" style="padding-bottom: 8px;">Subtotal:</td>
                            <td align="right" class="summary-value" style="padding-bottom: 8px;">
                                {{ App\Functions\Functions::formatCurrency($totalCost) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="summary-label" style="padding-bottom: 8px;">Amount Paid:</td>
                            <td align="right" class="summary-value paid-pill" style="padding-bottom: 8px;">
                                {{ App\Functions\Functions::formatCurrency($paidAmount) }}
                            </td>
                        </tr>
                        <tr style="border-top: 1px solid #cbd5e1;">
                            <td style="padding-top: 10px; font-weight: 700; color: #0f172a; font-size: 14px;">
                                Balance Due:
                            </td>
                            <td align="right" style="padding-top: 10px;">
                                <span class="balance-value {{ $balance > 0 ? 'balance-due-pill' : '' }}">
                                    {{ App\Functions\Functions::formatCurrency($balance) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <!-- Soft Footer Note -->
    <div style="text-align: center; margin-top: 36px; font-size: 12px; color: #94a3b8;">
        Thank you for choosing Printlabs. For questions regarding this invoice, please reach out to billing support.
    </div>
</div>

</body>
</html>