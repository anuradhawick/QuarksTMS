
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.enrol').click(function (event) {
            var id = event.target.id;
            $.post('/quarks/controller/mytraining/enroltraining.php', {
                idtraining: id
            }, function (data, textStatus, xhr) {
                if ($.parseJSON(data) == true) {
                    location.reload();
                }
                ;
            });
        });
    });
</script>
<div class="container">
    <div class="col-sm-12 well">
        <h4>Upcoming Training</h4>
    </div>
    <div class="col-sm-12 well">
        <table class="table table-striped">
            <thead>
                <tr>
                    <!-- date, name, type, authority -->
                    <th class="col-sm-2">Name</th>
                    <th class="col-sm-2">Details</th>
                    <th class="col-sm-8"></th>
                </tr>
            </thead>
            <tbody id="history">
                <?php
                require_once '../../API/traininghrm/TrainingHRMDBHandler.php';
                if (session_id() == '') {
                    session_start();
                }
                $emp_number = $_SESSION['qis_emp'];
                $arr = TrainingHRMDBHandler::getUpComingTraining($emp_number);
                /*
                 * Parameter order of return array
                 * *** idtraining, training name, foreign/local/inhouse, conducting_authority, level of training, minor category, program type, trainer type, trainer name, triner qualification, from, to, clocing date, trainee requirements, other details,no of participants
                 */
                foreach ($arr as $tp) {
                    ?>
                    <tr>
                        <td><?php echo $tp[2]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Name</td>
                        <td><?php echo $tp[1]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Type</td>
                        <td><?php echo $tp[6]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Conducting authority</td>
                        <td><?php echo $tp[3]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Level</td>
                        <td><?php echo $tp[4]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Category</td>
                        <td><?php echo $tp[5]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Max. no. of participants</td>
                        <td><?php echo $tp[15]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Duration Details</td>
                        <td></td>
                    </tr>
                    <tr>
                    <tr>
                        <td></td>
                        <td>From</td>
                        <td><?php echo $tp[10]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>To</td>
                        <td><?php echo $tp[11]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Enrolment Closing date</td>
                        <td><?php echo $tp[12]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Trainer details</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Trainer type</td>
                        <td><?php echo $tp[7]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Trainer Name</td>
                        <td><?php echo $tp[8]; ?></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>Trainer Qualifications</td>
                        <td><?php echo $tp[9]; ?></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td></td>
                        <td><button class="btn btn-default enrol" id="<?php echo $tp[0]; ?>">Enrol now</button></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>