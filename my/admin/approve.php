<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('.approve').click(function(event) {
            var id = event.target.id;
            $.post('/quarks/controller/admin/approve.php', {
                type: 'approve',
                id: id
            }, function(data, textStatus, xhr) {
                if ($.parseJSON(data)) {
                    var dt = new Date();
                    $.post('/quarks/controller/tweet/send.php', {
                        msg: 'A new training program has been added,'+'on '+dt.getFullYear()+' '+(dt.getMonth()+1)+' '+dt.getDate()+' '+ dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds()+' enrol now!'
                    }, function(data, textStatus, xhr) {
                        location.reload();
                    });
                    
                };
            });

                
        });

        $('.reject').click(function(event) {
            var id = event.target.id;
            $.post('/quarks/controller/admin/approve.php', {
                type: 'reject',
                id: id
            }, function(data, textStatus, xhr) {
                if ($.parseJSON(data)) {
                    location.reload();
                };
            })
        });
    });
</script>
<div class="col-sm-12 well">
    <h4>Approve training programs</h4>
    <div class="col-sm-11 col-sm-offset-1" id="training_programs">
        <div>
            <?php
            require_once '../../API/training/DBClasses/TrainingDBHandler.php';
            require_once '../../API/training/TrainingProgram.php';
            require_once '../../API/training/LocalTraining.php';
            require_once '../../API/training/InhouseTraining.php';
            require_once '../../API/training/ForeignTraining.php';
            require_once '../../API/training/Duration.php';
            $local = new LocalTraining();
            $foreign = new ForeignTraining();
            $inhouse = new InhouseTraining();
            $arr = TrainingDBHandler::pendingTraining();
//            print_r($arr[0]);
            foreach ($arr as $pending_training) {

                if ($pending_training instanceof LocalTraining) {
                    $local = $pending_training;
                    ?>
                    <h4><?php echo 'Local: ' . $local->getName(); ?></h4>
                    <blockquote>
                        <p>
                            Conducting authority: <?php echo $local->getConductingAuthority()?>
                        </p>
                        <p>
                            Location: <?php echo $local->getPlace()?>
                        </p>
                        <p>
                            Requirements: <?php echo $local->getRequirements()?>
                        </p>
                        <p>
                            From: <?php echo $local->getDuration()->getFrom()?>
                        </p>
                        <p>
                            To: <?php echo $local->getDuration()->getTo()?>
                        </p>
                        <p>
                            No. of participants: <?php echo $local->getDuration()->getNoOfParticipants()?>
                        </p>
                    </blockquote>
                    <a class="btn btn-default approve" id="<?php echo $local->getIdTraining() ; ?>" href="javascript:void(0)">Approve</a> <a class="btn btn-default reject" id="<?php echo $local->getIdTraining() ; ?>" href="javascript:void(0)">Reject</a>
                    <?php
                } elseif ($pending_training instanceof ForeignTraining) {
                    $foreign = $pending_training;
                    ?>
                    <h4><?php echo 'Foreign: ' . $foreign->getName(); ?></h4>
                    <blockquote>
                        <p>
                            Conducting authority: <?php echo $foreign->getConductingAuthority()?>
                        </p>
                        <p>
                            Country: <?php echo $foreign->getCountry()?>
                        </p>
                        <p>
                            Requirements: <?php echo $foreign->getRequirements()?>
                        </p>
                        <p>
                            From: <?php echo $foreign->getDuration()->getFrom()?>
                        </p>
                        <p>
                            To: <?php echo $foreign->getDuration()->getTo()?>
                        </p>
                        <p>
                            No. of participants: <?php echo $foreign->getDuration()->getNoOfParticipants()?>
                        </p>
                    </blockquote>
                    <a class="btn btn-default approve" id="<?php echo $foreign->getIdTraining() ; ?>" href="javascript:void(0)">Approve</a> <a class="btn btn-default reject" id="<?php echo $foreign->getIdTraining() ; ?>" href="javascript:void(0)">Reject</a>
                    <?php
                } else {
                    $inhouse = $pending_training;
                    ?>
                    <h4><?php echo 'In-house: ' . $inhouse->getName(); ?></h4>
                    <blockquote>
                        <p>
                            Conducting authority: <?php echo $inhouse->getConductingAuthority()?>
                        </p>
                        <p>
                            Location: <?php echo $inhouse->getLocation()?>
                        </p>
                        <p>
                            Requirements: <?php echo $inhouse->getRequirements()?>
                        </p>
                        <p>
                            From: <?php echo $inhouse->getDuration()->getFrom()?>
                        </p>
                        <p>
                            To: <?php echo $inhouse->getDuration()->getTo()?>
                        </p>
                        <p>
                            No. of participants: <?php echo $inhouse->getDuration()->getNoOfParticipants()?>
                        </p>
                    </blockquote>
                    <a class="btn btn-default approve" id="<?php echo $inhouse->getIdTraining() ; ?>" href="javascript:void(0)">Approve</a> <a class="btn btn-default reject" id="<?php echo $inhouse->getIdTraining() ; ?>" href="javascript:void(0)">Reject</a>
                    <?php
                }
                echo "<hr/>";
            }
            ?>
        </div>
    </div>
</div>