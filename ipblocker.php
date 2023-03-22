<?php
function blockUsers($ipAddresses,$myip) {
    $userOctets = explode('.', $myip); // get the client's IP address and split it by the period character
    $userOctetsCount = count($userOctets);  // Number of octets we found, should always be four
    $block = false; // boolean that says whether or not we should block this user
    foreach($ipAddresses as $ipAddress) { // iterate through the list of IP addresses
		$ipAddress = trim($ipAddress);
        $octets = explode('.', $ipAddress);
        if(count($octets) != $userOctetsCount) {
            continue;
        }
        for($i = 0; $i < $userOctetsCount; $i++) {
            if($userOctets[$i] == $octets[$i] || $octets[$i] == '*') {
                continue;
            } else {
                break;
            }
        }
        if($i == $userOctetsCount) { // if we looked at every single octet and there is a match, we should block the user
            $block = true;
            break;
        }
    }
    
    return $block;
}



$ip = '8.8.8.8';  //change with visitor ip
$ip_list = file_get_contents('ip.txt');  //list of blocked ip address


$whitelist = explode("\n", $ip_list);
if(blockUsers($whitelist,$ip)){
	echo 'blocked'; //message if blocked
}else{
	echo 'clean ip'; //message if not blocked
}
?>

