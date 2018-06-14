<?php

echo date('H:i:s m-d-Y');

echo "<br>";

echo date("H:i:s m-d-Y", strtotime('-8 hours'));

echo "<br>";

echo "<br>";

date_default_timezone_set('America/Los_Angeles');
echo date("H:i:s m-d-Y");