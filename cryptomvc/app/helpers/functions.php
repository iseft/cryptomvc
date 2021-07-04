<?php

function isHomeUrl() {
    $homeUrl = '/' . explode('/', URLROOT)[1] . '/';
    $homeUrl2 = $homeUrl . 'pages';
    $homeUrl3 = $homeUrl . 'pages/';
    $homeUrl4 = $homeUrl . 'pages/index';
    $homeUrl5 = $homeUrl . 'pages/index/';
        
    if ($_SERVER['REQUEST_URI'] !=  $homeUrl && $_SERVER['REQUEST_URI'] !=  $homeUrl2 && $_SERVER['REQUEST_URI'] !=  $homeUrl3 && $_SERVER['REQUEST_URI'] !=  $homeUrl4 && $_SERVER['REQUEST_URI'] !=  $homeUrl5) {
        return false;
    } else {
        return true;
    }
}
