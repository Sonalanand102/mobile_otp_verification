<?php
// step 1 => Making Connection with the database.
include('connection.php');
$successMsg = '';
$errorMsg= '';
$v_msg = '';
$verification_status = 0;
$mobileNo = $_POST['mobileNo'];
$mobileOTP = $_POST['mobileOTP'];
$otpSent = rand(1000,9999);




    if(isset($_POST['verifyMobileNo'])){
    
        $sel = "SELECT * FROM `mobile_numbers` WHERE mobile_number = '".$mobileNo."'";
        $query = mysqli_query($conn, $sel);
        $row = mysqli_fetch_assoc($query);
        if($row){
            $success_msg = "user already exists!!";
            $mobileNo = $row['mobile_number'];
            //if mobile number is already present then just update the otp and verification status.
            $sql = "UPDATE `mobile_numbers` SET `verification_code`='".$otpSent."' WHERE mobile_number = '".$mobileNo."'";
            if(mysqli_query($conn,$sql)){
                $successMsg = "OTP has been sent to your mobile number !!!";
                echo "<script>alert('".$successMsg."');</script>";
            }else{
                $errorMsg = "Something went wrong, try again !!!!";
                echo "<script>alert('".$errorMsg."');</script>";
            }
        }else if(preg_match('/^(\+\d{1,3}[- ]?)?\d{10}$/',$mobileNo) && !empty($mobileNo)){
            //if mobile number is not present then insert the mobile number and verification code.
            $sql = "INSERT INTO `mobile_numbers`(`mobile_number`, `verification_code`) VALUES ('".$mobileNo."','".$otpSent."')";
            if(mysqli_query($conn,$sql)){
                $successMsg = "OTP has been sent to your mobile number !!!";
                echo "<script>alert('".$successMsg."');</script>";
            }else{
                $errorMsg = "Something went wrong, try again !!!!!";
                echo "<script>alert('".$errorMsg."');</script>";
            }
        }else{
            $errorMsg = "Enter a Valid Mobile Number.";
            echo "<script>alert('".$errorMsg."');</script>";
        }
    }
    
    if(isset($_POST["confirmMobileNo"])){
        $sel = "SELECT * FROM `mobile_numbers` WHERE mobile_number = '".$mobileNo."' AND verification_code = '".$mobileOTP."'";
        $query = mysqli_query($conn, $sel);
        $row = mysqli_fetch_assoc($query);
        if($row){
            $verification_status = 1;
            $sql = "UPDATE `mobile_numbers` SET `verified`=$verification_status WHERE mobile_number = '".$mobileNo."'";
            if(mysqli_query($conn,$sql)) {
                $v_msg = "Your number is verified successfully.";
            }           
        }else{
            $v_msg = "Incorrect OTP, try again !!!";
        }
    }



?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
  </head>
  <body>
    <div class="container mt-5">
        <div class="col-md-6">
            <form action="" method="post">
                <span>Mobile : </span>
                <div>
                    <input type="tel" name="mobileNo" id="mobileNo" value="<?php echo $mobileNo;?>">
                    <input type="submit" name="verifyMobileNo" id="verifyMobileNo" value="Verify">
                </div><br>

                <div id="confirmOTP" <?php if($success_msg != '') {?>style="display:block;"<?php }else{?>style="display:none;"<?php } ?>>
                    <span>OTP : </span>
                    <input type="text" name="mobileOTP" id="mobileOTP"  >
                    <input type="submit" name="confirmMobileNo" id="confirmMobileNo" value="Confirm">
                </div>
                

            </form>
            <br>
            <div id="verification_msg"><?php if($v_msg != '') { echo $v_msg;}  ?></div>
        </div>
    </div>

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

      <!-- <script>
        $(document).ready(function(){
            $('#verifyMobileNo').click(function(){
                let validMobileNumber = $("#mobileNo").val().match(/^(\+\d{1,3}[- ]?)?\d{10}$/)  && ! ($("#mobileNo").val().match(/0{5,}/));
                if(validMobileNumber && location.reload(true)){
                $('#confirmOTP').css('display','block');
                }else{
                    alert('Enter a Valid Mobile Number.');
                }
            });
        });
      </script> -->

        
    </body>
</html>
