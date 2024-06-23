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
                                    <label>Complet Appointment :</label>
                                    <input type="color" disabled value="#28a745" >
                                        <br>
                                    <label>Pending Appointment :</label>
                                    <input type="color" disabled value="#ffc107" >
                                    <br>
                                    <label>Cancelled Appointment :</label>
                                    <input type="color" disabled value="#fe5d70" >
                                    <br>
                                    <label>Confirmed Appointment :</label>
                                    <input type="color" disabled value="#007bff" >
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
<div id="appointmentModel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="appt_no"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
           
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Clinician Name : </label> <b id="clinician_name"></b>   
                    </div> 
                    <hr>
                    <div class="col-md-6">
                        <label>Clinician Email : </label> <b id="clinician_email"></b>   
                    </div> 
                    <hr>

                    <div class="col-md-6">
                        <label>Patient Name : </label> <b id="patient_name"></b>   
                    </div> 
                    <hr>

                    <div class="col-md-6">
                        <label>Patient Mobile No. : </label> <b id="patient_mobile"></b>   
                    </div> 
                    <hr>

                    <div class="col-md-6">
                        <label>Appt Time : </label> <b id="time"></b>   
                    </div> 
                    <hr>

                    <div class="col-md-6">
                        <label>Appointment Status </label> <b id="appointment_status"></b>   
                    </div> 
                    <hr>
                    <br>
                    <div class="col-md-12">
                        Signature <br>
                        <img src="" id="sign" height="100px" width="200px">   
                    </div>

                    <div class="col-md-12">
                        <form method="POST" id="status-form">
                            @csrf
                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Cancelled">Cancelled</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </form>
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
                    success: function(response) {
                        if (response.status && response.data) {
                        var events = response.data.map(function(event) {
                            
                            var startTime = moment(event.start_time).format('HH:mm:ss');
                            var endTime = moment(event.end_time).format('HH:mm:ss');
                            var color;
                            'Confirmed','Cancelled','Completed','Pending'
                            switch(event.appointment_status) {
                                case 'Completed':
                                    color = '#28a745'; 
                                    break;
                                case 'Pending':
                                    color = '#ffc107'; 
                                    break;
                                case 'Cancelled':
                                    color = '#fe5d70'
                                    break;

                                case 'Confirmed':
                                    color = '#007bff'
                                    break;

                                default:
                                    color = '#007bff'; // Default color
                            }

                            return {
                                id: event.id,
                                title: 'Slot ' + event.appt_no + ' - ' + startTime + ' To ' + endTime,
                                start: event.start_time,
                                end: event.end_time,
                                color: color,
                            };
                        });
                        callback(events);
                    } 
                    }
                });
            },
            selectable:true,
            selectHelper: true,
            select: function(start, end) {
                // Handle when user selects a date/time range
                // Example: Open a modal or form for creating an appointment
            },
            eventClick: function(event) {
            var id = event.id;
            $.ajax({
                url: '{{ route('clinician-SingleAppointment', ['appointment' => 'ID_PLACEHOLDER']) }}'.replace('ID_PLACEHOLDER', id),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    console.log(response);
                    if (response.status) {
                        $("#appointmentModel").modal('show');
                        sign = "{{ asset('storage') }}/signatures/" + response.data.signature

                        $('#clinician_name').text(response.data.clinician.name);
                        $('#clinician_email').text(response.data.clinician.email);
                        $('#patient_name').text(response.data.name);
                        $('#patient_mobile').text(response.data.name);
                        $('#time').text( response.data.slot.date + ', ' + response.data.slot.start_time + ' To ' +response.data.slot.end_time);
                        $('#appointment_status').text(response.data.appointment_status);
                        $('#sign').attr('src',sign);
                        $('#status').val(response.data.appointment_status);
                        $('#appt_no').text(response.data.appointment_no);

                        $("#status-form").attr('action', "{{ route('clinician-appointment_status', '') }}/"+response.data.id);
                    }else{
                        notify(response.message)
                    }
                },
            });
        }
        });
        
    </script>
@endsection
