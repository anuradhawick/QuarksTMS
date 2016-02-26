<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(document).on('submit', '#rangeselect', function(event) {
            event.preventDefault();
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var emp_number = $('#emp_number').val();
            if (Date.parse(from_date) > Date.parse(to_date) || from_date.length == 0 || to_date.length == 0) {
                return;
            };
            $.post('/quarks/controller/admin/ViewLogger.php', {
                from: from_date,
                to: to_date,
                emp_number:emp_number,
                iduse_case: ''
            }, function(data, textStatus, xhr) {
                $('#logtable').empty();
                var arr = $.parseJSON(data);
                for (var i = arr.length - 1; i >= 0; i--) {
                    $('#logtable').append('<tr><td>'+arr[i][0]+'</td><td>'+arr[i][1]+'</td><td>'+arr[i][2]+'</td></tr>');
                };
            });
                
        });
    });
</script>
<div class="container well">
    <div class="col-sm-12">
        <h4>Activity log</h4>
        <hr/>
        <form id="rangeselect" class="form-horizontal" role="form" onsubmit="return false;">

            <div class="form-group">
                <label class="control-label col-sm-4">From:</label>    
                <div class="col-sm-4">
                    <input type="text" id="from_date" class="form-control datepicker">
                </div>   
            </div> 

            <div class="form-group">
                <label class="control-label col-sm-4">To:</label>    
                <div class="col-sm-4">
                    <input type="text" id="to_date" class="form-control datepicker">
                </div>   
            </div> 

            <div class="form-group">
                <label class="control-label col-sm-4">Employee NIC:</label>    
                <div class="col-sm-4">
                    <input type="text" id="emp_number" class="form-control" placeholder='Leave blank to view all'>
                </div>   
            </div> 

            <div class="form-group">
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-4">
                    <button type="submit" class="btn btn-default">Load log</button>
                </div>
            </div>
        </form>
        <hr/>
        <div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-sm-2">Date/Time</th>
                        <th class="col-sm-2">Employee number</th>
                        <th class="col-sm-8">Activity</th>
                    </tr>
                </thead>
                <tbody id="logtable">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
    });
</script>