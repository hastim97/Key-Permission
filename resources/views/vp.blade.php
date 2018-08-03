<!DOCTYPE html>
<html lang="en">

@include('layout.header')
<script>
    if(sessionStorage.getItem("APIToken")=="null"){
        window.location.href="get_in";
    }
</script>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
<!-- Navigation-->

@include('layout.navigation');

<div class="content-wrapper">
    <div class="container-fluid">

        <!-- Icon Cards-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Admin Panel
                    <small></small>
                </h1>

                <div class="col-xs-12">
                    <table class="table table-bordered" id="table-data">
                        <tr>
                            <th>Student Name</th>
                            <th>Room Number</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Purpose</th>
                            <th>Special Notes</th>
                            <th>Approve</th>
                            <th>Unapprove</th>
                        </tr>

                    </table>
                </div>
            </div>
        <!-- /.row -->

        </div>

    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    @include('layout.logout')
    @include('layout.footer')

</div>
<script>

    var table=document.getElementById('table-body');
    var table_data=document.getElementById('table-data');

    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    jQuery.ajax({
        url:'getPermissionVp',
        type: 'GET',
        dataType: 'json',
        data: {
            api_token: sessionStorage.getItem("APIToken")
        },
        success: function(data){

            console.log(data);
            for(var i=0;i<data[0].length;i++){
                var tr=document.createElement('tr');
                tr.id=data[2][i]['id'];
                table_data.appendChild(tr);
                var td=document.createElement('td');
                td.innerHTML=data[1][i][0]['name'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[0][i][0]['room_no'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['start_date'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['end_date'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['start_time'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['end_time'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['purpose'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[2][i]['special_notes'];
                tr.appendChild(td);

                var td=document.createElement('td');
                var button=document.createElement('a');
                button.id='approve-'+i;
                button.className='btn btn-success approve';
                button.setAttribute("href","#");
                var span=document.createElement('span');
                span.className='fa fa-check';
                tr.appendChild(td);
                button.appendChild(span);
                td.appendChild(button);

                var td=document.createElement('td');
                var button=document.createElement('a');
                button.id='unapprove-'+i;
                button.className='btn btn-danger unapprove';
                button.setAttribute("href","#");
                var span=document.createElement('span');
                span.className='fa fa-remove';
                tr.appendChild(td);
                button.appendChild(span);
                td.appendChild(button);
            }
        },
        error: function (xhr, b, c) {
            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
        }
    });

    $('#table-data').on('click','.approve', function() {
        id = jQuery(this).closest('tr').attr('id');
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url: 'postPermissionVp',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:'{{ csrf_token() }}',
                permission_id: id,
                permission_vp: 1
            },
            success: function (data) {
                console.log(data);
                location.reload();
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });

    $('#table-data').on('click','.unapprove', function() {
        id = jQuery(this).closest('tr').attr('id');
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url: 'postPermissionVp',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:'{{ csrf_token() }}',
                permission_id: id,
                permission_vp: 0
            },
            success: function (data) {
                console.log(data);
                location.reload();
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });

</script>


</body>

</html>
