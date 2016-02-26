<script type="text/javascript">
    jQuery(document).ready(function($) {
        $.get('/quarks/controller/admin/getAllEmployees.php', function(data) {
            var arr = $.parseJSON(data);
            for (var i = arr.length - 1; i >= 0; i--) {
                $('#employees').append("<div class='checkbox'><label><input id='"+arr[i][0]+"' type='checkbox' value=''>"+arr[i][1]+" "+arr[i][2]+"</label></div>");
            };
            
        });

        $('#save').click(function(event) {
            var usecaseid = $('#usecase').children(':selected').attr('id');
            var levelid = $('#accesslevel').children(':selected').attr('id');
            var sList = [];
            $('input[type=checkbox]').each(function () {
                var sThisVal = (this.checked ? this.id : "");
                if(sThisVal != ''){
                    sList.push(sThisVal);
                }
            });
            $.post('/quarks/controller/admin/AssignUsers.php', {
                iduserlevel: levelid,
                empids: sList
            }, function(data, textStatus, xhr) {
                $('#addusers_modal').modal('toggle');
            });
        });
    });
</script>
<div class="modal fade" id="addusers_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4>Add new access level</h4>
            </div>
            <div class="modal-body">
                <form id="trainingrequest" class="form-horizontal" role="form" onsubmit="return false;">
                    <div id="employees">
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="save" class="btn btn-default"> Ok</button>
            </div>
        </div>
    </div>
</div> 
