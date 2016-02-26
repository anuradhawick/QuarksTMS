<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#search').submit(function(event) {
            var nic = $('#nic').val();
            $.get('/quarks/controller/trainingHrm/gethistory.php?nic='+nic, function(data) {
                var arr = $.parseJSON(data);
                $('#history').empty();
                for (var i = arr.length - 1; i >= 0; i--) {
                    $('#history').append('<tr><td>' + arr[i][0] + '</td><td>' +arr[i][1]+ '</td><td>' + arr[i][2]+ '</td><td>'+arr[i][3] + '</td></tr>');
                };
            });
        });
    });
</script>
<div class="container">
    <div class="col-sm-12 well">
        <h4>Training history</h4>
        <form id="search" class="form-horizontal" role="form" onsubmit="return false;">

            <div class="form-group">
                <label class="control-label col-sm-4">NIC:</label>    
                <div class="col-sm-4">
                    <input type="text" id="nic" class="form-control" placeholder='Enter the NIC number'>
                </div>   
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-default">Load history</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12 well">
        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- date, name, type, authority -->
                    <th class="col-sm-2">Date</th>
                    <th class="col-sm-2">Name</th>
                    <th class="col-sm-4">Type</th>
                    <th class="col-sm-4">Authority</th>
                </tr>
            </thead>
            <tbody id="history">
                <?php
                if (isset($_GET['emp_number'])) {
                    require_once '../../API/traininghrm/TrainingHRMDBHandler.php';
                    ;
                    $array = TrainingHRMDBHandler::getTrainingHistoryAsStrings($_GET['emp_number']);
                    foreach ($array as $arr) {
                        echo '<tr><td>' . $arr[0] . '</td><td>' . $arr[1] . '</td><td>' . $arr[2] . '</td><td>' . $arr[3] . '</td></tr>';
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>