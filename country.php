<?php

$t = microtime(true);

$valid = @fsockopen("https://www.youtube.com/embed/iGDsGmqCSGM?list=PLEQVcb8c9mWP8Lcdb_D2RVrDWYig_Qs-I", 80, $errno, $errstr, 30);

echo (microtime(true)-$t);
echo '---';

if (!$valid) {
   echo "Failure";
} else {
   echo "Success";
}
?>