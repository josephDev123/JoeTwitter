<?php
$present_date = date('Y-m-d H:i:s');
$present = new DateTime($present_date);
$future = new DateTime($present_date);
$interval = $present->diff($future);
// Output — 05 years, 04 months and 17 days
echo $interval->format('%Y years, %M months and %d days, %H Hour, %i Minute, %s Seconds');
