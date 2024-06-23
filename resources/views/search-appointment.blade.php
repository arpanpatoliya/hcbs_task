
@extends('layout.clinician_layout')

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
                                    <div class="col-sm-12">
                                        <label>Enter Appointment No</label>
                                        <input type="text" name="appt" id="appt" class="form-control">
                                        <br>
                                        <button type="button" class="btn border-t-neutral-500"  onclick="searchAppt()">Search</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block">
                               
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
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
@section('js')
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script>
<script src="{{ asset("js/firebase.js") }}"></script>
<script>
    function searchAppt(){
        if ($('#appt').val() == '') {
            notify('Please Enter Appointment No.')
            return false
        }
        $.ajax({
            url : "{{ route('get-appointment') }}",
            type : 'POST',
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : {
                appointment_no : $('#appt').val()
            },
            success:function(responce){
                if (responce.status) {
                    sign = "{{ asset('storage') }}/signatures/" + responce.data.signature
                    $('#clinician_name').text(responce.data.clinician.name);
                    $('#clinician_email').text(responce.data.clinician.email);
                    $('#patient_name').text(responce.data.name);
                    $('#patient_mobile').text(responce.data.name);
                    $('#time').text( responce.data.slot.date + ', ' + responce.data.slot.start_time + ' To ' +responce.data.slot.end_time);
                    $('#appointment_status').text(responce.data.appointment_status);
                    $('#sign').attr('src',sign);
                    $('#appt_no').text(responce.data.appointment_no);

                    $("#appointmentModel").modal('show');

                }
                notify(responce.message);
            }
        })
    }

</script>
@endsection
