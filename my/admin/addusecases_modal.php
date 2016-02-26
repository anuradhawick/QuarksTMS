<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#save').click(function(event) {
            var usecaseid = $('#usecase').children(':selected').attr('id');
            var levelid = $('#accesslevel').children(':selected').attr('id');
            if(levelid.length == 0){return;}
            $.post('/quarks/controller/admin/AssignUseCases.php', {
                user_level: levelid,
                usecases:usecaseid
            }, function(data, textStatus, xhr) {
                if($.parseJSON(data)==true){
                    location.reload();
                }
            });
        });
    });
</script>
<div class="modal fade" id="addusecases_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Add new access level</h4>
            </div>
            <div class="modal-body">
                <form id="trainingrequest" class="form-horizontal" role="form" onsubmit="return false;">
                    <select class="form-control" id="usecase">
                        <?php
                        require_once '../../API/admin/AccessPrivilegeDBHandler.php';
                        $arr = AccessPrivilegeDBHandler::getUseCases();
                        foreach ($arr as $level) {
                            ?>
                            <option id="<?php echo $level[0]; ?>"><?php echo $level[1]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </form>
            </div>
            <div class="modal-footer">
                <button id="save" class="btn btn-default"> Ok</button>
            </div>
        </div>
    </div>
</div> 
