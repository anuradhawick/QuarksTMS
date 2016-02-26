<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#accesslevel').change(function(event) {
            var id = $(this).children(':selected').attr('id');
            $('#privileges').empty();
            $.get('/quarks/controller/admin/getUseCasesById.php?id='+id, function(data) {
                var arr = $.parseJSON(data);
                for (var i = arr.length - 1; i >= 0; i--) {
                    $('#privileges').append("<option id='"+arr[i][0]+"'>"+arr[i][1]+"</option>");                   
                };
            });
        });

        $('#addlevel').click(function(event) {
            $.get('adduserlevel_modal.php', function(data) {
                $('#modal_handler').html(data);
                $('#adduser_level').modal('show');
            });
        });

        $('#addprivileges').click(function(event) {
            var levelid = $('#accesslevel').children(':selected').attr('id');
            if(levelid.length == 0){
                $.get('userlevel_notselected.php', function(data) {
                    $('#modal_handler').html(data);
                    $('#levelselection').modal('show');
                });
                return;
            }
            $.get('addusecases_modal.php', function(data) {
                $('#modal_handler').html(data);
                $('#addusecases_modal').modal('show');
            });
        });

        $('#addusers').click(function(event) {
            var levelid = $('#accesslevel').children(':selected').attr('id');
            if(levelid.length == 0){
                $.get('userlevel_notselected.php', function(data) {
                    $('#modal_handler').html(data);
                    $('#levelselection').modal('show');
                });
                return;
            }
            $.get('addusers_modal.php', function(data) {
                $('#modal_handler').html(data);
                $('#addusers_modal').modal('show');
            });
        });

    });
</script>
<div class="col-sm-12 well">
    <h4>Access levels</h4>
    <form class="form-horizontal" role="form" onsubmit="return false">
        <div class="form-group">
            <label class="control-label col-sm-3" for="sel1">Select access level:</label>
            <div class="col-sm-6">
                <select class="form-control" id="accesslevel">
                    <option id="">Select access level</option>
                    <?php
                    require_once '../../API/admin/AccessPrivilegeDBHandler.php';
                    $arr = AccessPrivilegeDBHandler::getUserLevels();
                    foreach ($arr as $level) {
                        ?>
                        <option id="<?php echo $level[0]; ?>"><?php echo $level[1]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-6">
                <button id="addlevel" class="btn btn-default">Add new level</button>
            </div>
        </div>
    </form>
    <hr/>
    <h4>Access level privileges</h4>
  
    <form class="form-horizontal" role="form" onsubmit="return false">
        <div class="form-group">
            <label class="control-label col-sm-3" for="sel1">Privileges of the level:</label>
            <div class="col-sm-6">
                <select class="form-control" id="privileges">
                    
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-6">
                <button id="addprivileges" class="btn btn-default">Add privileges</button>
            </div>
        </div>
    </form>
    <hr/>
    <h4>Access level users</h4>
    <div id="users">

    </div>
    <form class="form-horizontal" role="form" onsubmit="return false">
        <div class="form-group">
            <label class="control-label col-sm-3"></label>
            <div class="col-sm-6">
                <button id="addusers" class="btn btn-default">Add users</button>
            </div>
        </div>
    </form>
</div>