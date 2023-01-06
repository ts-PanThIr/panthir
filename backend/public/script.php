<?php
echo "\n\n";
$start = microtime(true);

echo (int)is_anagram2('argentino', 'ignorante');

$time_elapsed_secs = microtime(true) - $start;
echo "\n\n";
echo "time took:".($time_elapsed_secs);
echo "\n\n";

$start = microtime(true);

echo (int)is_anagram('argentino', 'ignorante');

$time_elapsed_secs = microtime(true) - $start;
echo "\n\n";
echo "time took:".($time_elapsed_secs);
echo "\n\n";


function is_anagram($a, $b) {
    if(strlen($a) !== strlen($b)) return false;
    return(count_chars($a, 1) == count_chars($b, 1));
}

function is_anagram2($a, $b) {

    if(strlen($a) !== strlen($b)) return false;
    return(count_chars($a, 1) == count_chars($b, 1));
}