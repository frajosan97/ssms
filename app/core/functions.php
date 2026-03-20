<?php

// use Iodev\Whois\Factory;
// use PhpOffice\PhpSpreadsheet\IOFactory;

function isMobile()
{
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

function isApp()
{
    return false;
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "apppackagename")
        return true;
}

function show($urlContent)
{
    echo "<pre>";
    print_r($urlContent);
    echo "</pre>";
}

function esc($str)
{
    return htmlspecialchars($str);
}

function redirect($path)
{
    header("Location: " . ROOT . $path);
    die;
}

function greeting_msg()
{
    $hour = date('H');
    if ($hour >= 18) {
        $greeting = "Good Evening";
    } elseif ($hour >= 12) {
        $greeting = "Good Afternoon";
    } elseif ($hour < 12) {
        $greeting = "Good Morning";
    }

    return $greeting;
}

// function domainInfo($domain)
// {
//     try {
//         $newDomain = getDomain($domain);
//         // Creating default configured client
//         $whois = Factory::get()->createWhois();
//         // // Checking availability
//         // if ($whois->isDomainAvailable($newDomain)) {
//         //     print "Bingo! Domain is available! :)";
//         // }
//         // // Supports Unicode (converts to punycode)
//         // if ($whois->isDomainAvailable("почта.рф")) {
//         //     print "Bingo! Domain is available! :)";
//         // }
//         // Getting raw-text lookup
//         // $response = $whois->lookupDomain($newDomain);
//         // show($response->text);
//         // Getting parsed domain info
//         $info = $whois->loadDomainInfo($newDomain);
//         if ($info) {
//             return [
//                 'registered' => date("Y-m-d", $info->creationDate),
//                 'expires' => date("Y-m-d", $info->expirationDate),
//                 'owner' => $info->owner,
//             ];
//         }
//     } catch (\Throwable $th) {
//         return [
//             'registered' => date("Y-m-d"),
//             'expires' => date("Y-m-d"),
//             'owner' => "Hencan Group limited",
//         ];
//     }
// }

function getDomain($url = '')
{
    $strToLower = strtolower(trim($url));
    $httpPregReplace = preg_replace('/^http:\/\//i', '', $strToLower);
    $httpsPregReplace = preg_replace('/^https:\/\//i', '', $httpPregReplace);
    $wwwPregReplace = preg_replace('/^www\./i', '', $httpsPregReplace);
    $explodeToArray = explode('/', $wwwPregReplace);
    $finalDomainName = trim($explodeToArray[0]);

    return $finalDomainName;
}

function schoolKey($server)
{
    $domainName = getDomain($server);
    $token = explode(".", $domainName);
    $token = $token[0];

    return $token;
}

function schStatus($status = "")
{
    switch ($status) {
        case '1':
            $finalStatus = "active";
            break;
        case '2':
            $finalStatus = "suspended";
            break;
        default:
            $finalStatus = "undefined";
            break;
    }
    return $finalStatus;
}

function studSalutation($gender = "")
{
    switch ($gender) {
        case 'female':
            $salutation = "daughter";
            break;
        case 'male':
            $salutation = "son";
            break;
        default:
            $salutation = "son / daughter";
            break;
    }
    return $salutation;
}

function schMode($mode = "")
{
    switch ($mode) {
        case '1':
            $finalMode = "subscription";
            break;
        case '2':
            $finalMode = "free";
            break;
        default:
            $finalMode = "undefined";
            break;
    }
    return $finalMode;
}

function isValidEmail($email)
{
    // Remove all illegal characters from email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    } else {
        return true;
    }
}

