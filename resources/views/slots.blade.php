@extends('layout.clinician_layout')
@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- The core Firebase JS SDK is always required and must be listed first -->

    <style>
        .card-block {
            height: 100%; /* Adjust height as needed */
            overflow: auto;
        }
        #calendar {
            width: 100%; /* Ensure the calendar takes full width of its container */
        }
        #signature-pad {
            border: 1px solid #000;
            width: 100%;
            height: 150px;
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
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label>Select Clinician</label>
                                        <select id="clinician" name="clinician" class="form-control select2">
                                            @foreach ($clinician as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
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
                <h5 id="time"></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form action="" id="appointment-form" method="post">

                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Clinician Name : </label> <b id="clinician_name"></b>   
                        </div> 
                        <div class="col-md-6">
                            <label> Gender : </label> <b id="clinician_gender"></b>   
                        </div> 
                        <div class="col-md-6">
                            <label> Email : </label> <b id="clinician_email"></b>   
                        </div> 
                        <div class="col-md-6">
                            <label> Occupation : </label> <b id="clinician_occupation"></b>   
                        </div> 
                    </div>
                    <hr>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" placeholder="Enter Your Name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Phone No.</label>
                        <input type="text" name="phone_number" id="mobile" placeholder="Enter Mobile No." class="form-control">
                        <input type="hidden" name="fcm_token" value="" id="fcm_token">
                    </div>
                    <input type="hidden" name="signature" id="signature-input">
                    <label>Signature</label>
                    <div id="signature-pad" class="signature-pad">
                        <canvas width="465" height="150"></canvas>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="bookAppt"  class="btn btn-primary">Book Appointment</button>
                    <button type="button" id="clear-signature"  class="btn btn-danger">Clear Sign</button>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\AppointmentSaveRequest', '#appointment-form') !!}
<script src="{{ asset("js/bootbox.min.js") }}"></script>

<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="{{ asset("js/firebase.js") }}"></script>

<script>

    const canvas = document.querySelector("#signature-pad canvas");
        const signaturePad = new SignaturePad(canvas);
        const clearBtn = document.getElementById('clear-signature');
        const signatureInput = document.getElementById('signature-input');
        const formSubmit = document.getElementById('appointment-form');

        clearBtn.addEventListener('click', () => {
            signaturePad.clear();
            signatureInput.value = '';
        });

        formSubmit.addEventListener('submit', (e) => {
            if (signaturePad.isEmpty()) {
                notify('Please provide a signature first.');
                return;
            }
            const dataURL = signaturePad.toDataURL('image/png');
            signatureInput.value = dataURL;
        });
    $('.select2').select2({
        placeholder: "Please select clinician",
        allowClear: true
    });
    $('#clinician').on('change',function(){
        $('#calendar').fullCalendar('refetchEvents');                                     
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
            clinician_id = $('#clinician').val();
            if (clinician_id) {
                $.ajax({
                    url: '{{ route('slot_ajax') }}',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        start: start.format(),
                        end: end.format(),
                        clinician_id : clinician_id
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
                                    color: '#ffc107',
                                };
                            });
                            callback(events);
                        } 
                    },
                });   
            }
        },
        selectable:true,
        selectHelper: true,
        select: function(start, end) {

        },
        eventClick: function(event) {
            console.log(event);
            var id = event.id;
            $.ajax({
                url: '{{ route('single_slot', ['id' => 'ID_PLACEHOLDER']) }}'.replace('ID_PLACEHOLDER', id),
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){
                    if (response.status) {
                        $("#appointmentModel").modal('show');

                        $('#clinician_name').text(response.data.clinician.name);
                        $('#clinician_gender').text(response.data.clinician.gender);
                        $('#clinician_email').text(response.data.clinician.email);
                        $('#clinician_occupation').text(response.data.clinician.occupation);
                        $('#time').text('Slot On ' + response.data.date + ', ' + response.data.start_time + ' To ' +response.data.end_time);
                        $("#appointment-form").attr('action', "{{ route('appointment-save', '') }}/"+response.data.id);
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
