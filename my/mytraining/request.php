<div>
    <?php require 'req_modal.php'; ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $(document).on('submit', '#trainingrequest', function (event) {
            event.preventDefault();

            var subject = $('#subject').val();
            var type = $('#type').find('option:selected').attr('id');
            var description = $('#description').val();
            var importance = $('#importance').val();

            // $.get('/quarks/controller/mytraining/requesttraining.php?subject='+subject+'&type='+type+'&description='+description+'&importance='+importance, 
            //     function(data) {
            //         if ($.parseJSON(data) == true) {
            //             $('#req').modal('show');
            //     };
            // });
            $.get('http://www.quarksis.com/mailer.php?subject='+subject+'&msg='+description+"_IMPORTANCE_"+importance, 
                function(data) {
                    alert(data);
                if ($.parseJSON(data)) {
                    
                };
            });
            $('#req').modal('show');
            $('#subject').val('');
            $('#description').val('');
            $('#importance').val('');
            
        });

    });
</script>
<div class="container well ver-center">
    <div class="col-sm-12">
        <h4>Training request form</h4>
        <hr/>
        <form id="trainingrequest" class="form-horizontal" role="form" onsubmit="return false;">
            <div class="form-group">
                <label class="control-label col-sm-3" for="email">Training subject:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" id="subject" placeholder="eg: Statistics, IT" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3" for="type">Training type:</label>
                <div class="col-sm-6">
                    <select class="form-control" id="type">
                        <option id="2">In-house</option>
                        <option id="1">Local</option>
                        <option id="0">Foreign</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="description">Brief description:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="description" placeholder="describe the training program" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3" for="importance">Explain the importance:</label>
                <div class="col-sm-6">
                    <textarea class="form-control" id="importance" placeholder="describe the importance" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-3"></label>
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-default">Send</button>
                </div>
            </div>
        </form>
    </div>
</div>