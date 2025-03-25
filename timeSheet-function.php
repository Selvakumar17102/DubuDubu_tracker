<?php

class sum{
    function add($app_hrs,$bill_hrs){
        $hrs = intval($app_hrs) * 60;
        $min = date("i", strtotime($app_hrs));
        $ap_min = $hrs + $min;
        $new_bill_min = intval($bill_hrs) * 60;
        $rem_min = $new_bill_min - $ap_min;
        $rem_hrs = intdiv($rem_min, 60).':'.($rem_min % 60);
        return $rem_hrs;
    }
}
?>