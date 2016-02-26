<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#type').click(function(event) {
            var val = $('#new_type').val();
            if(val.length == 0){return;}
            $.get('/quarks/controller/admin/setup.php?cmd=type&data='+val, function(data) {
                if($.parseJSON(data)==true){
                    location.reload();
                }
            });
        });

        $('#level').click(function(event) {
            var val = $('#new_level').val();
            if(val.length == 0){return;}
            $.get('/quarks/controller/admin/setup.php?cmd=level&data='+val, function(data) {
                if($.parseJSON(data)==true){
                    location.reload();
                }
            });
        });

        $('#major').click(function(event) {
            var val = $('#new_maj_cat').val();
            if(val.length == 0){return;}
            $.get('/quarks/controller/admin/setup.php?cmd=major&data='+val, function(data) {
                if($.parseJSON(data)==true){
                    location.reload();
                };
            });
        });

        $('#minor').click(function(event) {
            var val = $('#new_min_cat').val();
            var id = $('#major_cat').children(":selected").attr("id");
            if(val.length == 0 || id.length ==0){return;}
            $.get('/quarks/controller/admin/setup.php?cmd=minor&data='+val+"&major_id="+id, function(data) {
                if($.parseJSON(data)==true){
                    location.reload();
                }
            });
        });

        $('#major_cat').change(function(event) {
            var id = $(this).children(":selected").attr("id");
            $.get('/quarks/controller/training/viewmincat.php?idmajor='+id, function(data) {
                $('#minor_cat').empty();
                var arr = $.parseJSON(data);
                for (var i = arr.length - 1; i >= 0; i--) {
                    $('#minor_cat').append("<option id="+arr[i][0]+">"+arr[i][1]+"</option>");
                };
            });
        });
    });
</script>
<div class="container well">
    <div class="col-sm-12">
        <h4>Setup training categories</h4>
        <hr/>
        <form id="rangeselect" class="form-horizontal" role="form" onsubmit="return false;">

            <div class="form-group">
                <label class="control-label col-sm-4">Select the program type:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="prog_type">
                        <?php
                        require '../../API/training/DBClasses/TrainingDataDBHandler.php';
                        $arr = TrainingDataDBHandler::getAllProgramTypes();
                        foreach ($arr as $item) {
                            ?>
                            <option id="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>  
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>    
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="new_type">
                </div>    
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                    <button id="type" class="btn btn-default">Add new type</button>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label class="control-label col-sm-4">Select the level of training:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="level_of_training">
                        <?php
                        $arr = TrainingDataDBHandler::getAllLevelsOfTraining();
                        foreach ($arr as $item) {
                            ?>
                            <option id="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>    
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>    
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="new_level">
                </div>    
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                    <button id="level" class="btn btn-default">Add new level</button>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label class="control-label col-sm-4">Major category of training:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="major_cat">
                        <option id="">Select Major category</option>
                        <?php
                        $arr = TrainingDataDBHandler::getMajorCategories();
                        foreach ($arr as $item) {
                            ?>
                            <option id="<?php echo $item[0]; ?>"><?php echo $item[1]; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>    
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="new_maj_cat">
                </div>    
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                    <button id="major" class="btn btn-default">Add major category</button>
                </div>
            </div>
            <hr/>
            <div class="form-group">
                <label class="control-label col-sm-4">Minor category of training:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="minor_cat">
                        
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4"></label>    
                <div class="col-sm-6">
                    <input class="form-control" type="text" id="new_min_cat">
                </div>    
            </div>
            <div class="form-group">
                <div class="col-sm-4 col-sm-offset-4">
                    <button id="minor" class="btn btn-default">Add minor category</button>
                </div>
            </div>
        </form>
    </div>
</div>