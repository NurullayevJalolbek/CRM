<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px;
            text-align: center;
            font-size: 10px;
            word-wrap: break-word; /* Ensure content wraps */
        }
        th {
            font-size: 11px;
        }
        th.student-name {
            width: 22%; /* Set Student Name to 25% of table width */
        }
        th.payment-status {
            width: 13%; /* Set Payment Status to 20% of table width */
        }
        th.date-header {
            width: 4.5%; /* Smaller width for dates */
        }
        .present {
            color: green;
            font-weight: bold;
        }
        .absent {
            color: red;
            font-weight: bold;
        }
        .not-signed {
            color: orange;
            font-weight: bold;
        }
        tfoot td {
            font-size: 12px;
            font-weight: bold;
            text-align: left; /* Align text to the left for better readability */
        }
    </style>
</head>
<body>
    <h2>Davomat hisoboti ({{ $selectedGroup->name }}) ({{ $selectedMonthName }} {{ $selectedMonth['year'] }})</h2>
    
    <table>
        <thead>
            <tr>
                <th class="student-name">Talaba</th>
                <th class="payment-status">To'lov holati</th>
                @foreach ($distinctDates as $date)
                    <th class="date-header">{{ date('d', strtotime($date)) }}</th>
                @endforeach
                <th>Foiz %</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPayments = 0;
            @endphp
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        @php
                            $formattedMonth = sprintf('%02d', $selectedMonth['month']);
                            $paymentMonth = "{$selectedMonth['year']}-{$formattedMonth}";
                            $studentPayments = $student->payments
                                ->where('group_id', $selectedGroup->id)
                                ->where('payment_month', $paymentMonth);
                            $paidAmount = $studentPayments->sum('paid_amount');
                            $totalPayments += $paidAmount;
                        @endphp
                        {{ $paidAmount > 0 ? number_format($paidAmount) . ' so\'m' : 'To\'lov qilmagan' }}
                    </td>
                    @foreach ($distinctDates as $date)
                        @php
                            $attendance = $student->attendances->where('attendance_date', $date)->first();
                        @endphp
                        <td class="{{ $attendance ? ($attendance->status ? 'present' : 'absent') : 'not-signed' }}">
                            {{ $attendance ? ($attendance->status ? '+' : '-') : ' ' }}
                        </td>
                    @endforeach
                    <td>{{ $student->attendancePercentage($selectedGroup, $selectedMonth) }}%</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right;"><b>Jami to'lov:</b></td>
                <td colspan="{{ count($distinctDates) + 1 }}" style="text-align: left;">
                    <b>{{ number_format($totalPayments) }} so'm</b>
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
