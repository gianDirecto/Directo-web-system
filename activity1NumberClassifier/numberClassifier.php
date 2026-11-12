<?php

$num = $_GET['num'];

if ($num > 0) {
    echo "$num is positive.<br>";

    if ($num % 2 == 0) {
        echo "$num is even.";
    } else {
        echo "$num is odd.";
    }

} elseif ($num < 0) {
    echo "$num is negative.";

} else {
    echo "The number is zero.";
}

?>
