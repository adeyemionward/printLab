@extends('company.layout.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  {{-- <style>
    canvas {
      max-width: 800px;
      width: 100%;
      height: 400px;
    }

    #marketerChart {
      max-width: 100%;
      width: 100px;
      height: 100px;
    }
  </style> --}}
 <style>
    /* Scope height-matching strictly to the chart row so it doesn't affect the filter form */
    .chart-row > [class*="col-md-"] {
        display: flex;
        flex-direction: column;
    }
    .chart-row > [class*="col-md-"] > .card {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .chart-row > [class*="col-md-"] > .card > .content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .canvas-wrapper {
        flex: 1;
        position: relative;
        min-height: 300px;
    }
    canvas {
        width: 100% !important;
        height: 100% !important;
    }
</style>
@section('title', 'Dashboard')
    {{-- MAIN BODY CONTENT --}}
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">Dashboard</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="teal data-feather-big" stroke-width="2"
                                            data-feather="shopping-cart" style="color: #df4226;"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">All Orders</p>
                                        <span class="number">{{$all_orders}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="teal data-feather-big" stroke-width="2"
                                            data-feather="shopping-cart" style="color:rgb(31, 121, 31);"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">New Orders</p>
                                        <span class="number">{{$pending_orders}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="orange data-feather-big" stroke-width="2"
                                            data-feather="shopping-cart"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle">Delivered Jobs</p>
                                        <span class="number">{{$delivered_orders}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-3">
                    <div class="card card-rounded">
                        <div class="content">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="icon-big text-center">
                                        <i class="olive data-feather-big" stroke-width="2"
                                            data-feather="dollar-sign"></i>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="detail">
                                        <p class="detail-subtitle" style="font-size: 18px">Current Year Revenue</p>
                                        <span class="number">₦{{number_format($total_cost)}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Date Range Filter Form -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card card-rounded">
                        <div class="content">
                            <form method="GET" action="{{ route('company.dashboard') }}" class="row g-3 align-items-end">
    <div class="col-md-4">
        <label for="date_from" class="form-label fw-bold">Date From:</label>
        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="form-control">
    </div>
    <div class="col-md-4">
        <label for="date_to" class="form-label fw-bold">Date To:</label>
        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="form-control">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary me-2 w-50">
            <i class="fa fa-filter"></i> Filter
        </button>
        <a href="{{ route('company.dashboard') }}" class="btn btn-secondary w-50 text-center" style="display: inline-flex; align-items: center; justify-content: center;">
            <i class="fa fa-refresh me-1"></i> Reset
        </a>
    </div>
</form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Charts Row 1: Top Customer & Best Marketers -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="content">
                            <div class="canvas-wrapper">
                                <canvas id="topCompaniesChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="content">
                            <div class="canvas-wrapper">
                                <canvas id="marketerChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="content">
                            <div class="canvas-wrapper">
                                <canvas id="revenueExpenseChart" style="height: 350px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row 2: Revenue vs Expenditure Chart -->
            {{-- <div class="row mt-4">

            </div> --}}
        </div>
    </div>

<script>
function generateColors(count) {
    const bgColors = [];
    const borderColors = [];

    for (let i = 0; i < count; i++) {
        const r = Math.floor(Math.random() * 156 + 100);
        const g = Math.floor(Math.random() * 156 + 100);
        const b = Math.floor(Math.random() * 156 + 100);

        bgColors.push(`rgba(${r}, ${g}, ${b}, 0.7)`);
        borderColors.push(`rgba(${r}, ${g}, ${b}, 1)`);
    }

    return { bgColors, borderColors };
}

// ========== MARKETER CHART ==========
const marketers = [
    @foreach ($commissions as $item)
        {
            name: '{{ $item->firstname . ' ' .$item->lastname }}',
            total_sales: {{ round($item->total_commission, 2) }} }{{ !$loop->last ? ',' : '' }}
    @endforeach
];

const marketerLabels = marketers.map(item => item.name);
const marketerDataValues = marketers.map(item => item.total_sales);
const marketerColors = generateColors(marketers.length);

const marketerData = {
    labels: marketerLabels,
    datasets: [{
        label: 'Total Sales (₦)',
        data: marketerDataValues,
        backgroundColor: marketerColors.bgColors,
        borderColor: marketerColors.borderColors,
        borderWidth: 1
    }]
};

const marketerConfig = {
    type: 'pie',
    data: marketerData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Best Performing Marketers'
            }
        }
    }
};

const marketerCtx = document.getElementById('marketerChart').getContext('2d');
new Chart(marketerCtx, marketerConfig);


// ========== TOP 1 CUSTOMER CHART (Current Year) ==========
const topCompanies = [
    @foreach ($topCompanies as $item)
        {
            name: '{{ $item->firstname . ' ' .$item->lastname }}',
            total_sales: {{ round($item->total_spent, 2) }} }{{ !$loop->last ? ',' : '' }}
    @endforeach
];

const companyLabels = topCompanies.map(item => item.name);
const companyDataValues = topCompanies.map(item => item.total_sales);
const companyColors = generateColors(topCompanies.length);

const companyData = {
    labels: companyLabels,
    datasets: [{
        label: 'Total Spent (₦)',
        data: companyDataValues,
        backgroundColor: companyColors.bgColors,
        borderColor: companyColors.borderColors,
        borderWidth: 1
    }]
};

const companyConfig = {
    type: 'bar',
    data: companyData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            title: {
                display: true,
                text: 'Top 10 Best Performing Customer (This Year)'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => '₦' + value.toLocaleString()
                }
            }
        }
    }
};

const companyCtx = document.getElementById('topCompaniesChart').getContext('2d');
new Chart(companyCtx, companyConfig);


// ========== MONTHLY REVENUE VS EXPENDITURE CHART ==========
const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
const revenueByMonth = @json($monthlyRevenue);
const expenseByMonth = @json($monthlyExpenses);

const revData = months.map((_, index) => revenueByMonth[index + 1] || 0);
const expData = months.map((_, index) => expenseByMonth[index + 1] || 0);

const revExpConfig = {
    type: 'line',
    data: {
        labels: months,
        datasets: [
            {
                label: 'Revenue (₦)',
                data: revData,
                borderColor: 'rgba(40, 167, 69, 1)',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            },
            {
                label: 'Expenditure (₦)',
                data: expData,
                borderColor: 'rgba(220, 53, 69, 1)',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Monthly Revenue vs Expenditure (This Year)'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: value => '₦' + value.toLocaleString()
                }
            }
        }
    }
};

const revExpCtx = document.getElementById('revenueExpenseChart').getContext('2d');
new Chart(revExpCtx, revExpConfig);
</script>

@endsection
