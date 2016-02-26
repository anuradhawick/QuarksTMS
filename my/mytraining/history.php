<script type="text/javascript">
    jQuery(document).ready(function($) {
        $.get('/quarks/controller/mytraining/TrainingHistory.php', 
        function(data) {
            var arr = $.parseJSON(data);
            $('#history').empty();
            for (var i = arr.length - 1; i >= 0; i--) {
                $('#history').append('<tr><td>'+arr[i][0]+'</td><td>'+arr[i][1]+'</td><td>'+arr[i][2]+'</td><td>'+arr[i][3]+'</td></tr>');
            };
        });
    });
</script>
<div class="container">
    <div class="col-sm-12 well">
        <h4>Training history</h4>
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
                    
            </tbody>
        </table>
    </div>
</div>