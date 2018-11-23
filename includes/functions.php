<?php
/**
 * Created by PhpStorm.
 * User: fhasanli
 * Date: 11/5/2018
 * Time: 10:28 AM
 */

function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    $secure = SECURE;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    session_regenerate_id();    // regenerated the session, delete the old one.
}

function login($sms_code, $msisdn, $type='subscribe', $db)
{
    // Using prepared statements means that SQL injection is not possible.
    if(isset($sms_code) && !empty($sms_code))
    {
        if($stmt_select = mysqli_prepare($db,"SELECT `id`,`msisdn`,`sms_code`,`sms_code_login` FROM `subscriber` WHERE `msisdn`=(?) order by `id` DESC LIMIT 1"))
        {
            $stmt_select->bind_param('s', $msisdn);  // Bind "$msisdn" to parameter.
            $stmt_select->execute();    // Execute the prepared query.
            $stmt_select->store_result();

            // get variables from result.
            $stmt_select->bind_result($user_id, $user_msisdn, $user_sms_code, $user_sms_code_login);
            $stmt_select->fetch();

            if ($stmt_select->num_rows == 1)
            {
                if (/*checkbrute($user_id, $db) == true*/ 1!=1)
                {
                    // Account is locked
                    // Send an sms to user saying their account is locked
                    return 'account_locked';
                }
                else
                {
                    // Check if the password in the database matches
                    // the password the user submitted. We are using
                    // the password_verify function to avoid timing attacks.

                    $user_verify_sms_code = ($type=='login') ? $user_sms_code_login : $user_sms_code;

                    if ($sms_code==$user_verify_sms_code)
                    {
                        // Sms code is correct!
                        // Get the user-agent string of the user.
                        $user_browser = $_SERVER['HTTP_USER_AGENT'];
                        // XSS protection as we might print this value
                        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                        $_SESSION['user_id'] = $user_id;
                        // XSS protection as we might print this value
//                        $user_msisdn = intval($user_msisdn);
                        $_SESSION['msisdn'] = $user_msisdn;
                        $_SESSION['login_string'] = hash('sha512',
                            $user_msisdn . $user_browser);
                        // Login successful.
                        return 'success';
                    }
                    else
                    {
                        // Sms code is not correct
                        // We record this attempt in the database
                        $now = time();
                        mysqli_query($db,"INSERT INTO `login_attempts` (`user_id`, `time`)
                                    VALUES ('$user_id', '$now')");
                        return 'sms_code_incorrect';
                    }
                }
            }
            else
            {
                // No user exists.
                return 'user_not_exists';
            }
        }
    }
    else
    {
        // Sms code is empty
        return 'sms_code_empty';
    }
}

function checkbrute($user_id, $db) {
    // Get timestamp of current time
    $now = time();

    // All login attempts are counted from the past 1 hours.
    $valid_attempts = $now - (1 * 60 * 60);

    if ($stmt = mysqli_prepare($db,"SELECT time 
                             FROM `login_attempts` 
                             WHERE `user_id` = ? 
                            AND `time` > '$valid_attempts'"))
    {
        $stmt->bind_param('i', $user_id);

        // Execute the prepared query.
        $stmt->execute();
        $stmt->store_result();

        // If there have been more than 6 failed logins
        if ($stmt->num_rows > 6)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

function login_check($db)
{
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
        $_SESSION['msisdn'],
        $_SESSION['login_string']))
    {
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $msisdn = $_SESSION['msisdn'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        if ($stmt = mysqli_prepare($db,"SELECT `msisdn`
                                      FROM `subscriber` 
                                      WHERE id = ? LIMIT 1"))
        {
            // Bind "$user_id" to parameter.
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if ($stmt->num_rows == 1)
            {
                // If the user exists get variables from result.
                $stmt->bind_result($user_msisdn);
                $stmt->fetch();
                $login_check = hash('sha512', $user_msisdn . $user_browser);

                if (hash_equals($login_check, $login_string) )
                {
                    // Logged In!!!!
                    return true;
                }
                else
                {
                    // Not logged in
                    return false;
                }
            }
            else
            {
                // Not logged in
                return false;
            }
        }
        else
        {
            // Not logged in
            return false;
        }
    }
    else
    {
        // Not logged in
        return false;
    }
}

function subscribe_check($db)
{
    if(login_check($db)==true)
    {
        if ($stmt = mysqli_prepare($db,"SELECT `msisdn`
                                      FROM `subscriber` 
                                      WHERE `id` = ? and (`status` = ? or (`status`=? and DATE_SUB(`created_at`, INTERVAL -12 HOUR)>=now()))  LIMIT 1"))
        {
            $status = 1;
            $status_waiting = 2;

            $stmt->bind_param('iii', $_SESSION['user_id'],$status,$status_waiting);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();

            if($stmt->num_rows == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
    else
    {
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}