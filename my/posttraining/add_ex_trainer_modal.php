<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#add_ex_trainer_modal').submit(function(event) {
            var name = $('#name').val();
            var qual = $('#qual').val();
            $.post('/quarks/controller/training/add_ex_trainer.php', {
                name: name,
                qual: qual
            }, function(data, textStatus, xhr) {
                if($.parseJSON(data) == true){
                    // location.reload();
                    $.post('/quarks/controller/training/get_ext_trainers.php', {
                        param1: 'value1'
                    }, function(data, textStatus, xhr) {
                        $('#ex_trainer').empty();
                        var arr = $.parseJSON(data);
                        for (var i = arr.length - 1; i >= 0; i--) {
                            $('#ex_trainer').append("<option id='"+arr[i][0]+"'>"+arr[i][1]+"</option>")
                        };
                        $('#add_ex_trainer_modal').modal('toggle');
                    });
                }
            });
        });
    });
</script>

<div class="modal fade" id="add_ex_trainer_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4> Add external trainer</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" onsubmit="return false">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Name:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="name"/>
                        </div>    
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Qualifications:</label>    
                        <div class="col-sm-6">
                            <textarea class="form-control" type="text" id="qual"></textarea> 
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button id="add_ex_trainer_modal" type="submit" class="btn btn-default" >Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