function rawSmartKey($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

function smartKey($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
    // trim
    $text = trim($text, '-');
    // transliterate
    if (function_exists('iconv')) {
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    }
    // lowercase
    $text = strtolower($text);
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
    if (empty($text)) {
        return 'n-a';
    }

    return hashKey($text);
}

function hashKey($hashData)
{
    return hash('sha256', $hashData);
}

function detect_blanks($string = "")
{
    if (preg_match('/^\S.*\s.*\S$/', $string)) {
        return true;
    }
}

function array_column_count($array, $key)
{
    $column = array();
    $array = objectToArray($array);
    foreach ($array as $origKey => $value) {
        if (isset($value[$key])) {
            $column[$origKey] = $value[$key];
        }
    }
    return $column;
}

function cleanHtml($string)
{
    $newKey = trim($string);
    $newKey = str_replace("_", " ", $newKey);
    $newKey = stripslashes($newKey);

    return $newKey;
}

function smartPhone($phone)
{
    $phone = ltrim($phone, "0");
    $phone = ltrim($phone, "254");
    $phone = ltrim($phone, "+");
    $phone = ltrim($phone, "+254");
    $phone = '+254' . $phone;

    return $phone;
}

function smsPhone($phone)
{
    $phone = ltrim($phone, "0");
    $phone = ltrim($phone, "254");
    $phone = ltrim($phone, "+");
    $phone = ltrim($phone, "+254");
    $phone = '0' . $phone;

    return $phone;
}

function colorRgb($color)
{
    $newColor = trim($color);
    $newColor = str_replace("r", "", $newColor);
    $newColor = str_replace("g", "", $newColor);
    $newColor = str_replace("b", "", $newColor);
    $newColor = str_replace("a", "", $newColor);
    $newColor = str_replace("(", "", $newColor);
    $newColor = str_replace(")", "", $newColor);

    $newColor = explode(",", $newColor);

    return $newColor;
}

function subStatus($status)
{
    if ($status == "active") {
        $btn = "<span class='text-nowrap text-success fw-bolder'><i class='fas fa-check-circle'></i> Active</span>";
    } else {
        $btn = "<span class='text-nowrap text-danger fw-bolder'><i class='fas fa-times-circle'></i> Dropped</span>";
    }

    return $btn;
}

function objectToArray($d)
{
    if (is_object($d)) {
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        return array_map(__FUNCTION__, $d);
    } else {
        return $d;
    }
}

function getPrevKey($key, $hash = array())
{
    $keys = array_keys($hash);
    $found_index = array_search($key, $keys);
    if ($found_index == false || $found_index == 0)

        return false;

    return $keys[$found_index - 1];
}

function dev($deviation)
{
    if (empty($deviation))
        $deviation = 0;

    if ($deviation > 0) {
        $show = "<small class='text-sm bg-light px-2 rounded text-nowrap'>" . $deviation . " <i class='fas fa-level-up text-success'></i></small>";
    } elseif ($deviation < 0) {
        $show = "<small class='text-sm bg-light px-2 rounded text-nowrap'>" . $deviation . " <i class='fas fa-level-down text-danger'></i></small>";
    } else {
        $show = "<small class='text-sm bg-light px-2 rounded text-nowrap'>" . $deviation . " <i class='fas fa-long-arrow-right'></i></small>";
    }

    return $show;
}

function array_rank($in)
{
    $x = $in;
    arsort($x);
    $rank       = 0;
    $hiddenrank = 0;
    $hold = null;
    foreach ($x as $key => $val) {
        $hiddenrank += 1;
        if (is_null($hold) || $val < $hold) {
            $rank = $hiddenrank;
            $hold = $val;
        }
        $in[$key] = $rank;
    }
    return $in;
}

function studRank($resultsData, $rank1 = "", $rank2 = "")
{
    /** sort main array */
    $columns = array_column($resultsData, $rank1);
    array_multisort($columns, SORT_DESC, $resultsData);
    /** set up parameters */
    $output = [];
    $rank = 1;
    /** group the data to check ties */
    $groupedResults = groupBy($resultsData, $rank1);
    /** commence ranking */
    foreach ($groupedResults as $value) {
        if (count($value) > 1) {
            $rankTie = $rank;
            $toadd = count($value);
            /** sort tie array */
            $columns2 = array_column($value, $rank2);
            array_multisort($columns2, SORT_DESC, $value);
            // Break the ties
            $groupedTie = groupBy($value, $rank2);
            foreach ($groupedTie as $tieValue) {
                if (count($tieValue) > 1) {
                    $toaddTie = count($tieValue);
                } else {
                    $toaddTie = 1;
                }
                foreach ($tieValue as $tieOutputKey => $tieOutputData) {
                    $output[$tieOutputKey] = array_merge($tieOutputData, array("rank" => $rankTie));
                }
                $rankTie += $toaddTie;
            }
            // end breaking the ties
        } else {
            $toadd = 1;
            foreach ($value as $outputKey => $outputData) {
                $output[$outputKey] = array_merge($outputData, array("rank" => $rank));
            }
        }
        $rank += $toadd;
    }

    return $output;
}

function multArrayOrder($array, $orderKey = "", $limit = "", $order = SORT_ASC)
{
    $columns = array_column($array, $orderKey);
    array_multisort($columns, $order, $array);
    if (!empty($limit))
        $array = array_slice($array, 0, $limit);

    return $array;
}

function sortArrByColumn($array, $column)
{
    // Initialize the sum to 0
    $sum = 0;
    // Iterate through the array and accumulate the values of the specified column
    foreach ($array as $row) {
        if (isset($row[$column])) {
            $sum += $row[$column];
        }
    }

    return $sum;
}

function groupBy($array, $key)
{
    $return = [];
    foreach ($array as $thisKey => $val) {
        $return[$val[$key]][$thisKey] = $val;
    }

    return $return;
}

function acronym($longname)
{
    $letters = array();
    $words = explode(' ', $longname);
    foreach ($words as $word) {
        $word = (substr($word, 0, 1));
        array_push($letters, $word . ".");
    }
    $shortname = strtoupper(implode($letters));

    return $shortname;
}

function resExt($extension)
{
    switch ($extension) {
        case 'pdf':
            $finalExt = '<i class="fas fa-file-pdf text-danger"></i>';
            break;
        case 'doc':
            $finalExt = '<i class="fas fa-file-word text-primary"></i>';
            break;
        case 'docx':
            $finalExt = '<i class="fas fa-file-word text-primary"></i>';
            break;
        default:
            $finalExt = '<i class="fas fa-list-alt"></i>';
            break;
    }

    return $finalExt;
}

function toWords($num = false)
{
    $num = str_replace(array(',', ' '), '', trim($num));
    if (!$num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array(
        '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array(
        '', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ($tens < 20) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '');
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . (($levels && (int) ($num_levels[$i])) ? ' ' . $list3[$levels] . ' ' : '');
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }

    return implode(' ', $words);
}

function perfComment($type, $score)
{
    switch ($score) {
        case $score >= 80:
            if ($type == "principal") {
                $comment = "Brilliant work, aim much higher next time";
            } else {
                $comment = "Excellent work, aim higher next time";
            }
            break;
        case $score >= 70:
            if ($type == "principal") {
                $comment = "A good record, do better than this next time";
            } else {
                $comment = "Very good work, aim to do better than this next time";
            }
            break;
        case $score >= 50:
            if ($type == "principal") {
                $comment = "Good work done, effortise to score higher next time";
            } else {
                $comment = "Good work, you can do better, aim higher next time";
            }
            break;
        case $score <= 49.99:
            if ($type == "principal") {
                $comment = "You need to put much effort in your studies for better score next time";
            } else {
                $comment = "Much effort is required, you are determined to do better";
            }
            break;
    }

    return $comment;
}

function invStatus($amount)
{
    if (empty($amount))
        $amount = 0;

    if ($amount > 0) {
        $status = "Unsettled";
    } elseif ($amount < 0) {
        $status = "Over Paid";
    } else {
        $status = "Paid";
    }

    return $status;
}

function userRole($role)
{
    $userTitle = "";
    foreach (STAFFTITLES as $key => $value) {
        if ($role == $key) {
            $userTitle = $value;
        }
    }

    return $userTitle;
}

function userStatus($status)
{
    $userStatus = "";
    foreach (STAFFSTATUS as $key => $value) {
        if ($status == $key) {
            $userStatus = $value;
        }
    }

    return $userStatus;
}

function getStreamName($streamKey)
{
    $streamName = "";
    foreach (STREAMS as $stream) {
        if ($stream->str_key == $streamKey) {
            $streamName = $stream->stream;
        }
    }

    return $streamName;
}

function outOf($resultsData, $form, $stream = "", $checkDeterminer = "")
{
    $formCount = 0;
    $streamCount = 0;

    foreach ($resultsData as $results) {
        if ($checkDeterminer > 0) {
            if ($results['re_studF'] == $form) {
                $formCount += 1;
            }
            if (($results['re_studF'] == $form) && ($results['re_studS'] == $stream)) {
                $streamCount += 1;
            }
        }
    }

    $count = array(
        "formCount" => $formCount,
        "streamCount" => $streamCount
    );

    return $count;
}

function hide_email($email)
{
    $em = explode("@", $email);
    $name = implode('@', array_slice($em, 0, count($em) - 1));

    $length = floor(strlen($name) / 2);

    return substr($name, 0, $length) . str_repeat('*', $length) . "@" . end($em);
}

function hide_phone($mobile)
{
    $str_length = strlen($mobile);

    return substr($mobile, 0, 4) . str_repeat('*', $str_length - 7) . substr($mobile, $str_length - 3, 3);
}

function genOtp()
{
    $n = 4;
    $generator = "1357902468";
    $result = "";

    for ($i = 1; $i <= $n; $i++) {
        $result .= substr($generator, rand() % strlen($generator), 1);
    }

    return $result;
}

/**
 * Converts an integer into the alphabet base (A-Z).
 *
 * @param int $n This is the number to convert.
 * @return string The converted number.
 * @author Theriault
 * 
 */
function num2alpha($n)
{
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
        $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
        $n -= pow(26, $i);
    }
    return $r;
}
/**
 * Converts an alphabetic string into an integer.
 *
 * @param int $n This is the number to convert.
 * @return string The converted number.
 * @author Theriault
 * 
 */
