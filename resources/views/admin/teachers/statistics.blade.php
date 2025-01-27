@extends('layouts.app')

@section('title')
    Teachers Statistics
@endsection

@section('statistics')
    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="page-sub-header">
                            <h3 class="page-title"><b>Ustozlar Statistikasi</b></h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item"><a>Home</a></li>
                                <li class="breadcrumb-item active">Ustozlar statistikasi</li>
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
                                        <h3> {{ $activeStudents }}</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/dash-icon-01.svg" alt="Dashboard Icon">
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
                                        <h3>{{ $totalGroups }}</h3>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/dash-icon-03.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body teachers">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Ustozlar</h6>
                                        <button class="dropdown-btn">Ustozlar ro'yxati ▼</button>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                                <!-- Dropdown content -->
                                <div class="dropdown-content">
                                    <ul>
                                        @foreach($teachers as $teacher)
                                            <li data-id="{{$teacher->id}}" onclick="selectTeacher(this)">  {{ $teacher->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-sm-6 col-12 d-flex">
                        <div class="card bg-comman w-100">
                            <div class="card-body date">
                                <div class="db-widgets d-flex justify-content-between align-items-center">
                                    <div class="db-info">
                                        <h6>Yil</h6>
                                        <button class="dropdown-btn">Sanalar ro'yxati ▼</button>
                                    </div>
                                    <div class="db-icon">
                                        <img src="../assets/img/icons/dash-icon-02.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                                <!-- Dropdown content -->
                                <div class="dropdown-content">
                                    <ul id ='years'></ul>
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
                                        <h3>0 ta</h3>
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
                                        {{--                                        <h6>Tushumlar - {{ \Carbon\Carbon::now()->format('F') }}</h6>--}}
                                        {{--                                        <h3>{{ number_format($monthlyTeacherPayments) }} UZS</h3>--}}
                                    </div>
                                    <div class="db-icon">
                                        <img src="assets/img/icons/dash-icon-04.svg" alt="Dashboard Icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div class="row ">--}}

                {{--                    @foreach ($user->groups()->where('status', 1)->get() as $group)--}}
                {{--                        <div class="col-lg-4 col-md-6 mb-4">--}}
                {{--                            <div class="card border-0 shadow-sm group-card">--}}
                {{--                                <div class="card-header d-flex justify-content-between ">--}}
                {{--                                    <div class="mt-2" style="margin-left: 9px">--}}
                {{--                                        <h6>{{ ucfirst($group->name) }}</h6>--}}
                {{--                                        <strong>Fan:</strong> {{ $group->subject->name ?? 'N/A' }}--}}
                {{--                                    </div>--}}

                {{--                                    <div class="text-center mt-3">--}}
                {{--                                        <a href="{{ route('groups.show', $group->id) }}"--}}
                {{--                                           class="btn btn-outline-success btn-sm">Batafsil</a>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                                <div class="card-body">--}}
                {{--                                    <ul class="list-unstyled group-details">--}}
                {{--                                        <li><strong>id:</strong> {{ $group->id }}</li>--}}
                {{--                                        <li><strong>Narx:</strong> {{ number_format($group->price, 0, ',', ' ') }} so'm--}}
                {{--                                        </li>--}}
                {{--                                        <li><strong>Talabalar soni:</strong>--}}
                {{--                                            {{ $group->students->where('status', 'active')->count() ?? 'N/A' }} ta azo--}}
                {{--                                        </li>--}}
                {{--                                        <li><strong>Boshlangan vaqt:</strong> {{ $group->started_date }}</li>--}}
                {{--                                    </ul>--}}

                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    @endforeach--}}
                {{--                </div>--}}
            @endif



            @if (auth()->user()->hasRole('Supper admin'))
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Statistika</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 ">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Talabalar </h5>
                            </div>
                            <div class="card-body">
                                <canvas id="donut-chart" width="800" height="500"></canvas>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
        </div>
    </div>
    <script>
        // Ustozlar drop down
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownBtn = document.querySelector('.dropdown-btn');
            const dropdownContent = document.querySelector('.dropdown-content');

            dropdownBtn.addEventListener('click', function () {
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.teachers')) {
                    dropdownContent.style.display = 'none';
                }
            });
            // O'qituvchi tanlanganida dropdownni yopish
            dropdownContent.addEventListener('click', function (event) {
                if (event.target.tagName === 'LI') {
                    dropdownContent.style.display = 'none';
                }
            });
        });

        // Yil drop down
        document.addEventListener('DOMContentLoaded', function () {
            const dropdownBtn = document.querySelector('.date .dropdown-btn');
            const dropdownContent = document.querySelector('.date .dropdown-content');

            dropdownBtn.addEventListener('click', function () {
                if (dropdownContent.style.display === 'block') {
                    dropdownContent.style.display = 'none';
                } else {
                    dropdownContent.style.display = 'block';
                }
            });
            // Tashqi qismni bosganda dropdownni yopish
            document.addEventListener('click', function (event) {
                if (!event.target.closest('.date')) {
                    dropdownContent.style.display = 'none';
                }
            });
            // O'qituvchi tanlanganida dropdownni yopish
            dropdownContent.addEventListener('click', function (event) {
                if (event.target.tagName === 'LI') {
                    dropdownContent.style.display = 'none';
                }
            });
        });



        // O'qituvchi tanlash funksiyasi
        function selectTeacher(teacherElement) {
            let teacherWorkYears = [];
            const teacherID = teacherElement.getAttribute('data-id');
            const url = '/teachers/' + teacherID + '/group';

            axios.get(url)
                .then(function (response) {
                    teacherWorkYears = response.data.teacherWorkYears;
                    const years = document.getElementById('years');

                    years.innerHTML = '';

                    teacherWorkYears.forEach(function (year) {
                        const listItem = document.createElement('li');
                        listItem.textContent = year;
                        listItem.setAttribute('data-id', year);
                        listItem.classList.add('year');
                        listItem.addEventListener('click', function () {
                            selectYear(teacherID, year);
                        });
                        years.appendChild(listItem);
                    });
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

        // Yil tanlash funksiyasi
        function  selectYear(teacherID, year) {
            const url = `/teachers/${teacherID}/year/${year}`;
            console.log(url)
            axios.get(url)
                .then( function (response) {
                    Statistika(response.data)
                })

        }

        // Chart Line funksiyasi
        let myChart = null;

        function Statistika(data) {
            const annualStatistics = data.months_statistics;

            if (myChart) {
                myChart.destroy();
            }

            const labels = annualStatistics.map(stat => stat.month_name);
            const studentCounts = annualStatistics.map(stat => stat.student_count);

            const ctx = document.getElementById('myChart').getContext('2d');
            myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Ustozning ish faoliyati',
                        data: studentCounts,
                        borderColor: 'rgba(75, 192, 192, 1)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        fill: true,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            stepSize: 5,
                            max: 50,
                        }
                    }
                }
            });
        }

    </script>

@endsection
