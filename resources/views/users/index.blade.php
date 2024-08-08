@extends('layouts.app', ['activePage' => 'members',
'title' => 'Members',
'navName' => 'Members', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card data-tables">

                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h3 class="mb-0">Users</h3>
                                <p class="text-sm mb-0">
                                    Users List
                                </p>
                            </div>
                            <div class="col-4 text-right">
                                <a href="#" class="btn btn-sm btn-default">Add user</a>
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
                                    <th>Paid <input type="checkbox" name="all-chk" /></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                <th>Account No.</th>
                                    <th>Name</th>
                                    <th>Installment Amount</th>
                                    <th>Date</th>
                                    <th>Paid <input type="checkbox" name="all-chk" /></th>
                                </tr>
                            </tfoot>
                            <tbody>

                                <tr>
                                    <td>Admin Admin1</td>
                                    <td>admin1@lightbp.com</td>
                                    <td>1</td>
                                    <td class="d-flex justify-content-end">

                                        <a href="#"><i class="fa fa-edit"></i></a>
                                        <a href=""><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Admin Admin2</td>
                                    <td>admin2@lightbp.com</td>
                                    <td>2</td>
                                    <td class="d-flex justify-content-end">

                                        <a href="#"><i class="fa fa-edit"></i></a>
                                        <a href=""><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Admin Admin3</td>
                                    <td>admin3@lightbp.com</td>
                                    <td>3</td>
                                    <td class="d-flex justify-content-end">

                                        <a href="#"><i class="fa fa-edit"></i></a>
                                        <a href=""><i class="fa fa-trash"></i></a>
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