function alpha2num($a)
{
    $r = 0;
    $l = strlen($a);
    for ($i = 0; $i < $l; $i++) {
        $r += pow(26, $i) * (ord($a[$l - $i - 1]) - 0x40);
    }
    return $r - 1;
}

function prepend($myNumber)
{
    $num_padded = sprintf("%04d", $myNumber);

    return $num_padded;
}

function uploadDocument($data, $docFolder)
{
    $uploadInfo = [];
    foreach ($data as $key => $value) {
        $fileType = explode("/", $value['type']);
        if (!($fileType[0] == "image")) {
            $path = LIB_PATH . "public/assets/docs/" . $docFolder . "/";
            $filename = $value['name'];
            move_uploaded_file($value['tmp_name'], $path . $filename);
            $uploadInfo["docData"] = array(
                "name" => $filename,
                "type" => $fileType[1],
                "size" => $value['size']
            );
        } else {
            $uploadInfo["errors"] = "Only documents are allowed for upload here, NOT IMAGES!";
        }
    }

    return $uploadInfo;
}

function docCheck($folder, $fileName)
{
    if (file_exists(LIB_PATH . "public/assets/docs/" . $folder . "/" . $fileName)) {
        $returnFile = ROOT . "public/assets/docs/" . $folder . "/" . $fileName;
    }

    if (isset($returnFile)) {
        return $returnFile;
    }
    return false;
}

