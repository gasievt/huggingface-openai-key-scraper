<?php
$chars = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
'1','2','3','4','5','6','7','8','9','0', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
$path = __DIR__ . '/get_keys.php';
foreach($chars as $char){
    for($i=0; $i<=1000; $i+=100){
        echo "Scraping: $char char" . ' ' . "Page № $i" . PHP_EOL;
        $command = "php $path --char=$char --index=$i > /dev/null &";
        exec($command);
    }
}

do{
    $output = shell_exec('ps -C php -f');
    if (strpos($output, 'get_keys.php') !== false){
        echo "Please wait..." . PHP_EOL;
    }
    else{
        echo "Done!" . PHP_EOL;
    }
    sleep(1);
}while(strpos($output, 'get_keys.php') !== false);

?>