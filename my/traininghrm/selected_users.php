<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('#training').change(function(event) {
            var id = $(this).children(":selected").attr("id");
            $.get('/quarks/controller/trainingHrm/selectedemps.php?idtraining='+id, 
                function(data) {
                var arr = $.parseJSON(data);
                $('#employees').empty();
                for (var i = arr.length - 1; i >= 0; i--) {
                    $('#employees').append('<tr><td>'+arr[i][1]+'</td><td>'+arr[i][3]+' '+arr[i][2]+'</td></tr>');
                };
            });
        });
    });
</script>
<div class="col-sm-12 well">
    <h4>Selected employees for the training</h4>
    <hr/>
    <form class="form-horizontal" role="form" onsubmit="return false">
        <div class="form-group">
            <label class="control-label col-sm-3" for="sel1">Select training:</label>
            <div class="col-sm-6">
                <select class="form-control" id="training">
                    <option>Select the training program</option>
                    <?php
                    require_once '../../API/training/DBClasses/TrainingDBHandler.php';
                    $arr = TrainingDBHandler::getApprovedTraining();
                    foreach ($arr as $tr) {
                        ?>
                        <option id="<?php echo $tr[0]; ?>"><?php echo $tr[1] . " ,by authority: " . $tr[2]; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>
    </form>
    <hr/>
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="col-sm-2">NIC</th>
                    <th class="col-sm-10">Name</th>
                </tr>
            </thead>
            <tbody id="employees">
                
            </tbody>
        </table>
    </div>
</div>