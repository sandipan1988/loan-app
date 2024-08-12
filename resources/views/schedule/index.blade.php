@extends('layouts.app', ['activePage' => 'schedule', 'title' => 'Schedules', 'navName' => 'Schedules', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Search
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="name" class="col-form-label text-md-right">By Name</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="name" class="form-control" name="name"
                                                required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="row">
                                        <div class="col-1">
                                            <label for="date-of-birth" class="col-form-label text-md-right">By Date</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="date-of-birth"
                                                name="date-of-birth">
                                        </div>
                                        <div class="col-4">
                                            <a href="" class="btn btn-sm btn-default mt-2">SEARCH</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-2">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">

                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Customer payment schedule</h3>
                                    <p class="text-sm mb-0">
                                        This is payment management.
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <a href="" class="btn btn-sm btn-default">Submit</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                        </div>

                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Account No.</th>
                                        <th>Name</th>
                                        <th>Installment Amount</th>
                                        <th>Date</th>
                                        <th>Paid <input type="checkbox" name="all-chk" class="check-space" id="paid1" />
                                        </th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Account No.</th>
                                        <th>Name</th>
                                        <th>Installment Amount</th>
                                        <th>Date</th>
                                        <th>Paid <input type="checkbox" name="all-chk" class="check-space" id="paid2" />
                                        </th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                    <tr>
                                        <td>A0000001</td>
                                        <td>SK</td>
                                        <td>300</td>
                                        <td>2024-02-25</td>
                                        <td class="">
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="all-chk"
                                                class="check-space" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A0000002</td>
                                        <td>SB</td>
                                        <td>2000</td>
                                        <td>2024-02-25</td>
                                        <td class="">
                                            <input type="checkbox" name="all-chk" class="check-space" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>A0000003</td>
                                        <td>SA</td>
                                        <td>10000</td>
                                        <td>2024-02-25</td>
                                        <td class="">
                                            <input type="checkbox" name="all-chk" class="check-space" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#paid1,#paid2').click( function() {
                if(this.checked){
                    $(".check-space").attr('checked', 'checked');
                }
                else{
                    $(".check-space").removeAttr('checked');
                }


            });
        });
    </script>
@endpush
