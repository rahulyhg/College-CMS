<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Fee Vocher</title>
</head>
<body>
<div class="container-fluid" style="margin-top: -30px;">
	<h1 class="well well-sm" align="center">Manage Class Fee Accounts</h1>
    <form method="POST">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Class</label>
                    <select class="form-control" name="classid" id="classId">
                            <?php 
                                $className = Yii::$app->db->createCommand("SELECT * FROM std_class_name where delete_status=1")->queryAll();
                                
                                    foreach ($className as  $value) { ?>    
                                    <option value="<?php echo $value["class_name_id"]; ?>">
                                        <?php echo $value["class_name"]; ?> 
                                    </option>
                            <?php } ?>
                    </select>      
                </div>    
            </div>  
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Session</label>
                    <select class="form-control" name="sessionid" id="sessionId">
                            <?php 
                                $sessionName = Yii::$app->db->createCommand("SELECT * FROM std_sessions where delete_status=1")->queryAll();
                                
                                    foreach ($sessionName as  $value) { ?>  
                                    <option value="<?php echo $value["session_id"]; ?>">
                                        <?php echo $value["session_name"]; ?>   
                                    </option>
                            <?php } ?>
                    </select>      
                </div>    
            </div>  
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Section</label>
                    <select class="form-control" name="sectionid" id="section" >
                            <option value="">Select Section</option>
                    </select>      
                </div>    
            </div>    
        </div>
        <div class="row">              
            <div class="col-md-4">
                <div class="form-group">
                    <label>Select Month</label>
                    <select class="form-control" name="month">
                        <option value="1">January</option>
                        <option value="2">Fabruary</option>
                        <option value="3">March</option>
                        <option value="4">April</option>
                        <option value="5">May</option>
                        <option value="6">June</option>
                        <option value="7">July</option>
                        <option value="8">August</option>
                        <option value="9">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>      
                </div>    
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control" name="date">     
                </div>    
            </div> 
            <div class="col-md-2 col-md-offset-1">
                <div class="form-group" style="margin-top: 24px;">
                    <button type="submit" name="submit" class="btn btn-info btn-flat btn-block">Get Class</button>
                </div>    
            </div>
        </div>
    </form>
    <!-- Header Form Close-->
<?php 

    if(isset($_POST['submit'])){ 
        $classid   = $_POST["classid"];
        $sessionid = $_POST["sessionid"];
        $sectionid = $_POST["sectionid"];
        $month     = $_POST["month"];
        $date      = $_POST["date"];
        // Select CLass...
        $className = Yii::$app->db->createCommand("SELECT class_name FROM std_class_name WHERE class_name_id = '$classid'")->queryAll();
        // Select Session... 
        $sessionName = Yii::$app->db->createCommand("SELECT session_name FROM std_sessions WHERE session_id = '$sessionid'")->queryAll();
       // Select Section...
        $sectionName = Yii::$app->db->createCommand("SELECT section_name FROM std_sections WHERE section_id = '$sectionid'")->queryAll();
        // Select Students...
        $student = Yii::$app->db->createCommand("SELECT sed.std_enroll_detail_id ,sed.std_enroll_detail_std_id FROM std_enrollment_detail as sed INNER JOIN std_enrollment_head as seh ON seh.std_enroll_head_id = sed.std_enroll_detail_head_id WHERE seh.class_name_id = '$classid' AND seh.session_id = '$sessionid' AND seh.section_id = '$sectionid'")->queryAll();
    ?>

    <form method="POST">
    	<div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="hidden" name="_csrf" class="form-control" value="<?=Yii::$app->request->getCsrfToken()?>">          
                </div>    
            </div>    
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive table-hover table-condensed" border="1" style="text-align: center;">
                    <tr class="label-primary">
                        <th rowspan="2">Sr #</th>
                        <th rowspan="2">Roll #</th>
                        <th rowspan="2">Student<br> Name</th>
                        <th rowspan="2">Admission<br> Fee</th>
                        <th rowspan="2">Tuition<br> Fee</th>
                        <th rowspan="2">Late Fee<br> Fine</th>
                        <th rowspan="2">Absent<br> Fine</th>
                        <th rowspan="2">Library<br> Dues</th>
                        <th rowspan="2">Transportation<br> Fee</th>
                        <th colspan="3" style="text-align: center;">Amount</th>
                    </tr>
                    <tr style="background-color: #87CEFA">
                        <th>Total</th>
                        <th>Discount</th>
                        <th>Net</th>
                    </tr>
                    <?php 
                        foreach ($student as $id =>$value) {
                            $stdInfo = Yii::$app->db->createCommand("SELECT std_name , std_father_name  FROM std_personal_info WHERE std_id = '$value[std_enroll_detail_std_id]'")->queryAll();
                            $fee = Yii::$app->db->createCommand("SELECT net_addmission_fee , net_tuition_fee  FROM std_fee_details WHERE std_id = '$value[std_enroll_detail_std_id]'")->queryAll(); 
                    ?>
                    <tr>
                        <td>
                            <p style="margin-top: 8px"><?php echo $id+1; ?></p>
                        </td>
                        <td>
                            <p style="margin-top: 8px">001</p>
                        </td>
                        <td>
                            <p style="margin-top: 8px"><?php echo $stdInfo[0]['std_name'];?></p>
                         </td>
                        <td align="center">
                            <input class="form-control" type="number" value="<?php echo $fee[0]['net_addmission_fee']; ?>" readonly="" style="width: 80px; border: none;">
                        </td>
                        <td align="center">
                            <input class="form-control" type="number" value="<?php echo $fee[0]['net_tuition_fee']; ?>" readonly="" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="late_fee_fine" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="absent_fine" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="library_dues" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="transport_fee" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="total_amount" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="discount_amount" style="width: 80px; border: none;">
                        </td>
                        <td>
                            <input class="form-control" type="number" name="net_total" style="width: 80px; border: none;">
                        </td>
                    </tr>
                <?php } ?>
                </table>
            </div>
        </div>
		<div class="row">
			<div class="col-md-4">
                <div class="form-group">
                    <button type="submit" name="save" class="btn btn-success">Submit</button>
                </div>    
            </div>
		</div>
    </form>
    <!-- Fee Transaction Form Close -->
<?php
    }
?>
</div>   
</body> 
</html>

<?php
$url = \yii\helpers\Url::to("index.php?r=fee-transaction-detail/fetch-students");

$script = <<< JS
$('#sessionId').on('change',function(){
   var session_Id = $('#sessionId').val();
  
   $.ajax({
        type:'post',
        data:{session_Id:session_Id},
        url: "$url",

        success: function(result){
     
            var jsonResult = JSON.parse(result.substring(result.indexOf('['), result.indexOf(']')+1));
            var options = '';
            for(var i=0; i<jsonResult.length; i++) { 
                options += '<option value="'+jsonResult[i].section_id+'">'+jsonResult[i].section_name+'</option>';
            }
            // Append to the html
            $('#section').append(options);
        }         
    });       
});
JS;
$this->registerJs($script);
?>
</script>