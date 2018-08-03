<!DOCTYPE html>
<html lang="en">

@include('layout.header');

<body class="bg-dark">
<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Register an Account</div>
        <div class="card-body">
            <form method="POST" id="register_form">

                <span id="error_message"></span>

                <div class="form-group">
                    <label for="inputName">Name</label>
                    <input class="form-control" id="inputName" type="text" aria-describedby="nameHelp" placeholder="Enter Name">
                </div>
                <div class="form-group">
                    <label for="inputEmail">Email</label>
                    <input class="form-control" id="inputEmail" type="text" aria-describedby="nameHelp" placeholder="Enter Email">
                </div>

                <span id="display_error" class="alert-danger"></span>

                <div class="form-group">
                    <label for="inputPassword">Password</label>
                    <input class="form-control" id="inputPassword" type="password" placeholder="Enter Password">
                </div>

                <div class="form-group">
                    <label for="confirmPassword">Confirm password</label>
                    <input class="form-control" id="confirmPassword" type="password" placeholder="Confirm password">
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input type="number" id="phone_number" class="form-control" placeholder="Phone Number">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Register</button>

            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="{{ url('get_in') }}">Login Page</a>
                <a class="d-block small" href="{{ url('forgot_password') }}">Forgot Password?</a>
            </div>
        </div>
    </div>
</div>

<script>
    $('#register_form').on('submit',function(e){
        $('#display_error').html("");
        e.preventDefault();

        var name=document.getElementById('inputName').value;
        var email=document.getElementById('inputEmail').value;
        var password=document.getElementById('inputPassword').value;
        var phone_no=document.getElementById('phone_number').value;
        var confirm_password=document.getElementById('confirmPassword').value;
        if(password!=confirm_password){
            $('#display_error').html("Passwords Do Not Match");
            return;
        }

        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url:'register',
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                phone_no: phone_no,
                password: password,
                _token:'{{ csrf_token() }}'
            },

            success: function( data ){
                console.log(data);
                if(data['message']=="success"){
                    window.location.href="get_in";
                }
                else{
                    window.location.href="create_account";
                    $('#error_message').html("Unable to Register! Try Again");
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
