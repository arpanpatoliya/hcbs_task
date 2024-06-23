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
                                {{-- <h5><button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#createRoleModal">Add Role</button></h5> --}}
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
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script>
        var calendar = $('#calendar').fullCalendar({
            editable:true,
            header:{
                left:'prev,next today',
                center:'title',
                // right:'month,agendaWeek,agendaDay'
                right:'month'
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: '{{ route('clinician-appointment_ajax') }}',
                    type: 'POST',
                    headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        start: start.format(),
                        end: end.format(),
                    },
                    success: function(data) {
                        var events = [];
                        $(data).each(function() {
                            events.push({
                                id: this.id,
                                title: this.title,
                                start: this.start,
                                end: this.end
                            });
                        });
                        callback(events);
                    }
                });
            },
            selectable:true,
            selectHelper: true,
            select: function(start, end) {
                // Handle when user selects a date/time range
                // Example: Open a modal or form for creating an appointment
                alert(start, end);
            },
        });
        
    </script>
@endsection
