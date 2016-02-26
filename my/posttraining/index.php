<!DOCTYPE html>
<html>
    <head>
        <title>Quarks TMS</title>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../../css/default.css">
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    </head>
    <body>
        <?php require '../navbar.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
<?php
if (isset($_GET['ty']) && $_GET['ty'] == 1) {
    echo 'var ty=1;';
} elseif (isset($_GET['ty']) && $_GET['ty'] == 2) {
    echo 'var ty=2;';
} else {
    echo 'var ty=3;';
}
?>
                $.post('/quarks/controller/training/get_ext_trainers.php', {
                    param1: 'value1'
                }, function (data, textStatus, xhr) {
                    var arr = $.parseJSON(data);
                    for (var i = arr.length - 1; i >= 0; i--) {
                        $('#ex_trainer').append("<option id='" + arr[i][0] + "'>" + arr[i][1] + "</option>")
                    }
                    ;
                });

                $.post('/quarks/controller/training/get_in_trainers.php', {
                    param1: 'value1'
                }, function (data, textStatus, xhr) {
                    var arr = $.parseJSON(data);
                    for (var i = arr.length - 1; i >= 0; i--) {
                        $('#in_trainer').append("<option id='" + arr[i][0] + "'>" + arr[i][1] + " " + arr[i][2] + "</option>")
                    }
                    ;
                });
                $('#ext_sel').hide();
                $('#in_sel').show();

                $('#trainer_type').change(function (event) {
                    var id = $(this).children(":selected").attr("id");
                    //alert(id);
                    if (id == 2) {
                        $('#ext_sel').hide();
                        $('#in_sel').show();
                    } else if(id == 1) {
                        $('#ext_sel').show();
                        $('#in_sel').hide();
                    } else {
                        $('#ext_sel').hide();
                        $('#in_sel').hide()
                    };
                });
                $('#add_ex_trainer').click(function (event) {
                    $.post('add_ex_trainer_modal.php', {
                        param1: 'value1'
                    }, function (data, textStatus, xhr) {
                        // alert(data);
                        $('#modal_handler').html(data);
                        $('#add_ex_trainer_modal').modal('show');
                    });
                    return;
                });

                $('#add_in_trainer').click(function (event) {
                    $.post('add_in_trainer_modal.php', {
                        param1: 'value1'
                    }, function (data, textStatus, xhr) {
                        // alert(data);
                        $('#modal_handler').html(data);
                        $('#add_in_trainer_modal').modal('show');
                    });
                    return;
                });

                //posting the training for saving
                $('#training').submit(function (event) {
                    var type = $('#prog_type').children(':selected').attr('id');
                    var level = $('#level_of_training').children(':selected').attr('id');
                    var major = $('#major_cat').children(':selected').attr('id');
                    var minor = $('#minor_cat').children(':selected').attr('id');
                    
                    if(isNaN(minor)){
                        alert('Please select a minor category');
                        return;
                    }
                    var name = $('#training_name').val();
                    var authority = $('#training_auth').val();
                    var requirements = $('#req_of_training').val();

                    var from_date = $('#from').val();
                    var string_fromdate=new Date(from_date);
                    if(!Date.parse(from_date)){
                            alert("Invalid Date at From field");
                            return;
                    }
                    var current_date=new Date();
                    if(string_fromdate<current_date){
                        alert('Incorrect date in the From field');
                        return;
                    }

                    var to_date = $('#to').val();
                    var string_todate=new Date(to_date);
                    if(!Date.parse(to_date)){
                        alert('Invalid date at To field');
                        return;
                    }
                    var current_date=new Date();
                    if(string_todate<current_date){
                        alert('Incorrect date in the \"To\" field');
                        return;
                    }

                    var closing_date = $('#closing_date').val();
                    var string_closedate=new Date(closing_date);
                    if(!Date.parse(closing_date)){
                        alert('Invalid date at Closing date field');
                        return;
                    }
                    var current_date=new Date();
                    if(string_closedate<current_date){
                        alert('Incorrect date in the \"Closing date\" field');
                        return;
                    }

                    if(string_todate<string_fromdate){
                        alert('Incorrect dates in the From field and \"To"\ field');
                        return;
                    }

                    if(string_closedate>string_fromdate){
                        alert('Incorrect date in the \"Closing date\" field');
                        return;
                    }

                    var days = $('#no_days').val();
                    var hrs = $('#no_hrs').val();
                    var sessions = $('#no_sessions').val();
                    var participants = $('#participants').val();
                    var diff_days=(string_todate-string_fromdate)/(1000*60*60*24);                  
                    if(diff_days==0 & days==1){
                        
                    }else if(days>=1+diff_days){
                        alert('Duration details and \"No. of days\"" mismatch');
                        return;
                    }
                    
                    var diff_hours=(string_todate-string_fromdate)/(1000*60*60);
                     if(diff_hours==0 & hrs<=24){
                        
                    }else if(hrs>diff_hours){
                        alert('Duration details and No. of hours mismatch');
                        return;
                    }
                    if (ty == 1) {
                        var location = $('#local_location').val();
                        var loc_details = $('#local_details').val();
                    } else if (ty == 2) {
                        var location = $('#inhouse_location').val();
                        var loc_details = null;
                    } else {
                        var location = $('#country').children(':selected').text();
                        var loc_details = $('#foreign_location').val();
                    }
                    ;
                    var trainer_type = $('#trainer_type').children(':selected').attr('id');
                    if (trainer_type == 1) {
                        //external
                        var trainer_id = $('#ex_trainer').children(':selected').attr('id');
                    } else {
                        var trainer_id = $('#in_trainer').children(':selected').attr('id');
                    }
                    $.post('/quarks/controller/training/addtraining.php', {
                        training_type: ty,
                        type: type,
                        level: level,
                        major: major,
                        minor: minor,
                        name: name,
                        participants: participants,
                        authority: authority,
                        requirements: requirements,
                        location: location,
                        loc_details: loc_details,
                        from_date: from_date,
                        to_date: to_date,
                        closing_date: closing_date,
                        days: days,
                        hrs: hrs,
                        sessions: sessions,
                        trainer_type: trainer_type,
                        trainer_id: trainer_id
                    }, function (data, textStatus, xhr) {
                        if ($.parseJSON(data) == true) {
                            $('#training_name').val("");
                            $('#training_auth').val("");
                            $('#req_of_training').val("");
                            $('#from').val("");
                            $('#to').val("");
                            $('#closing_date').val("");
                            $('#no_days').val("");
                            $('#no_hrs').val("");
                            $('#no_sessions').val("");
                            $('#participants').val("");
                            $('#local_location').val("");
                            $('#local_details').val("");
                            $('#inhouse_location').val("");
                            $('#foreign_location').val("");
                            $.get('success_modal.php', function (data) {
                                $('#modal_handler').html(data);
                                $('#success_modal').modal('show');
                            });

                        }
                    });
                    // $.get('success_modal.php', function(data) {
                    //     $('#modal_handler').html(data);
                    //     $('#success_modal').modal('show');
                    // });
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
        <div class="container">
            <div class="col-sm-12 well">
                <form id="training" class="form-horizontal" role="form" onsubmit="return false;">
                    <strong>Basic details</strong>

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
                        <label class="control-label col-sm-4">Major category of training:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="major_cat">
                                <option>Select Major category</option>
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
                        <label class="control-label col-sm-4">Minor category of training:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="minor_cat">
                                
                            </select>
                        </div>
                    </div>

                    <hr/>
                    <strong>Details</strong>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Name of the training program:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="training_name" required/>
                        </div>    
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Authority of the training program:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="text" id="training_auth" required/>
                        </div>    
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">Requirements of the training program:</label>    
                        <div class="col-sm-6">
                            <textarea class="form-control" type="text" id="req_of_training" required></textarea>
                        </div>    
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">No of participants:</label>    
                        <div class="col-sm-6">
                            <input type="number" id="participants" class="form-control" min="1" required>
                        </div>   
                    </div>
                    <hr/>
                    <strong>Duration details</strong>
                    <div class="form-group">
                        <label class="control-label col-sm-4">From:</label>    
                        <div class="col-sm-6">
                            <input type="date" id="from" class="form-control datepicker" required>
                        </div>   
                    </div>   

                    <div class="form-group">
                        <label class="control-label col-sm-4">To:</label>    
                        <div class="col-sm-6">
                            <input type="date" id="to" class="form-control datepicker" required>
                        </div>   
                    </div> 

                    <div class="form-group">
                        <label class="control-label col-sm-4">Closing date:</label>    
                        <div class="col-sm-6">
                            <input type="date" id="closing_date" class="form-control datepicker" required>
                        </div>   
                    </div> 

                    <div class="form-group">
                        <label class="control-label col-sm-4">No of days of the training program:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="number" id="no_days" min="1"/>
                        </div>    
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">No of hours of the training program:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="number" id="no_hrs" min="0" step="0.1"/>
                        </div>    
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-4">No of sessions of the training program:</label>    
                        <div class="col-sm-6">
                            <input class="form-control" type="number" id="no_sessions" min="1"/>
                        </div>    
                    </div>

                    <hr/>

                    <strong>Additional details</strong>
                    <?php
                    if (isset($_GET['ty']) && $_GET['ty'] == 1) {
                        /*
                          The training program is a local program
                         */
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Location/ Address:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="local_location" required></textarea>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Details:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="local_details"></textarea>
                            </div>    
                        </div>
                        <?php
                    } elseif (isset($_GET['ty']) && $_GET['ty'] == 2) {
                        /*
                          The training program is inhouse
                         */
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Location/ Address:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="inhouse_location" required></textarea>
                            </div>    
                        </div>

                        <!-- <div class="form-group">
                            <label class="control-label col-sm-4">Details:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="inhouse_details"></textarea>
                            </div>    
                        </div> -->
                        <?php
                    } else {
                        /*
                          The training program is foreign
                         */
                        ?>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Country:</label>    
                            <div class="col-sm-6">
                                <select class="form-control" id="country">
                                    <option value="AFG">Afghanistan</option>
                                    <option value="ALA">Ã…land Islands</option>
                                    <option value="ALB">Albania</option>
                                    <option value="DZA">Algeria</option>
                                    <option value="ASM">American Samoa</option>
                                    <option value="AND">Andorra</option>
                                    <option value="AGO">Angola</option>
                                    <option value="AIA">Anguilla</option>
                                    <option value="ATA">Antarctica</option>
                                    <option value="ATG">Antigua and Barbuda</option>
                                    <option value="ARG">Argentina</option>
                                    <option value="ARM">Armenia</option>
                                    <option value="ABW">Aruba</option>
                                    <option value="AUS">Australia</option>
                                    <option value="AUT">Austria</option>
                                    <option value="AZE">Azerbaijan</option>
                                    <option value="BHS">Bahamas</option>
                                    <option value="BHR">Bahrain</option>
                                    <option value="BGD">Bangladesh</option>
                                    <option value="BRB">Barbados</option>
                                    <option value="BLR">Belarus</option>
                                    <option value="BEL">Belgium</option>
                                    <option value="BLZ">Belize</option>
                                    <option value="BEN">Benin</option>
                                    <option value="BMU">Bermuda</option>
                                    <option value="BTN">Bhutan</option>
                                    <option value="BOL">Bolivia, Plurinational State of</option>
                                    <option value="BES">Bonaire, Sint Eustatius and Saba</option>
                                    <option value="BIH">Bosnia and Herzegovina</option>
                                    <option value="BWA">Botswana</option>
                                    <option value="BVT">Bouvet Island</option>
                                    <option value="BRA">Brazil</option>
                                    <option value="IOT">British Indian Ocean Territory</option>
                                    <option value="BRN">Brunei Darussalam</option>
                                    <option value="BGR">Bulgaria</option>
                                    <option value="BFA">Burkina Faso</option>
                                    <option value="BDI">Burundi</option>
                                    <option value="KHM">Cambodia</option>
                                    <option value="CMR">Cameroon</option>
                                    <option value="CAN">Canada</option>
                                    <option value="CPV">Cape Verde</option>
                                    <option value="CYM">Cayman Islands</option>
                                    <option value="CAF">Central African Republic</option>
                                    <option value="TCD">Chad</option>
                                    <option value="CHL">Chile</option>
                                    <option value="CHN">China</option>
                                    <option value="CXR">Christmas Island</option>
                                    <option value="CCK">Cocos (Keeling) Islands</option>
                                    <option value="COL">Colombia</option>
                                    <option value="COM">Comoros</option>
                                    <option value="COG">Congo</option>
                                    <option value="COD">Congo, the Democratic Republic of the</option>
                                    <option value="COK">Cook Islands</option>
                                    <option value="CRI">Costa Rica</option>
                                    <option value="CIV">CÃ´te d'Ivoire</option>
                                    <option value="HRV">Croatia</option>
                                    <option value="CUB">Cuba</option>
                                    <option value="CUW">CuraÃ§ao</option>
                                    <option value="CYP">Cyprus</option>
                                    <option value="CZE">Czech Republic</option>
                                    <option value="DNK">Denmark</option>
                                    <option value="DJI">Djibouti</option>
                                    <option value="DMA">Dominica</option>
                                    <option value="DOM">Dominican Republic</option>
                                    <option value="ECU">Ecuador</option>
                                    <option value="EGY">Egypt</option>
                                    <option value="SLV">El Salvador</option>
                                    <option value="GNQ">Equatorial Guinea</option>
                                    <option value="ERI">Eritrea</option>
                                    <option value="EST">Estonia</option>
                                    <option value="ETH">Ethiopia</option>
                                    <option value="FLK">Falkland Islands (Malvinas)</option>
                                    <option value="FRO">Faroe Islands</option>
                                    <option value="FJI">Fiji</option>
                                    <option value="FIN">Finland</option>
                                    <option value="FRA">France</option>
                                    <option value="GUF">French Guiana</option>
                                    <option value="PYF">French Polynesia</option>
                                    <option value="ATF">French Southern Territories</option>
                                    <option value="GAB">Gabon</option>
                                    <option value="GMB">Gambia</option>
                                    <option value="GEO">Georgia</option>
                                    <option value="DEU">Germany</option>
                                    <option value="GHA">Ghana</option>
                                    <option value="GIB">Gibraltar</option>
                                    <option value="GRC">Greece</option>
                                    <option value="GRL">Greenland</option>
                                    <option value="GRD">Grenada</option>
                                    <option value="GLP">Guadeloupe</option>
                                    <option value="GUM">Guam</option>
                                    <option value="GTM">Guatemala</option>
                                    <option value="GGY">Guernsey</option>
                                    <option value="GIN">Guinea</option>
                                    <option value="GNB">Guinea-Bissau</option>
                                    <option value="GUY">Guyana</option>
                                    <option value="HTI">Haiti</option>
                                    <option value="HMD">Heard Island and McDonald Islands</option>
                                    <option value="VAT">Holy See (Vatican City State)</option>
                                    <option value="HND">Honduras</option>
                                    <option value="HKG">Hong Kong</option>
                                    <option value="HUN">Hungary</option>
                                    <option value="ISL">Iceland</option>
                                    <option value="IND">India</option>
                                    <option value="IDN">Indonesia</option>
                                    <option value="IRN">Iran, Islamic Republic of</option>
                                    <option value="IRQ">Iraq</option>
                                    <option value="IRL">Ireland</option>
                                    <option value="IMN">Isle of Man</option>
                                    <option value="ISR">Israel</option>
                                    <option value="ITA">Italy</option>
                                    <option value="JAM">Jamaica</option>
                                    <option value="JPN">Japan</option>
                                    <option value="JEY">Jersey</option>
                                    <option value="JOR">Jordan</option>
                                    <option value="KAZ">Kazakhstan</option>
                                    <option value="KEN">Kenya</option>
                                    <option value="KIR">Kiribati</option>
                                    <option value="PRK">Korea, Democratic People's Republic of</option>
                                    <option value="KOR">Korea, Republic of</option>
                                    <option value="KWT">Kuwait</option>
                                    <option value="KGZ">Kyrgyzstan</option>
                                    <option value="LAO">Lao People's Democratic Republic</option>
                                    <option value="LVA">Latvia</option>
                                    <option value="LBN">Lebanon</option>
                                    <option value="LSO">Lesotho</option>
                                    <option value="LBR">Liberia</option>
                                    <option value="LBY">Libya</option>
                                    <option value="LIE">Liechtenstein</option>
                                    <option value="LTU">Lithuania</option>
                                    <option value="LUX">Luxembourg</option>
                                    <option value="MAC">Macao</option>
                                    <option value="MKD">Macedonia, the former Yugoslav Republic of</option>
                                    <option value="MDG">Madagascar</option>
                                    <option value="MWI">Malawi</option>
                                    <option value="MYS">Malaysia</option>
                                    <option value="MDV">Maldives</option>
                                    <option value="MLI">Mali</option>
                                    <option value="MLT">Malta</option>
                                    <option value="MHL">Marshall Islands</option>
                                    <option value="MTQ">Martinique</option>
                                    <option value="MRT">Mauritania</option>
                                    <option value="MUS">Mauritius</option>
                                    <option value="MYT">Mayotte</option>
                                    <option value="MEX">Mexico</option>
                                    <option value="FSM">Micronesia, Federated States of</option>
                                    <option value="MDA">Moldova, Republic of</option>
                                    <option value="MCO">Monaco</option>
                                    <option value="MNG">Mongolia</option>
                                    <option value="MNE">Montenegro</option>
                                    <option value="MSR">Montserrat</option>
                                    <option value="MAR">Morocco</option>
                                    <option value="MOZ">Mozambique</option>
                                    <option value="MMR">Myanmar</option>
                                    <option value="NAM">Namibia</option>
                                    <option value="NRU">Nauru</option>
                                    <option value="NPL">Nepal</option>
                                    <option value="NLD">Netherlands</option>
                                    <option value="NCL">New Caledonia</option>
                                    <option value="NZL">New Zealand</option>
                                    <option value="NIC">Nicaragua</option>
                                    <option value="NER">Niger</option>
                                    <option value="NGA">Nigeria</option>
                                    <option value="NIU">Niue</option>
                                    <option value="NFK">Norfolk Island</option>
                                    <option value="MNP">Northern Mariana Islands</option>
                                    <option value="NOR">Norway</option>
                                    <option value="OMN">Oman</option>
                                    <option value="PAK">Pakistan</option>
                                    <option value="PLW">Palau</option>
                                    <option value="PSE">Palestinian Territory, Occupied</option>
                                    <option value="PAN">Panama</option>
                                    <option value="PNG">Papua New Guinea</option>
                                    <option value="PRY">Paraguay</option>
                                    <option value="PER">Peru</option>
                                    <option value="PHL">Philippines</option>
                                    <option value="PCN">Pitcairn</option>
                                    <option value="POL">Poland</option>
                                    <option value="PRT">Portugal</option>
                                    <option value="PRI">Puerto Rico</option>
                                    <option value="QAT">Qatar</option>
                                    <option value="REU">RÃ©union</option>
                                    <option value="ROU">Romania</option>
                                    <option value="RUS">Russian Federation</option>
                                    <option value="RWA">Rwanda</option>
                                    <option value="BLM">Saint BarthÃ©lemy</option>
                                    <option value="SHN">Saint Helena, Ascension and Tristan da Cunha</option>
                                    <option value="KNA">Saint Kitts and Nevis</option>
                                    <option value="LCA">Saint Lucia</option>
                                    <option value="MAF">Saint Martin (French part)</option>
                                    <option value="SPM">Saint Pierre and Miquelon</option>
                                    <option value="VCT">Saint Vincent and the Grenadines</option>
                                    <option value="WSM">Samoa</option>
                                    <option value="SMR">San Marino</option>
                                    <option value="STP">Sao Tome and Principe</option>
                                    <option value="SAU">Saudi Arabia</option>
                                    <option value="SEN">Senegal</option>
                                    <option value="SRB">Serbia</option>
                                    <option value="SYC">Seychelles</option>
                                    <option value="SLE">Sierra Leone</option>
                                    <option value="SGP">Singapore</option>
                                    <option value="SXM">Sint Maarten (Dutch part)</option>
                                    <option value="SVK">Slovakia</option>
                                    <option value="SVN">Slovenia</option>
                                    <option value="SLB">Solomon Islands</option>
                                    <option value="SOM">Somalia</option>
                                    <option value="ZAF">South Africa</option>
                                    <option value="SGS">South Georgia and the South Sandwich Islands</option>
                                    <option value="SSD">South Sudan</option>
                                    <option value="ESP">Spain</option>
                                    <!-- <option value="LKA">Sri Lanka</option> -->
                                    <option value="SDN">Sudan</option>
                                    <option value="SUR">Suriname</option>
                                    <option value="SJM">Svalbard and Jan Mayen</option>
                                    <option value="SWZ">Swaziland</option>
                                    <option value="SWE">Sweden</option>
                                    <option value="CHE">Switzerland</option>
                                    <option value="SYR">Syrian Arab Republic</option>
                                    <option value="TWN">Taiwan, Province of China</option>
                                    <option value="TJK">Tajikistan</option>
                                    <option value="TZA">Tanzania, United Republic of</option>
                                    <option value="THA">Thailand</option>
                                    <option value="TLS">Timor-Leste</option>
                                    <option value="TGO">Togo</option>
                                    <option value="TKL">Tokelau</option>
                                    <option value="TON">Tonga</option>
                                    <option value="TTO">Trinidad and Tobago</option>
                                    <option value="TUN">Tunisia</option>
                                    <option value="TUR">Turkey</option>
                                    <option value="TKM">Turkmenistan</option>
                                    <option value="TCA">Turks and Caicos Islands</option>
                                    <option value="TUV">Tuvalu</option>
                                    <option value="UGA">Uganda</option>
                                    <option value="UKR">Ukraine</option>
                                    <option value="ARE">United Arab Emirates</option>
                                    <option value="GBR">United Kingdom</option>
                                    <option value="USA">United States</option>
                                    <option value="UMI">United States Minor Outlying Islands</option>
                                    <option value="URY">Uruguay</option>
                                    <option value="UZB">Uzbekistan</option>
                                    <option value="VUT">Vanuatu</option>
                                    <option value="VEN">Venezuela, Bolivarian Republic of</option>
                                    <option value="VNM">Viet Nam</option>
                                    <option value="VGB">Virgin Islands, British</option>
                                    <option value="VIR">Virgin Islands, U.S.</option>
                                    <option value="WLF">Wallis and Futuna</option>
                                    <option value="ESH">Western Sahara</option>
                                    <option value="YEM">Yemen</option>
                                    <option value="ZMB">Zambia</option>
                                    <option value="ZWE">Zimbabwe</option>
                                </select>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Location/ Address:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="foreign_location"></textarea>
                            </div>    
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-4">Details:</label>    
                            <div class="col-sm-6">
                                <textarea class="form-control" type="text" id="foreign_details"></textarea>
                            </div>    
                        </div>



                        <?php
                    }
                    ?>
                    <hr/>
                    <strong>Trainer details</strong>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Trainer type:</label>    
                        <div class="col-sm-6">
                            <select class="form-control" type="text" id="trainer_type">
                                <option id="2" selected>Internal trainer</option>
                                <option id="1">External trainer</option>
                                <option id="0">N/A</option>
                            </select>
                        </div>    
                    </div>
                    <!-- External trainer -->
                    <div id="ext_sel">
                        <div  class="form-group">
                            <label class="control-label col-sm-4">External trainer:</label>    
                            <div class="col-sm-6">
                                <select class="form-control" type="text" id="ex_trainer">

                                </select>
                            </div>    
                        </div>
                        <div  class="form-group">
                            <div class="col-sm-4 col-sm-offset-4">
                                <button type="button" id="add_ex_trainer" class="btn btn-default">Add external trainer</button>
                            </div>
                        </div>
                    </div>
                    <!-- Internal trainer -->
                    <div id="in_sel">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Internal trainer:</label>    
                            <div class="col-sm-6">
                                <select class="form-control" type="text" id="in_trainer">
                                    
                                </select>
                            </div>    
                        </div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-4">
                                <button type="button" id="add_in_trainer" class="btn btn-default">Add internal trainer</button>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-4">
                            <button type="submit" class="btn btn-default">Post training for approval</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            jQuery(document).ready(function ($) {
                $(".datepicker").datepicker({dateFormat: 'yy-mm-dd'});
            });
        </script>
        <?php require '../../footer.php'; ?>
    </body>
</html>