function docUpload($data, $docFolder)
{
    $uploadInfo = [];
    foreach ($data as $key => $value) {
        $fileType = explode("/", $value['type']);
        if (!($fileType[0] == "image")) {
            $path = LIB_PATH . "public/assets/docs/" . $docFolder . "/";
            $filename = $value['name'];
            move_uploaded_file($value['tmp_name'], $path . $filename);
            $uploadInfo["docInfo"] = array(
                "name" => $filename,
                "type" => $fileType[1],
                "size" => $value['size']
            );
        } else {
            $uploadInfo["errors"] = "Only documents are allowed for upload here, NOT DOCUMENTS!";
        }
    }

    return $uploadInfo;
}

function uploadImage($data, $imgFolder)
{
    $uploadInfo = [];
    foreach ($data as $key => $value) {
        $fileType = explode("/", $value['type']);
        if ($fileType[0] == "image") {
            $path = LIB_PATH . "public/assets/images/" . $imgFolder . "/";
            $filename = $value['name'];
            move_uploaded_file($value['tmp_name'], $path . $filename);
            $uploadInfo["imgData"] = array(
                "name" => $filename,
                "type" => $fileType[1],
                "size" => $value['size']
            );
        } else {
            $uploadInfo["errors"] = "Only images are allowed for upload here, NOT DOCUMENTS!";
        }
    }

    return $uploadInfo;
}

