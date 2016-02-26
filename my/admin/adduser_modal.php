<div class="modal fade" id="adduser_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4> Adding new user</h4>
            </div>
            <div class="modal-body">
                <p>
                    <?php
                    if(json_decode($_POST['success']) == true){
                        echo "New user has been added successfully. Password is the employee id (NIC) itself.";
                    } else {
                        echo "New user addition failed. The user already added or user does not exist.";
                    }
                    ?>
                </p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal"> Ok</button>
            </div>
        </div>
    </div>
</div> 