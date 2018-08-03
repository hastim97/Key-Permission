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
                    All Permissions
                    <small></small>
                </h1>

                <div class="col-xs-12">
                    <table class="table table-bordered" id="table-data">
                        <tr>
                            <th>Room Number</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Purpose</th>
                            <th>Special Notes</th>
                            <th>Approved</th>
                            <th>Delete</th>
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
    $.ajaxSetup({
        headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
    });

    var table_data=document.getElementById('table-data');
    //ajax call made to get all the events for the particular month and year and room number
    jQuery.ajax({
        url:'getPermissionUser',
        type: 'GET',
        dataType: 'json',
        data: {
            api_token: sessionStorage.getItem("APIToken")
        },
        success: function(data){

            console.log(data);
            for(var i=0;i<data[0].length;i++){
                var tr=document.createElement('tr');
                table_data.appendChild(tr);
                tr.id=data[1][i]['id'];

                var td=document.createElement('td');
                td.innerHTML=data[0][i][0]['room_no'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['start_date'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['end_date'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['start_time'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['end_time'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['purpose'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i]['special_notes'];
                tr.appendChild(td);

                var td=document.createElement('td');
                var pHod=data[1][i]['permission_hod'];
                var pVp=data[1][i]['permission_vp'];
                if(pHod==1 && pVp==1)
                    td.innerHTML="Yes";
                else
                    td.innerHTML="No";
                tr.appendChild(td);

                var td=document.createElement('td');
                var button=document.createElement('a');
                button.className='btn btn-danger deletePermission';
                button.setAttribute("href","");
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

    $('#table-data').on('click','.deletePermission', function() {
        id = jQuery(this).closest('tr').attr('id');
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url: 'deletePermission',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:'{{ csrf_token() }}',
                permission_id: id
                // permission_vp: 1
            },
            success: function (data) {
                console.log(data);
                // location.reload();
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });

</script>


</body>

</html>
