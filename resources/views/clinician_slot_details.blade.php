@extends('layout.clinician_layout')
@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <style>
        .card-block {
            height: 100%; /* Adjust height as needed */
            overflow: auto;
        }
        #calendar {
            width: 100%; /* Ensure the calendar takes full width of its container */
        }

    </style>

@endsection
@section('content')
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row">
                        <div class="card">
                            <div class="card-header">
                                <h4><button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#createSlotModal">Add Slot</button></h4>
                            </div>
                            <div class="card-block">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="createSlotModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Add Slot</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form action="{{ route('clinician-slot_store') }}" id="stote-form" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="slot_date" id="slot_date" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time"  class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" class="form-control" >
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">SAVE</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>

    </div>
</div>
<div id="updateSlotModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4>Update Slot</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <form action="" id="update-form" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" name="slot_date" id="update_slot_date" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Start Time</label>
                        <input type="time" name="start_time" id="update_start_time"  class="form-control">
                    </div>
                    <div class="form-group">
                        <label>End Time</label>
                        <input type="time" name="end_time" id="update_end_time" class="form-control">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="update" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-danger" id="deleteButton" >Delete</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>

        </div>

    </div>
</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
<script src="{{ asset("js/bootbox.min.js") }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\SlotStoreRequest', '#stote-form') !!}
{!! JsValidator::formRequest('App\Http\Requests\SlotUpdateRequest', '#update-form') !!}

<script>
    $(document).ready(function() {
        $('#slot_date').on('change', function() {
            const date = new Date(this.value);
            const day = date.getUTCDay();
            if (day === 0 || day === 6) {
                notify('Saturdays and Sundays are not allowed.');
                $(this).val('');
                return false;
            }
        });

        $('#update_slot_date').on('change', function() {
            const date = new Date(this.value);
            const day = date.getUTCDay();
            if (day === 0 || day === 6) {
                notify('Saturdays and Sundays are not allowed.');
                $(this).val('');
                return false;
            }
        });
    });
    var calendar = $('#calendar').fullCalendar({
        editable:false,
        header:{
            left:'prev,next today',
            center:'title',
            // right:'month,agendaWeek,agendaDay'
            right:'month'
        },
        events: function(start, end, timezone, callback) {
            $.ajax({
                url: '{{ route('clinician-slot_ajax') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    start: start.format(),
                    end: end.format(),
                },
                success: function(response) {
                    if (response.status && response.data) {
                        var events = response.data.map(function(event) {
                            var startTime = moment(event.start_time).format('HH:mm:ss');
                            var endTime = moment(event.end_time).format('HH:mm:ss');
                            return {
                                id: event.id,
                                title: 'Slot ' + event.slot_no + ' - ' + startTime + ' To ' + endTime,
                                start: event.start_time,
                                end: event.end_time,
                                color: (event.is_booked)?'#28a745':'#ffc107',
                            };
                        });
                        callback(events);
                    } 
                },
            });
        },
        selectable:true,
        selectHelper: true,
        select: function(start, end) {

        },
        eventClick: function(event) {
            var id = event.id;
            $.ajax({
                url: '{{ route('clinician-single_slot', ['id' => 'ID_PLACEHOLDER']) }}'.replace('ID_PLACEHOLDER', id),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if (response.status) {
                        $("#updateSlotModal").modal('show');

                        $('#update_slot_date').val(response.data.date);
                        $('#update_start_time').val(response.data.start_time);
                        $('#update_end_time').val(response.data.end_time);
                        $("#update-form").attr('action', "{{ route('clinician-slot_update', '') }}/"+response.data.id);
                        $('#deleteButton').off('click').on('click', function() {
                            deleteSlot(response.data.id);
                        });
                    }else{
                        notify(response.message)
                    }
                },
            });
        }
    });

    function deleteSlot(id) {
            $("#updateSlotModal").modal('hide');
            bootbox.confirm({
                message: 'Are You sure want to Delete This Slot ?',
                buttons: {
                confirm: {
                        label: 'Yes',
                        className: 'btn-primary'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        $.ajax({
                            url: "{{ route('clinician-slot_delete', '') }}/" + id,
                            type: "GET",
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {

                                if (response.status) {
                                    $('#calendar').fullCalendar('refetchEvents');                                     
                                }
                                notify(response.message);
                            }
                        });
                    }
                }
            });


        }
    
</script>
@endsection