function uploadSingleImg($imgInfo, $imgFolder)
{
    $fileType = explode("/", $imgInfo['type']);
    if ($fileType[0] == "image") {
        $path = LIB_PATH . "public/assets/images/" . $imgFolder . "/";
        $filename = $imgInfo['name'];
        move_uploaded_file($imgInfo['tmp_name'], $path . $filename);
        $uploadInfo["imgData"] = array(
            "name" => $filename,
            "type" => $fileType[1],
            "size" => $imgInfo['size']
        );
    } else {
        $uploadInfo["errors"] = "Only images are allowed for upload here, NOT DOCUMENTS!";
    }

    return $uploadInfo;
}

function imageCheck($folder, $fileName, $default)
{
    if (file_exists(LIB_PATH . "public/assets/images/" . $folder . "/" . $fileName)) {
        $returnFile = ROOT . "public/assets/images/" . $folder . "/" . $fileName;
    } else {
        $returnFile = ROOT . "public/assets/images/" . $folder . "/" . $default;
    }

    return $returnFile;
}

function pdfimageCheck($folder, $fileName, $default)
{
    if (file_exists(LIB_PATH . "public/assets/images/" . $folder . "/" . $fileName)) {
        $returnFile = LIB_PATH . "public/assets/images/" . $folder . "/" . $fileName;
    } else {
        $returnFile = LIB_PATH . "public/assets/images/" . $folder . "/" . $default;
    }

    return $returnFile;
}

function create_log($logData)
{
    if (!(is_array($logData)))
        $logData = [time(), APPINFO->sch_token, VIEWFOLDER, CURRENTUSERKEY, CURRENTUSER, $logData];
    $content = implode("|", $logData) . PHP_EOL;
    $filename = LIB_PATH . "public/logs.txt";
    $fp = fopen($filename, 'a');
    fwrite($fp, $content);
    fclose($fp);
}

function read_log()
{
    $schoolLogs = [];
    $filename = LIB_PATH . "public/logs.txt";
    $lines = array();
    $fp = fopen($filename, "r");
    if (filesize($filename) > 0) {
        $content = fread($fp, filesize($filename));
        $lines = explode("\n", $content);
        fclose($fp);
    }

    foreach ($lines as $key => $value) {
        $lineData = explode("|", $value);
        if (in_array(APPINFO->sch_token, $lineData)) {
            $schoolLogs[] = $lineData;
        }
    }

    $sortColumn = array_column($schoolLogs, 0);
    array_multisort($sortColumn, SORT_DESC, $schoolLogs);

    return $schoolLogs;
}

function timeDifference($time)
{
    if (!(date('Y-m-d', $time) == date('Y-m-d', strtotime('yesterday')))) {
        $start = new DateTime(date('Y-m-d H:i:s', $time));
        $end = new DateTime(date('Y-m-d H:i:s', time()));
        $diff_in_seconds = $end->getTimestamp() - $start->getTimestamp();
        $seconds = floor($diff_in_seconds);
        switch ($seconds) {
            case $seconds < 60:
                $timeDate = 'now';
                break;
            case $seconds > 3600 && $seconds <= 86400:
                $timeDate = date('H:i a', $time);
                break;
            case $seconds > 86400 && $seconds <= 604800:
                $timeDate = date('D', $time);
                break;
            case $seconds > 604800:
                $timeDate = date('d M Y', $time);
                break;
            default:
                $timeDate = round($seconds / 60) . ' min ago';
                break;
        }
    } else {
        $timeDate = 'yesterday';
    }
    return $timeDate;
}

