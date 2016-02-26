<?php  
?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#add').submit(function(event) {
			var nic = $('#nic').val();
			if(nic.length == 0){
				return;
			}
			$.post('/quarks/controller/admin/adduser.php', {
				nic: nic
			}, function(data, textStatus, xhr) {
				$.post('adduser_modal.php', {
					success: data
				}, function(data1, textStatus, xhr) {
					$('#modal_handler').html(data1);
					$('#adduser_modal').modal('show');
				});
			});
		});
	});
</script>
<div class="container well">
    <div class="col-sm-12">
        <h4>Activity log</h4>
        <hr/>
        <form id="add" class="form-horizontal" role="form" onsubmit="return false;">

            <div class="form-group">
                <label class="control-label col-sm-4">NIC:</label>    
                <div class="col-sm-4">
                    <input type="text" id="nic" class="form-control">
                </div>   
            </div> 
            <!-- <div class="form-group">
                <label class="control-label col-sm-4">Work place:</label>    
                <div class="col-sm-4">
                    <select class="form-control" id="work_place">
                                
                    </select>
                </div>   
            </div>  -->
            <div class="form-group">
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-default">Add user</button>
                </div>
            </div>
        </form>
        <hr/>
        <p>The default password will be the employee id (NIC)</p>
        <hr/>
        <p>The added users must be there in the main ERP system and they can be added directly to the system. The users will be able to change their passwords. The added user will have the employee privileges by default.</p>
    </div>
</div>