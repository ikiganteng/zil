<?php
function curl($url, $data = 0, $header = 0, $cookie = 0) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    if($header) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    }
    if($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    if($cookie) {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
    }
    $x = curl_exec($ch);
    curl_close($ch);
    return $x;
}

$list = file_get_contents('wallet.txt');
$datas = explode("\n", str_replace("\r", "", $list));
for ($i = 0; $i < count($datas); $i++) {

    $address = $datas[$i];
    $url = 'https://api.viewblock.io/zilliqa/addresses/' . $address . '?network=mainnet&page=1';
	$headers = array();
    $headers[] = 'Origin: https://viewblock.io';
    $headers[] = 'User-Agent: Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:87.0) Gecko/20100101 Firefox/87.0';
    $post = curl($url,0,$headers);
	$port = json_decode($post);
        if (isset($port->tokens->zil18f5rlhqz9vndw4w8p60d0n7vg3n9sqvta7n6t2)) {
			echo $address.' land'. "\n";
		}else{
			echo $address.' gak land'. "\n";
		}
/*

    $curl->setUserAgent('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/89.0.4389.114 Safari/537.36');
    $curl->setHeader('Origin', 'https://viewblock.io');
    $curl->get('https://api.viewblock.io/zilliqa/addresses/' . $address . '?network=mainnet&page=1');

    if ($curl->error) {
        echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage . "\n";
    } else {
        if (isset($curl->response->tokens->zil18f5rlhqz9vndw4w8p60d0n7vg3n9sqvta7n6t2)) {
            $curl->get('https://api.telegram.org/bot' . $telegramToken . '/sendMessage?chat_id=' . $telegramChatId . '&text=Hei, address : ' . $address . ' landing!');
        }
    }
	*/
}
?>
