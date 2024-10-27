@extends('layouts.app', ['activePage' => 'schedule', 'title' => 'Schedules', 'navName' => 'Schedules', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('search-schedule') }}">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Search
                            <div class="row">

                                    @csrf
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-2">
                                            <label for="name" class="col-form-label text-md-right">By Name</label>
                                        </div>
                                        <div class="col-8">
                                            <input type="text" id="name" class="form-control" name="name" value="{{$name}}">
                                            <input type="hidden" id="phone" class="form-control" name="phone" value="{{$phone}}">
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
                                                name="search-date" value="{{ $search_date ? $search_date->format('Y-m-d') :''}}" required>
                                        </div>
                                        <div class="col-4">
                                            <button type="submit" class="btn btn-sm btn-default mt-2">SEARCH</button>
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
        </form>
            <div class="row">
                <div class="col-md-12">
                    <div class="card data-tables">
                        @if (!empty($message['success']) && $message['success'])
                            <div class="alert alert-primary">
                                {{ $message['message'] }}
                            </div>
                        @elseif(!empty($message['success']) && $message['success'] == false)
                            <div class="alert alert-error">
                                {{ $message['message'] }}
                            </div>
                        @endif
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Customer payment schedule</h3>
                                    <p class="text-sm mb-0">
                                        This is payment management.
                                    </p>
                                </div>
                                <div class="col-4 text-right">
                                    <form method="POST" action="{{ route('submit-schedule') }}">
                                        @csrf
                                        <input type="hidden" name="schedule_ids" value="" id="schedule_ids" />
                                        <button class="btn btn-sm btn-default">Submit</Button>
                                    </form>

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
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Account No.</th>
                                        <th>Installment Amount</th>
                                        <th>Imnstallment Date</th>
                                        <th>Paid Status</th>
                                        <th>Pay <input type="checkbox" class="" id="paid1"
                                                onClick="check_uncheck_checkbox(this.checked);" />
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($schedules as $schedule)
                                        <tr>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[0] }}</td>
                                            <td>{{ Helper::memberNameandPhone($schedule->loan->member_id)[1]  }}</td>
                                            <td>{{ $schedule->loan->loan_account }}</td>
                                            <td>{{ $schedule->installment_amount }}</td>
                                            <td>{{ $schedule->installment_date->format('d-m-Y') }}</td>
                                            <td>{{ $schedule->is_paid }}</td>
                                            <td class="">
                                                @if($schedule->is_paid !="YES")
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="all-chk"
                                                    value="{{ $schedule->schedule_id }}" class="check-space"
                                                    onClick="single(this.checked,'{{ $schedule->schedule_id }}')" />
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{$schedules->links()}}

            </div>

        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function check_uncheck_checkbox(isChecked) {
            arr = [];
            if (isChecked) {
                $('input[name="all-chk"]').each(function() {
                    this.checked = true;
                    arr.push($(this).val());
                });
            } else {
                $('input[name="all-chk"]').each(function() {
                    this.checked = false;
                    arr.pop($(this).val());
                });
            }
            $("#schedule_ids").val(arr.join(','));

        }


        function single(checked, id) {
            arr1 = $("#schedule_ids").val().split(",");

            if (checked) {
                if (!arr1.includes(id))
                    arr1.push(id);

            } else {
                console.log(arr1);

                const index = arr1.indexOf(id);

                arr1.splice(index, 1);
                console.log(arr1);
             }
            $("#schedule_ids").val(arr1.join(','));

        }
    </script>
@endpush
@push('js')
<script type="text/javascript">
    $(document).ready(function() {

        $('#date-of-birth').on('click', function(){
            $(this).val('');
        });
        $('#name').autocomplete({
            source: function(request, response) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('find-by-name')}}", // Replace with your server-side script URL
                    dataType: 'json',
                    method: "POST",
                    data: {
                        name: request.term
                    },
                    success: function(data) {
                        var names = [];
                        for (var i = 0; i < data.length; i++) {
                            names[i] = data[i].name + ", " + data[i].phone;

                        }
                        response(names);
                    }
                });
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            minLength: 2, // Minimum number of characters to trigger the auto-suggestion,

            select: function(event, ui) {
               // console.log(ui.item);
                event.preventDefault();
                var name = ui.item.value.split(",")[0];
                var phone = ui.item.value.split(", ")[1];
                $('#name').val(name);
                $('#phone').val(phone);
                
            },
           

        });
    });
</script>
@endpush
