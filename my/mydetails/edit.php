<style type="text/css">
    .btn-file {
        position: relative;
        overflow: hidden;
    }
    .btn-file input[type=file] {
        position: absolute;
        top: 0;
        right: 0;
        min-width: 100%;
        min-height: 100%;
        font-size: 100px;
        text-align: right;
        filter: alpha(opacity=0);
        opacity: 0;
        outline: none;
        background: white;
        cursor: inherit;
        display: block;
        z-index: -1;
    }
</style>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on('submit', '#image_upload', function(event) {
            alert('Not supported');
        });     

        $(document).on('keyup', '.pwd', function(event) {
            event.preventDefault();
            if ($('#password').val().length == 0) { 
                $('#pw_btn').removeClass('btn-success');
                return;
                };
            if($('#password').val() == $('#rpw').val()){
                $('#pw_btn').addClass('btn-success');
            } else {
                $('#pw_btn').removeClass('btn-success');
            }
        });

        $(document).on('submit', '#changepw', function(event) {
            event.preventDefault();
            if($('#password').val() != $('#rpw').val()){
                return;
            } 
            if($('#password').val().length < 4 || $('#password').val().length == 0){
                $.get('changepw_modal.php?ty=2', function(data) {
                    $('#modal_handler').html(data);
                    $('#changepw_modal').modal('show');
                }); 
                return;
            }
            var password = $('#password').val();
            var currpwd = $('#cpw').val();
            $.post('/quarks/controller/employee/update_password.php', 
                {
                    password: password,
                    currpwd: currpwd
                } ,function(data, textStatus, xhr) {
                    if($.parseJSON(data) == true){
                        $.get('changepw_modal.php', function(data) {
                            $('#modal_handler').html(data);
                            $('#changepw_modal').modal('show');
                        });
                    } else {
                        $.get('changepw_modal.php?ty=1', function(data) {
                            $('#modal_handler').html(data);
                            $('#changepw_modal').modal('show');
                        });
                    }
            });
        });
    });
</script>
<div class="container">
    <!-- <div class="col-sm-12 well">
        <h4>Change profile picture</h4>
        <hr/>
        <div>
            <img src="../../images/Generic_Avatar.png" style="margin: 0 auto" width="200px" height="200px">
        </div>
        <hr/>
        <form id="image_upload" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
            <div class="input-group">
                <span class="input-group-btn">
                    <span class="btn btn-default btn-file">
                        Browse… <input multiple="" type="file">
                    </span>
                </span>
                <input class="form-control" readonly="" type="text">
            </div>
            <div class="">
                <br/>
                <button class="btn btn-default">Update</button>
            </div>
        </form>
    </div> -->
    <div class="col-sm-12 well">
        <h4>Change password</h4>
        <hr/>
        <form id="changepw" class="form-horizontal" role="form" onsubmit="return false;">
            <div class="form-group">
                <label class="control-label col-sm-4" for="cpw">Current password:</label>
                <div class="col-sm-6">
                    <input type="password" class="form-control" id="cpw" placeholder="Enter current password" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4" for="pw">New password:</label>
                <div class="col-sm-6">
                    <input id="password" type="password" class="form-control pwd" id="pw" placeholder="Enter new password" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-4" for="rpw">Repeat password:</label>
                <div class="col-sm-6">
                    <input class="form-control pwd" id="rpw" placeholder="Enter new password again" type="password" required>
                </div>
            </div>
            <div class="">
                <br/>
                <button id="pw_btn" class="btn btn-default">Update</button>
            </div>
        </form>
    </div>
</div>