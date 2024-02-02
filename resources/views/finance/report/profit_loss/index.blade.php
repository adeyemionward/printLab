
@extends('layout.master')
@section('content')
@section('title', 'Profit/Loss Report')
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-2">
                <div class="col-md-6 float-start">
                    <h4 class="m-0 text-dark text-muted">All Debtors</h4>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb float-end">
                        <li class="breadcrumb-item"><a href="#"> Debtors</a></li>
                        <li class="breadcrumb-item active">All Debtors</li>
                    </ol>
                </div>
            </div>

            <div class="card">
                <div class="content" id="tableContent">
                    <div class="canvas-wrapper">
                        @include('includes.date_range')
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Income</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Category</td>
                                    <td>3000</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Income</th>
                                    <th>2000</th>
                                </tr>
                            </tfoot>
                        </table>
                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Expenses</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Category</td>
                                    <td>3000</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Total Expenses</th>
                                    <th>2000</th>
                                </tr>
                            </tfoot>
                        </table>

                        <br><br>
                        <table id="example1" class="table no-margin" style="width:100%">
                            <tfoot>
                                <tr>
                                    <th>Profit/Loss</th>
                                    <th>2000</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

