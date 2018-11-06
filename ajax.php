<?php
/**
 * Created by PhpStorm.
 * User: fuad
 * Date: 12/3/16
 * Time: 10:29 AM
 */
?>
<?php
include "gamesmanagement/pages/includes/config.php";
include "includes/functions.php";

sec_session_start();

$response = json_encode(array("code"=>0, "content" => "Error system", "err_param" => ''));

if($_POST)
{
    if($_POST['subscribe_form'])
    {
        if(isset($_POST['msisdn']) && !empty($_POST['msisdn']))
        {
            $msisdn = safe($_POST['msisdn']);

            $stmt_select = mysqli_prepare($db,"SELECT `status` FROM `subscriber` WHERE `msisdn`=(?) order by `id` DESC LIMIT 1");
            $stmt_select->bind_param('i', $msisdn);
            $stmt_select->execute();
            $stmt_select->bind_result($result_status);
            $stmt_select->store_result();
            $stmt_select->fetch();

            if($stmt_select->num_rows==1)
            {
                if($result_status==1)
                {
                    $response = json_encode(array("code"=>0, "content" => "You are already subscriber. Please log in", "err_param" => ''));
                }
                else
                {
                    $response = json_encode(array("code"=>0, "content" => "You are already subscriber. Please check balance", "err_param" => ''));
                }
                $stmt_select->close();
            }
            else
            {
                $status = 0;

                $sms_code = mt_rand(100000, 999999);

                $stmt_insert = mysqli_prepare($db, "INSERT INTO `subscriber` (`msisdn`,`sms_code`,`status`) VALUES (?,?,?)");
                $stmt_insert->bind_param('iii', $msisdn,$sms_code,$status);
                $insert = $stmt_insert->execute();

                if($insert==1)
                {
                    $_SESSION['msisdn'] = $msisdn;

                    $response = json_encode(array("code"=>1, "content" => "Success insert", "err_param" => ''));
                    $stmt_insert->close();
                }
                else
                {
                    $response = json_encode(array("code"=>0, "content" => "Insert error", "err_param" => 'insert'));
                }
            }
        }
        else
        {
            // The correct POST variables were not sent to this page.
            $response = json_encode(array("code"=>0, "content" => "msisdn is empty!", "err_param" => 'msisdn'));
        }
    }
    elseif($_POST['check_sms_form'])
    {
        $sms_code = intval($_POST['sms_code']);

        $stmt_select = mysqli_prepare($db,"SELECT `id`,`sms_code` FROM `subscriber` WHERE `msisdn`=(?) and `sms_code`=(?) order by `id` DESC LIMIT 1");
        $stmt_select->bind_param('ii', $_SESSION['msisdn'],$sms_code);
        $stmt_select->execute();
        $stmt_select->bind_result($result_status);
        $stmt_select->store_result();
        $stmt_select->fetch();

        if($stmt_select->num_rows==1)
        {
            $status = 1;

            $stmt_update = mysqli_prepare($db, "UPDATE `subscriber` FROM `status`=(?) WHERE `msisdn`=(?)");
            $stmt_update->bind_param('ii', $status,$_SESSION['msisdn']);
            $update = $stmt_update->execute();

            if($update==1)
            {
                $_SESSION['msisdn'] = '';
                $response = json_encode(array("code"=>1, "content" => "Update error", "err_param" => ''));
            }
            else
            {
                $response = json_encode(array("code"=>0, "content" => "Success update", "err_param" => ''));
            }
        }
        else
        {
            $response = json_encode(array("code"=>0, "content" => "subscriber not found!", "err_param" => ''));
        }
    }
}

echo $response;
?>
