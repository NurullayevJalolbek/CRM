@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title"><b>Statistika</b></h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item active">statistika</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>


            @if (auth()->user()->hasRole(['Supper admin', 'Admin']))
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Talabalar </h6>
                                        <h3>{{ $students }} ta</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Guruhlar</h6>
                                        <h3>{{ $totalGroups }} ta</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Ustozlar</h6>
                                        <h3>{{ $teachers }} ta</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Tushumlar - {{ \Carbon\Carbon::now()->format('F') }}</h6>
                                        <h3>{{ number_format($monthlyPayments) }} UZS</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (auth()->user()->hasRole('Teacher'))
                <div class="row">
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Talabalar </h6>
                                        <h3>{{ $totalStudentsCount ?? 0 }} ta</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Guruhlar</h6>
                                        <h3>{{ $groupNumber ?? 0 }} ta</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Tushumlar - {{ \Carbon\Carbon::now()->format('F') }}</h6>
                                        <h3>{{ number_format($monthlyTeacherPayments) }} UZS</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">

                    @foreach ($user->groups()->where('status', 1)->get() as $group)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card border-0 shadow-sm group-card">
                                <div class="card-header d-flex justify-content-between ">
                                    <div class="mt-2" style="margin-left: 9px">
                                        <h6>{{ ucfirst($group->name) }}</h6>
                                        <strong>Fan:</strong> {{ $group->subject->name ?? 'N/A' }}
                                    </div>

                                    <div class="text-center mt-3">
                                        <a href="{{ route('groups.show', $group->id) }}"
                                            class="btn btn-outline-success btn-sm">Batafsil</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled group-details">
                                        <li><strong>id:</strong> {{ $group->id }}</li>
                                        <li><strong>Narx:</strong> {{ number_format($group->price, 0, ',', ' ') }} so'm
                                        </li>
                                        <li><strong>Talabalar soni:</strong>
                                            {{ $group->students->where('status', 'active')->count() ?? 'N/A' }} ta azo
                                        </li>
                                        <li><strong>Boshlangan vaqt:</strong> {{ $group->started_date }}</li>
                                    </ul>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif



            @if (auth()->user()->hasRole('Supper admin'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Oylik Tushumlar - {{ $currentYear }}</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyPaymentsChart" width="600" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Mijozlar oqimi</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="donut-chart" width="800" height="500"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Yillik Tushumlar</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="yearlyPaymentsChart" width="300" height="200"></canvas>
                            </div>
                        </div>
                    </div>
            @endif






        </div>
    </div>
    </div>
@endsection



<script>
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/payments/monthly')
            .then(response => response.json())
            .then(data => {
                const labels = Object.keys(data);
                const values = Object.values(data);

                const ctxMonthly = document.getElementById('monthlyPaymentsChart').getContext('2d');
                new Chart(ctxMonthly, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Oylik Tushumlar',
                            data: values,
                            fill: false,
                            borderColor: 'rgb(75, 192, 192)',
                            tension: 0.1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    // text: 'Month'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'UZS'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching monthly payments data:', error));

        fetch('/payments/yearly')
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.year);
                const values = data.map(item => item.total_amount);

                const ctxYearly = document.getElementById('yearlyPaymentsChart').getContext('2d');
                new Chart(ctxYearly, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Yillik Tushumlar',
                            data: values,
                            backgroundColor: 'rgb(54, 162, 235)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'Year'
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: true,
                                    text: 'UZS'
                                },
                                beginAtZero: true
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error fetching yearly payments data:', error));
    });

    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('donut-chart').getContext('2d');
        var socialLinks = @json($socialLinks);
        var labels = socialLinks.map(link => link.name);
        var data = socialLinks.map(link => link.students_count);

        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Mijozlar soni',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(153, 102, 255, 0.6)',
                        'rgba(255, 159, 64, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)', // New color
                        'rgba(75, 192, 192, 1)', // New color
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Mijozlar oqimi'
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(context) {
                            var label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += context.formattedValue;
                            return label;
                        }
                    }
                }
            }
        });
    });
</script>
