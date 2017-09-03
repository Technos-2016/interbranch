<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


header("Content-Type: application/vnd.ms-xls");
header("Content-disposition : attachment, filename:history.xls");
echo $_GET['data'];
?>