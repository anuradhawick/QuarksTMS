<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#save').click(function(event) {
            var name = $('#levelname').val();
            if(name.length == 0){return;}
            $.post('/quarks/controller/admin/CreateUserLevel.php', {
                type: name
            }, function(data, textStatus, xhr) {
                if($.parseJSON(data)==true){
                    location.reload();
                }
            });
        });
    });
</script>
<div class="modal fade" id="adduser_level" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Add new access level</h4>
            </div>
            <div class="modal-body">
                <form id="trainingrequest" class="form-horizontal" role="form" onsubmit="return false;">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="email">Enter level name:</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="levelname" placeholder="eg: Manager">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="save" class="btn btn-default"> Ok</button>
            </div>
        </div>
    </div>
</div> 
