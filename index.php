<?php
 /**
 * @author Praszna Koppány V.
 **/
session_start();
include './vendor/autoload.php';

use App\Html\Request;

Request::handle();
