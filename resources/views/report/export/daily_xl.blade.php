<div class="col-12 mt-2">
                            Today's collection: <span class="badge badge-warning"> <i class="fa fa-inr"
                            aria-hidden="true"></i>{{ Helper::rupee_format($schedules_amount)}}</span>
                        </div>


                        <div class="toolbar">
                            <!--        Here you can write extra buttons/actions for the toolbar              -->
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                       
                                        <th>Account No.</th>
                                        <th>Installment Amount (Total = {{ Helper::rupee_format($schedules_amount)}})</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>
                                      
                                    </tr>
                                </thead>

                                
                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                   
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ Helper::rupee_format($schedule->installment_amount )}}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>
                                       
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>