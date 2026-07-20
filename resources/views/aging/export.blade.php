<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Aging Report - {{ $title }}</title>
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: #fff;
            color: #1a1a2e;
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #eee;
            padding-bottom: 20px;
        }
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #1a1a2e;
        }
        .header p {
            color: #666;
            margin: 5px 0 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        th {
            background: #f5f5f5;
            text-align: left;
            padding: 10px 12px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #ddd;
        }
        td {
            padding: 8px 12px;
            border-bottom: 1px solid #eee;
        }
        tr:hover td {
            background: #fafafa;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            font-weight: 700;
            background: #f8f8f8;
        }
        .total-row td {
            border-top: 2px solid #ddd;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        .badge-current { background: #d4edda; color: #155724; }
        .badge-d30 { background: #fff3cd; color: #856404; }
        .badge-d60 { background: #ffe5cc; color: #7b4a1a; }
        .badge-d90 { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Aging Report - {{ $title }}</h1>
        <p>Dicetak: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nama / Invoice</th>
                <th class="text-right">Lancar</th>
                <th class="text-right">1–30 Hari</th>
                <th class="text-right">31–60 Hari</th>
                <th class="text-right">61–90+ Hari</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalCurrent = 0;
                $totalD30 = 0;
                $totalD60 = 0;
                $totalD90 = 0;
                $grandTotal = 0;
            @endphp

            @foreach($data as $row)
                @php
                    $total = $row['current'] + $row['d30'] + $row['d60'] + $row['d90'];
                    $totalCurrent += $row['current'];
                    $totalD30 += $row['d30'];
                    $totalD60 += $row['d60'];
                    $totalD90 += $row['d90'];
                    $grandTotal += $total;
                    
                    $hasCurrent = $row['current'] > 0;
                    $hasD30 = $row['d30'] > 0;
                    $hasD60 = $row['d60'] > 0;
                    $hasD90 = $row['d90'] > 0;
                @endphp
                <tr>
                    <td>
                        <strong>{{ $row['name'] }}</strong>
                        <br>
                        <span style="font-size:11px;color:#888;">{{ $row['invoice'] }}</span>
                    </td>
                    <td class="text-right">
                        @if($hasCurrent)
                            <span class="badge badge-current">Rp {{ number_format($row['current'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($hasD30)
                            <span class="badge badge-d30">Rp {{ number_format($row['d30'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($hasD60)
                            <span class="badge badge-d60">Rp {{ number_format($row['d60'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        @if($hasD90)
                            <span class="badge badge-d90">Rp {{ number_format($row['d90'], 0, ',', '.') }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">
                        <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            @endforeach

            <tr class="total-row">
                <td><strong>TOTAL</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalCurrent, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalD30, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalD60, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalD90, 0, ',', '.') }}</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Laporan ini dihasilkan secara otomatis oleh Arthajaya System</p>
    </div>
</body>
</html>