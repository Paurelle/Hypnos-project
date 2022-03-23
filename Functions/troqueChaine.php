<?php

function tronque_chaine ($chaine, $lg_max) {
    if (strlen($chaine) > $lg_max) {
        $chaine = substr($chaine, 0, $lg_max);
        $last_space = strrpos($chaine, " ");
        $chaine = substr($chaine, 0, $last_space)."...";
        return $chaine;
    }else{
        return $chaine;
    }
}