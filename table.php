<?php
  echo '<link rel="stylesheet" type="text/css" href="style.css" />';
$servername = "localhost";
$username = "root";
$password = "root";

$dbase = "urlsdb";

$http = "http://93.73.217.150:8029/"; //home IP
//$http = "http://94.244.30.21:5999"; //work IP          

    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "use {$dbase}";
    $conn->exec($sql);
	
   

/*++++++++++++++++++++++++++++++++++++++++++++++++++*/
	    $sql = "DROP table IF EXISTS COUNT";
		$conn->exec($sql);
		
		$sql = "CREATE TABLE IF NOT EXISTS COUNT (
                SHORTLINK varchar(255),
				DATE varchar(10) ,
				TIME TIME NOT NULL)";
    $conn->exec($sql);
		$sql = "LOAD DATA INFILE '/xampp/htdocs/test/count.csv'
			INTO TABLE COUNT 
			FIELDS TERMINATED BY ',' 
			ENCLOSED BY '\"'
			
			IGNORE 1 ROWS; 
			(@SHORTLINK, @DATA, @TIME)";
	$conn -> exec($sql);
	$sql = "UPDATE links as l SET COUNT =(SELECT count(c.shortlink) FROM count as c WHERE l.short_url = c.shortlink)";
	$conn -> exec($sql);
	/*++++++++++++++++++++++++++++++++++++++++++++++++++*/





$res = $conn->query('SHOW COLUMNS FROM `links`', PDO::FETCH_BOTH); //выгрузка данных из БД




echo 'Table of all URLs: ID,  ORIGIN_URL - long URL user pasted,  SHORT_URL - random generated short URL ,  COUNT -  how many times user follow to link  counter ';

echo '<br>';
echo '<br>';

echo '<table class="table">'; //формируем таблицу
echo '<thead class="thead">'; //созд шапку
echo'<tr >';    //строку
foreach($res as $loc){ //перебор цыкла
    echo'<th>'.$loc["Field"].'</th>'; //вставляем результат-значение $loc 
}
echo'</tr>';
echo '</thead>';

$res = $conn->query('SELECT * FROM `links`', PDO::FETCH_BOTH); // $res переменная, которая является результатом запроса 
foreach($res as $col){
  
    echo '<tr>';
    echo'<td>'.$col[0].'</td>';
    echo'<td><a href ='.$col[1].'>'.$col[1].'</a></td>';
    echo'<td><a href ='.$http.$col[2].'>'.$http.$col[2].'</a></td>';
    echo '<td>'.$col[3].'</td>';
    echo '</tr>';
}

echo '</table>';



?>
