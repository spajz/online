<?php
if(isset($_GET['_info']) && $_GET['_info'] == '500'){
    phpinfo();
} else {
    die();
}