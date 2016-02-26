<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once 'DBClasses/DatabaseCredentials.php';
        require_once 'DBClasses/TrainingDBHandler.php';
        require_once 'ForeignTraining.php';
        require_once 'TrainingProgram.php';
        require_once 'LevelOfTraining.php';
        require_once 'MinorCategory.php';
        require_once 'ProgramType.php';
        require_once 'Duration.php';
        require_once 'LocalTraining.php';
        require_once 'InhouseTraining.php';
        require_once 'MajorCategory.php';
        require_once 'MinorCategory.php';
        require_once 'ProgramType.php';
        require_once 'LevelOfTraining.php';
        require_once 'PdfUpload.php';
        require_once 'ProgramLinks.php';
        require_once 'TrainingRequest.php';
        require_once 'Employee.php';
        // require_once '../DBClasses/DatabaseCredentials.php';
      
     //     $leveloftraining=  new LevelOfTraining();
     //     $leveloftraining->setIdlevelOfTraining(1);

         // $minorCategory=new MinorCategory();
       //   $minorCategory->setIdminorTraining(1);

         // $programType=new ProgramType();
         // $programType->setIdprogramType(1);

         // $training=  ForeignTraining::withRow("ForeignTraining", "conductingAuthority" ,0, 0, "requirements",0, "otherDetails" , $leveloftraining, $minorCategory, $programType, "country", "locationAddress");
          //$training=  LocalTraining::withRow("localTest1", "conductingAuthorityTest", 1,1, "requirements should be", 1, "otherDetails", $leveloftraining, $minorCategory, $programType, "place", "locationAddress");
       //    $training=  InhouseTraining::withRow("Inhouseeee", "conductingAuthority", 2, 0, "requirements",4, "otherDetail", $leveloftraining, $minorCategory, $programType, "Ambewela");
         // $duration=  Duration::withRow($training,"2050-03-04","2020-10-05", 5, 6, "2015-09-08", 10, 2);

        //TrainingDBHandler::postNewTraining($training, $duration,1);
      //    $df->postNewTraining($training, $duration);
         
      //        $training=  new InhouseTraining();
       //   $training->setIdTraining(5);
        //  $duration=  Duration::withRow($training,"2020-03-04","2026-10-05", 5, 6, "2017-09-08", 10, 2);
        //  TrainingDBHandler::addDuration($duration);
        //  $major=  MajorCategory::withType("Sundar");
         // TrainingDBHandler::addMajorcategory($major);
      //  $major1 = new MajorCategory();
      //  $major1->setIdmajorTraining(1);

      //  $minor1 = MinorCategory::withType("TypeTest2",$major1);
      //  TrainingDBHandler::addMinorCategory($minor1);
      //  $minor2 = MinorCategory::withType("Type 2",$major1);
       //$minor3 = MinorCategory::withType("Type 3",$major1);*/
      //  $program=  ProgramType::withType("TypeTest1");
      //  TrainingDBHandler::addProgramType($program);
      //  $level=  LevelOfTraining::withLevel("Level1223");
      //  TrainingDBHandler::addLevelOfTraining($level);
       //$df->addLevelOfTraining($level);
      //  $training=new ForeignTraining();
      //  $training->setIdTraining(1);
        
      //  $employee=  Employee::withId(1);
      //  $pdf=  PdfUpload::withRow($training, "PDF123", "Link");
      //  TrainingDBHandler::addPdfUpload($pdf);
     TrainingDBHandler::confirmTrainingAttendance();
        
        ?>
    </body>
</html>
