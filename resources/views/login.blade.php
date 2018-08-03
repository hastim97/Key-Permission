<!DOCTYPE html>
<html lang="en">

@include('layout.header');
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Login</div>

        <div class="card-body">
            <form id="login_form" method="post">

                <span id="display_error" class="alert-danger"></span>

                <div class="form-group">
                    <label for="input_email">Email address</label>
                    <input class="form-control" id="input_email" type="email" aria-describedby="emailHelp" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="input_password">Password</label>
                    <input class="form-control" id="input_password" type="password" placeholder="Password">
                </div>

                <button class="btn btn-primary" type="submit" style="width: 100%;">Login</button>

            </form>

            <div class="text-center">
                <a class="d-block small mt-3" href="{{ url('create_account') }}">Register an Account</a>
                <a class="d-block small" href="{{ url('forgot_password') }}">Forgot Password?</a>
            </div>

        </div>
    </div>
</div>

<script>

    $('#login_form').on('submit',function(e){
        $('#display_error').html("");
        var email=document.getElementById('input_email').value;
        var password=document.getElementById('input_password').value;
        e.preventDefault();

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url:'login',
            type: 'POST',
            dataType: 'json',
            data: {
                email: email,
                password: password,
                _token:'{{ csrf_token() }}'
            },

            success: function( data ){
                // console.log(data);
                if(data['message']=="success"){
                    // console.log(data);
                    // console.log(data['data']['api_token']);
                    sessionStorage.setItem("APIToken",data['data']['api_token']);
                    // console.log(sessionStorage.getItem("APIToken"));
                    if(data['data']['role']=="Student")
                        window.location.href="events";
                    else if(data['data']['role']=='HOD')
                        window.location.href="hod";
                    else
                        window.location.href='vp';
                }
                else{
                    $('#display_error').html("Wrong Credentials Entered!");
                }
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });
</script>

</body>

</html>
