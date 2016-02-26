<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#add_in_trainer_modal').submit(function(event) {
            arr = $('#nic').val().split('_');
            if(arr.length == 1){
                return;
            }
            var br = false;
            $("#in_trainer > option").each(function() {
                if (this.id == arr[0]) {
                    br = true;
                }
            });
            if(br){
                return;
            }
            // alert(arr[0]);
            $('#in_trainer').append("<option id='"+arr[0]+"'>"+arr[1]+"</option>");
            $('#add_in_trainer_modal').modal('toggle');
        });

        $('#nic').keyup(function(event) {
            var nic = $('#nic').val();
            if(nic.length >= 3){
                $.get('/quarks/controller/training/search_in_trainers.php?nic='+nic, function(data) {
                    var arr = $.parseJSON(data);
                    for (var i = arr.length - 1; i >= 0; i--) {
                        $('#employees').empty();
                        $('#employees').append("<option id=''>"+arr[i][0]+"_"+arr[i][1]+" "+arr[i][2]+" "+arr[i][3]+"</option>")
                    };
                });
            }
        });

        
       
    });
</script>
<div class="modal fade" id="add_in_trainer_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4> Add internal trainer</h4>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" onsubmit="return false">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Employee id:</label>    
                        <div class="col-sm-6">
                            <input list='employees' class="form-control" type="text" id="nic" placeholder='Enter nic of the trainer'/>
                            <datalist id="employees">
                                <option class="res">111</option>
                            </datalist>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button id="save" class="btn btn-default" >Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>  
