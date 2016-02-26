<script type="text/javascript">
    jQuery(document).ready(function ($) {

        $(document).on('click', '#save', function (event) {
            event.preventDefault();
            var id = $('#training').children(":selected").attr("id");
            if(id==''){return;}
            var sList = [];
            $('input[type=checkbox]').each(function () {
                var sThisVal = (this.checked ? this.id : "");
                if(sThisVal != ''){
                    sList.push(sThisVal);
                }
            });
            // alert(sList);
            
            $.post('/quarks/controller/trainingHrm/approveenrolment.php', {
                list: sList,
                trainingId: id
            }, function(data, textStatus, xhr) {
                if($.parseJSON(data)==true){                    
                    location.reload();
                }
            });
        });

        $('#training').change(function(event) {

            var id = $(this).children(":selected").attr("id");
            $.get('/quarks/controller/trainingHrm/pendingapprovals.php?idtraining='+id, function(data) {                
                var arr = $.parseJSON(data);                
                $('#employees').empty();
                for (var i = arr.length - 1; i >= 0; i--) {
                    // $('#employees').append("<div class='checkbox'><label><input id='"+arr[i][0]+"' type='checkbox' value=''>"+arr[i][1]+" "+arr[i][2]+" "+arr[i][3]+"</label></div>");
                    $('#employees').append("<tr><td><input id='"+arr[i][0]+"' type='checkbox' value=''></td><td>"+arr[i][1]+'</td><td>'+arr[i][2]+' '+arr[i][3]+"</td><td><a id='"+arr[i][0]+"' href='index.php?pg=view_history&emp_number="+arr[i][0]+"' target='_blank' class='btn btn-default history'>View history</a></td></tr>");
                };
            });
        });
    });
</script>
<div class="col-sm-12 well">
    <h4>Approve training enrolments</h4>
    <hr/>
    <form class="form-horizontal" role="form" onsubmit="return false">
        <div class="form-group">
            <label class="control-label col-sm-3" for="sel1">Select training program:</label>
            <div class="col-sm-6">
                <select class="form-control" id="training">
                    <option id="">Select the training program</option>
                    <?php
                    require_once '../../API/training/DBClasses/TrainingDBHandler.php';
                    require_once '../../API/training/LocalTraining.php';
                    require_once '../../API/training/ForeignTraining.php';
                    require_once '../../API/training/InhouseTraining.php';
                    require_once '../../API/training/Duration.php';
                    $tr = new LocalTraining();
                    $programs = TrainingDBHandler::getTrainingForApproveEnrolments();
                    foreach ($programs as $t) {
                        $tr = $t;
                        ?>
                        <option id="<?php echo $tr->getIdTraining(); ?>"><?php echo $tr->getName(); ?></option>
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
                <!-- date, name, type, authority -->
                    <th class="col-sm-2">Enrolment</th>
                    <th class="col-sm-2">NIC</th>
                    <th class="col-sm-6">Name</th>
                    <th class="col-sm-2">view history</th>            
                    <!-- <th class="col-sm-4">Authority</th> -->
                </tr>
            </thead>
            <tbody id="employees">
                    
            </tbody>
        </table>
    </div>
    <hr/>
    <a id="save" class="btn btn-default" href="javascript:void(0)">Approve</a>
</div>