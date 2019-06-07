<?php

$command = 'cd Standard; php CalculateBase.php 2';
echo passthru( $command ." 2>&1");

?>