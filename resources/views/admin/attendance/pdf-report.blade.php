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
            table-layout: fixed; /* Ensures columns are fixed width */
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 6px; /* Reduce padding to make the table more compact */
            text-align: center;
            font-size: 10px; /* Smaller font size */
            word-wrap: break-word; /* Ensures long text wraps to fit the cell */
        }
        th {
            font-size: 11px;
        }
        th.date-header {
            width: 30px; /* Set a fixed width for date columns */
        }
        th.student-name {
            width: 120px; /* Increase width for student name column */
        }
        .present {
            color: green;
        }
        .absent {
            color: red;
        }
        .not-signed {
            color: orange;
        }
    </style>
</head>
<body>
    <h2>Davomat hisoboti ({{ $selectedGroup->name }}) ({{ $selectedMonthName }} {{ $selectedMonth['year'] }})</h2>
    
    <table>
        <thead>
            <tr>
                <th class="student-name">Talaba</th> <!-- Added class here -->
                <th>To'lov holati</th>
                @foreach ($distinctDates as $date)
                    <th class="date-header">{{ date('d', strtotime($date)) }}</th>
                @endforeach
                <th>Foiz %</th>
            </tr>
        </thead>
        <tbody>
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
                        @endphp
                        {{ $studentPayments->isNotEmpty() ? 'To\'lov qilgan' : 'To\'lov qilmagan' }}
                    </td>
                    @foreach ($distinctDates as $date)
                        @php
                            $attendance = $student->attendances->where('attendance_date', $date)->first();
                        @endphp
                        <td class="{{ $attendance ? ($attendance->status ? 'present' : 'absent') : 'not-signed' }}">
                            {{ $attendance ? ($attendance->status ? 'Kelgan' : 'Kelmagan') : 'Not-here' }}
                        </td>
                    @endforeach
                    <td>{{ $student->attendancePercentage($selectedGroup, $selectedMonth) }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
