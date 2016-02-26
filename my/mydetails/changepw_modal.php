<div class="modal fade" id="changepw_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4> Changing password</h4>
            </div>
            <div class="modal-body">
                <?php
                if (!isset($_GET['ty'])) {
                    /*
                    display modal saying password length should be 8
                    */
                    ?>
                    <p>Password updated successfully.</p>
                    <?php
                } elseif ($_GET['ty'] == 1) {
                    /*
                    incorrect old password
                    */
                    ?>
                    <p>Old password entered was incorrect.</p>
                    <?php
                } else {
                    /*
                    success
                    */
                    ?>
                    <p>Password length should be atleast 4.</p>
                    <?php
                }
                    
                ?>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-default" data-dismiss="modal"> Ok</button>
            </div>
        </div>
    </div>
</div> 
