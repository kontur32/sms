<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$text = file_get_contents('tarif.md');
	include_once '../includes/Parsedown.php';
	$Parsedown = new Parsedown();

	echo
		'<link rel="stylesheet" type="text/css" href="../style.css">'
		.'<div class="block">'
                    . $Parsedown->text($text)
		.'</div>';