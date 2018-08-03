<!-- Logout Modal-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-warning" type="button" id="logout">Logout</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#logout').on('click',function(e){
        e.preventDefault();
        var api=sessionStorage.getItem("APIToken");
        $.ajaxSetup({
            headers: { 'X-CSRF-Token' : $('meta[name=_token]').attr('content') }
        });

        jQuery.ajax({
            url:'logout',
            type: 'POST',
            dataType: 'json',
            data: {
                api_token: api,
                _token:'{{ csrf_token() }}'
            },
            success: function( data ){
                console.log(data);
                sessionStorage.setItem("APIToken",null);
                window.location.href="get_in";
            },
            error: function (xhr, b, c) {
                console.log("xhr=" + xhr + " b=" + b + " c=" + c);
            }
        });
    });
</script>