function errorTemp($tempData = [])
{
    return '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>' . ucwords($tempData['title']) . '</title>
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="' . ROOT . 'public/assets/css/bootstrap.css">
    </head>
    <body class="bg-light">
        <div class="container">
            <div class="col-md-9 mt-5 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header h4 text-muted bg-transparent">' . ucwords($tempData['title']) . '</div>
                    <div class="card-body">' . ucfirst($tempData['body']) . '</div>
                </div>
            </div>
        </div>
    </body>
    </html>';
}

function tempLoad($temp = "")
{
    return LIB_PATH . "app/views/common/templates/" . $temp . ".view.php";
}

function incFile($incFile = "")
{
    $incFile = LIB_PATH . 'app/views/common/inc/' . $incFile . '.inc.php';
    if (file_exists($incFile)) {
        return $incFile;
    }
}

function delDoc($delDoc, $folder)
{
    $fileToDelete = LIB_PATH . 'public/assets/docs/' . $folder . '/' . $delDoc;
    if (file_exists($fileToDelete)) {
        if (!(unlink($fileToDelete)))
            return true;
    } else {
        return true;
    }
}

function delImg($delImg, $folder)
{
    $fileToDelete = LIB_PATH . 'public/assets/images/' . $folder . '/' . $delImg;
    if (file_exists($fileToDelete)) {
        if (!(unlink($fileToDelete)))
            return true;
    } else {
        return true;
    }
}

function invCalc($invoice)
{
    $invPaid = 0;
    foreach ($invoice['invPayments'] as $paidAmnt) {
        $invPaid += $paidAmnt['pay_amnt'];
    }
    $invBilled = $invoice['inv_amnt'];
    $invVAT = $invBilled * 0.16;
    $invGrantTotal = $invBilled + $invVAT;
    $invBalance = $invGrantTotal - $invPaid;

    return [
        "invBilled" => $invBilled,
        "invPaid" => $invPaid,
        "invVAT" => $invVAT,
        "invGrantTotal" => $invGrantTotal,
        "invBalance" => $invBalance
    ];
}

function invAmountAddVAT($amount = 0)
{
    if ($amount > 0) {
        $invBilled = $amount;
    } else {
        $invBilled = 0;
    }

    $invVAT = $invBilled * 0.16;
    $invGrantTotal = $invBilled + $invVAT;

    return [
        "invBilled" => $invBilled,
        "invVAT" => $invVAT,
        "invGrantTotal" => $invGrantTotal
    ];
}

// function uploadExcel($data)
// {
//     foreach ($data as $key => $value) {
//         $uploadDirectory = LIB_PATH . 'public/assets/docs/uploads/';
//         $uploadedFile = $uploadDirectory . basename($_FILES[$key]['name']);
//         $fileType = pathinfo($uploadedFile, PATHINFO_EXTENSION);
//         // Check if the file is a valid Excel file
//         if ($fileType == 'xls' || $fileType == 'xlsx') {
//             if (move_uploaded_file($_FILES[$key]['tmp_name'], $uploadedFile)) {
//                 // File uploaded successfully, now process the Excel file
//                 $spreadsheet = IOFactory::load($uploadedFile);
//                 $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
//                 return $sheetData;
//             }
//         }
//     }
// }

function limitChar($text, $limit)
{
    $shortenedText = substr($text, 0, $limit);
    return $shortenedText;
}

function limitWords($text, $limit)
{
    $shortenedText = implode(' ', array_slice($text, 0, $limit));
    return $shortenedText;
}

function resultsRecKey($schToken, $studK, $termKey, $examKey)
{
    return smartKey($schToken . "_" . $studK . "_" . $termKey . "_" . $examKey);
}
