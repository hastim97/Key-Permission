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
                            <th>Student Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Purpose</th>
                            <th>Special Notes</th>
                            <th>Approved</th>
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
        url:'getAllPermissionVp',
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

                var td=document.createElement('td');
                td.innerHTML=data[0][i][0]['room_no'];
                tr.appendChild(td);

                var td=document.createElement('td');
                td.innerHTML=data[1][i][0]['name'];
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
                var pVp=data[2][i]['permission_vp'];
                if(pVp==1)
                    td.innerHTML="Yes";
                else if(pVp==0)
                    td.innerHTML="No";
                tr.appendChild(td);
            }
        },
        error: function (xhr, b, c) {
            console.log("xhr=" + xhr + " b=" + b + " c=" + c);
        }
    });

</script>


</body>

</html>
