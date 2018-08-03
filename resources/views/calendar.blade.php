<!DOCTYPE html>
<html lang="en">

@include('layout.header');
<script>
    if(sessionStorage.getItem("APIToken")=="null"){
        window.location.href="get_in";
    }
</script>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->

@include('layout.navigation')

<div class="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">My Dashboard</li>
        </ol>


        <div class="center">
            <form method="post" class="form-horizontal">
                <div class="form-group">
                    <label for="room-list">Select a room</label>
                    <select id="room-list" class="form-control" onchange="showOptions(this)">
                        <option>Choose the room number</option>
                    </select>
                </div>
            </form>
        </div>

        <br>
        <div class="container">

            <div class="panel panel-primary">
                <div class="panel-body" id="calendar"></div>
            </div>

            {{--Day Click Modal layout--}}
            <div class="modal hide fade" tabindex="-1" data-focus-on="input:first" id="myModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="padding:40px 50px;">
                            <p id="modal-data">
                                <span id="start-date"></span><br>
                                <span id="end-date"></span><br>
                                <span id="purpose"></span>
                            </p>
                        </div>
                        {{--data-toggle="modal" href="#formModal"--}}
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-default pull-left" onclick="toggleModal()"><span class="glyphicon glyphicon-remove"></span> Request</button>
                            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal hide fade" tabindex="-1" data-focus-on="input:first" id="formModal" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style="padding:20px 50px;overflow-y: scroll;max-height: 450px">

                            <div class="card card-login mx-auto mt-5">
                                <div class="card-body">
                                    <form id="submit_permission">
                                        {{ csrf_field() }}
                                        <span id="display_error" class="alert-danger"></span>

                                        <div class="form-group">
                                            <label id="room_no"></label>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_date">Start date</label>
                                            <input class="form-control" id="start_date" type="date">
                                        </div>

                                        <div class="form-group">
                                            <label for="end_date">End date</label>
                                            <input class="form-control" id="end_date" type="date">
                                        </div>

                                        <div class="form-group">
                                            <label for="start_time">Start time</label>
                                            <input type="time" id="start_time" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="end_time">End time</label>
                                            <input type="time" id="end_time" class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="input_purpose">Purpose</label>
                                            <input type="text" class="form-control" id="input_purpose" placeholder="Enter the purpose">
                                        </div>

                                        <div class="form-group">
                                            <label for="special_notes">Sepcial Notes</label>
                                            <input type="text" class="form-control" id="special_notes" placeholder="Enter any special notes">
                                        </div>

                                        <button class="btn btn-primary" type="submit" style="width: 100%;">Submit</button>

                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->

    @include('layout.logout');
    @include('layout.footer');
</div>
<script>
    function toggleModal(){
        $('#myModal').modal('hide');
        $('#formModal').modal('show');
    }
</script>
<script>

    var date_clicked;
    $(document).on('click','.fc-prev-button',function(){
        ajaxCall(room_id);
    });
    $(document).on('click','.fc-next-button',function(){
        ajaxCall(room_id);
    });
    $(document).on('click','.fc-month-button',function(){
        ajaxCall(room_id);
    });
    $(document).on('click','.fc-agendaWeek-button',function(){
        ajaxCall(room_id);
    });
    $(document).on('click','.fc-agendaDay-button',function(){
        ajaxCall(room_id);
    });
    $(document).on('click','.fc-today-button',function(){
        ajaxCall(room_id);
    });

    // method showOptions runs when any particular room is selected
    function showOptions(s){
        room_id=s[s.selectedIndex].id;
        ajaxCall(room_id);
        var room_no=$("#room-list :selected").text();
        console.log(room_no);
        document.getElementById('room_no').innerHTML="";
        document.getElementById('room_no').innerHTML="Room Number : "+room_no;
    }

    function ajaxCall(room_id){
        var current_date = new Date($("#calendar").fullCalendar('getDate'));
        var month_int = current_date.getMonth();
        // console.log(month_int);
        var year_int=current_date.getFullYear();
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        //ajax call made to get all the events for the particular month and year and room number
        jQuery.ajax({
            url:'getPermissionRoom',
            type: 'GET',
            dataType: 'json',
            data: {
                month: month_int+1,
                room_id: room_id,
                year: year_int
            },
            success: function( data ){
                $('#calendar').fullCalendar( 'removeEvents');
                for(var i=0;i<data.length;i++) {

                    var event_title = data[i]['purpose'];
                    var s_date = data[i]['start_date'];
                    var e_date = data[i]['end_date'];
                    var s_time = data[i]['start_time'];
                    var e_time = data[i]['end_time'];
                    var event={title:event_title, description: event_title, start: s_date+" "+s_time, end: e_date+" "+e_time};
                    $('#calendar').fullCalendar( 'renderEvent', event, false);
                }
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    }

    var room_id;
    var room_list=document.getElementById('room-list');
    var modal_data=document.getElementById('modal-data');
    // used for displaying the calendar
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            eventRender: function (event, element) {
                event.allDay=false;
                element.attr('href', 'javascript:void(0);');
                element.click(function() {
                    $('#myModal').find('.purpose').remove();
                    $('#start-date').html("<strong>Start Date : </strong>"+moment(event.start).format('MMM Do')+"    <strong>Start Time : </strong>"+moment(event.start).format('h:mm A'));
                    $('#end-date').html("<strong>End Date : </strong>"+moment(event.end).format('MMM Do')+"  <strong>End Time : </strong>"+moment(event.end).format('h:mm A'));
                    $('#purpose').html("<strong>Event : </strong>"+event.description);
                    $("#myModal").modal();
                });
            },

            dayClick: function(date, jsEvent, view) {
                // console.log(date.format());
                date_clicked=date.format();
                $('#purpose').html("");
                // $('#myModal').find('.purpose').remove();
                $('#start-date').html("<strong>Date : </strong>"+date.format('MMM Do'));
                $('#end-date').html("");
                $('#myModal').modal();
            }

        });

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        //ajax call made to get all the events for the particular month and year and room number
        jQuery.ajax({
            url:'getRooms',
            type: 'GET',
            dataType: 'json',
            data: {
            },
            success: function( data ){
                for(var i=0;i<data.length;i++){
                    var opt=document.createElement('option');
                    opt.innerHTML=data[i]['room_no'];
                    opt.id=data[i]['id'];
                    room_list.appendChild(opt);
                }
                $("#room-list option:first").attr('selected','selected');
                room_id = $('#room-list').find(":selected").id;
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
        ajaxCall(room_id);
    });

    $('#submit_permission').on('submit',function(e) {

        e.preventDefault();
        var start_date = document.getElementById('start_date').value;
        var end_date = document.getElementById('end_date').value;
        var start_time = document.getElementById('start_time').value;
        var end_time = document.getElementById('end_time').value;
        var purpose = document.getElementById('input_purpose').value;
        var special_notes = document.getElementById('special_notes').value;

        $.ajaxSetup({
            headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
        });

        jQuery.ajax({
            url:'postPermission',
            type: 'POST',
            dataType: 'json',
            data: {
                start_date: start_date,
                end_date: end_date,
                start_time: start_time,
                end_time: end_time,
                purpose: purpose,
                special_notes: special_notes,
                api_token: sessionStorage.getItem("APIToken"),
                room_id: room_id,
                _token:'{{ csrf_token() }}'
            },

            success: function( data ){
                console.log(data);
                swal("Done");
                $('#formModal').modal('toggle');
                ajaxCall(room_id);
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
                swal("Oops!", "Something went wrong on the page!", "error");
            }
        });
    });

</script>

</body>

</html>
