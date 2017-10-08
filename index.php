<?php

if (file_exists('loader.php')) {
    require_once  'loader.php';
}
 else {
echo "Отправь смс! <br/>"
.'Читайте <a href ="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/readme.md">README.md</a>' ;

 }