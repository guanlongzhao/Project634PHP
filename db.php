<!DOCTYPE html>
<html>
<head>
  <title>Database Mangement</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<?php
echo("<h2>Database Management</h2>");
/* 

---- 1.install mongodb driver 


sudo apt-get update
sudo apt-get install php5-dev php5-cli php-pear -y
sudo pecl install mongo

---- 2.change php.ini file

add below in php.ini

extension=mongo.so

----- 3.restart apache

sudo /etc/init.d/apache2 restart

----- 4. run Mongo db

$ mkdir data      // where data are stored
$ echo 'mongod --bind_ip=$IP --dbpath=data --nojournal --rest "$@"' > mongod
$ chmod a+x mongod 

$ ./mongod

----- 5. run mongodb Client
$ mongo

---- reference
https://docs.c9.io/docs/setting-up-mongodb
https://docs.c9.io/docs/setup-a-database

http://www.sitepoint.com/building-simple-blog-app-mongodb-php/

----- mogodb documentation
https://docs.mongodb.org/manual/?_ga=1.77802384.540156671.1447120948
*/

// connect
/*
$./mongod(enter)
checkout dbpath

$m = new MongoClient("mongodb:host:port");
*/
//$m = new MongoClient( "mongodb://ohnarya-project634php-2006741:27017" );


// select a database
// $db = $m->project634;


?>

<button id='truncatetable'>truncate collections.....</button>
<button id='inserttable'>insert collections.....</button>
<p id="notify1"></p>
<p id="notify2"></p>


<script>
$(document).ready(function() {
    $("#truncatetable").on('click', function(){
        document.getElementById("notify1").innerHTML = "truncating collections........";
        document.getElementById("notify2").innerHTML = "";
        $.ajax({
               url: './migrate.php?mode=t',
               dataType: 'json',
               success: function(data){
                   alert(data['id']);
                    $("#notify2").html( "collections were truncated.");
               }
            });
    });
    
    $("#inserttable").on('click', function(){
        document.getElementById("notify1").innerHTML = "inserting collections........";
        document.getElementById("notify2").innerHTML = "";
        $.ajax({
               url: './migrate.php?mode=i',
               dataType: 'json',
               success: function(data){
                   //alert(data['id']);
                    $("#notify2").html( "collections were inserted.");
               }
            });
    });    
});    
</script>

<?php

$m  = new MongoClient( "mongodb://ohnarya-project634php-2174620:27017" );  /*connect*/
$db = $m->selectDB("project634");  /*select DB*/
$collection = $db->selectCollection("user"); /*select collection(table)*/

if($collection != null){
    
    $q = array('id' => '1');   // query select * from user where 'id' =1;
    
    $curser = $collection->find($q); /*fetch data from the table above*/
    
    if($curser!=null)
        echo "<p>Examples: select user '1''s history </p>";

    foreach($curser as $user){
        print_r($user['history']['1']);  
    }
}

?>
