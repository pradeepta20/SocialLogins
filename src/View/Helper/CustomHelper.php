<?php

namespace Cake\View\Helper;

use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\Time;

class CustomHelper extends Helper {

    function dateDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y", strtotime($datetime));
        } else {
            return false;
        }
    }

    function dateDisplayTime($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y H:i:s", strtotime($datetime));
        } else {
            return false;
        }
    }

    public function shortLength($x, $length) {
        if (strlen($x) <= $length) {
            return $x;
        } else {
            $y = substr($x, 0, $length) . '...';
            return $y;
        }
    }

    public function bubbleSort(array $arr) {
        $n = sizeof($arr);
        $totalWidth = 0;
        for ($i = 0; $i < $n; $i++) {
            list($width) = getimagesize(POST_IMAGES . $arr[$i]['image']);
            $totalWidth = $totalWidth + $width;
        }
        for ($i = 1; $i < $n; $i++) {
            for ($j = $n - 1; $j >= $i; $j--) {
                list($width1) = getimagesize(POST_IMAGES . $arr[$j - 1]['image']);
                list($width2) = getimagesize(POST_IMAGES . $arr[$j]['image']);
                if ($width1 < $width2) {
                    $tmp = $arr[$j - 1];
                    $arr[$j - 1] = $arr[$j];
                    $arr[$j] = $tmp;
                }
            }
        }
        return ['arr' => $arr, 'total_width' => $totalWidth, 'count' => $n];
    }

    public static function makeSeoUrl($url) {
        if ($url) {
            $url = trim($url);
            $value = preg_replace("![^a-z0-9]+!i", "-", $url);
            $value = trim($value, "-");
            return strtolower($value);
        }
    }

    public static function getPostType($userType = null) {
        if ($userType == 4) { //For kid
            return [0 => 'Public', 1 => 'Private'];
        } else { //For School
            return [0 => 'Public', 1 => 'Private', 2 => 'Followers'];
        }
    }

    public static function getCommentTime($date) {
        $time = date("M d Y", $date) . " at " . date("H:i A ", $date);
        return $time;
    }

    public static function timeAgo($time_ago) {
        if (!is_numeric($time_ago)) {
            $time_ago = strtotime($time_ago);
        }
        $cur_time = time();
        $time_elapsed = $cur_time - $time_ago;
        $seconds = $time_elapsed;
        $minutes = round($time_elapsed / 60);
        $hours = round($time_elapsed / 3600);
        $days = round($time_elapsed / 86400);
        $weeks = round($time_elapsed / 604800);
        $months = round($time_elapsed / 2600640);
        $years = round($time_elapsed / 31207680);

        if ($seconds <= 60) {  // Seconds
            echo "$seconds seconds ago";
        } else if ($minutes <= 60) { //Minutes
            if ($minutes == 1) {
                echo "one minute ago";
            } else {
                echo "$minutes minutes ago";
            }
        } else if ($hours <= 24) { //Hours
            if ($hours == 1) {
                echo "an hour";
            } else {
                echo "$hours hours ago";
            }
        } else if ($days <= 7) { //Days
            if ($days == 1) {
                echo "yesterday";
            } else {
                echo "$days days ago";
            }
        } else if ($weeks <= 4.3) { //Weeks
            if ($weeks == 1) {
                echo "a week ago";
            } else {
                echo "$weeks weeks ago";
            }
        } else if ($months <= 12) { //Months
            if ($months == 1) {
                echo "a month ";
            } else {
                echo "$months months ago";
            }
        } else { //Years
            if ($years == 1) {
                echo "one year ago";
            } else {
                echo "$years years ago";
            }
        }
    }

    function defaultImage($image) {

        return $image;
    }

    function getStatus($status) {
        $status = "Enabled";
        if ($status == 0) {
            $status = "Disabled";
        }
        return $status;
    }

/////////////////////////////ENCRYPTION AND DECRYPTION CODE/////////////////////////////////////
    public function encryptor($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'chinu';
        $secret_iv = 'uk';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        //do the encyption given text/string/number
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            //decrypt the given text/string/number
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }

    ///////////////Status of transaction/////////////////////////////


    function dateDisplaysaprate($datetime) {

        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {

            return date("M-d-Y, H:i:s", strtotime($datetime));
        } else {

            return false;
        }
    }

    function getTime($datetime) {
        $now = new Time($datetime);
        echo $now->timeAgoInWords(
                        ['format' => 'MMM d, YYY', 'end' => '+1 year']
        );
    }

}
