<?php
echo '<link rel="stylesheet" type="text/css" href="style.css" />';
header('Content-type: text/html; charset=windows-1251');
$servername = "localhost";
$username = "root";
$password = "root";
$dbase = "urlsdb";
$link = $_POST['link'];
$time = date("H:i:s");
$data = date("m.d.y");
$short = ""; 
for ($i = 0; $i < 5; $i++) 
  $short .= chr(mt_rand(48, 57));  
	
try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS {$dbase}";
    $conn->exec($sql);
    $sql = "use {$dbase}";
    $conn->exec($sql);
		$sql = "CREATE TABLE IF NOT EXISTS links (
					ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
					ORIGIN_URL text(65535),
					SHORT_URL varchar(100),
                    COUNT varchar(100))";	
	$conn ->exec($sql);
	$sql = "INSERT INTO `links`(`ORIGIN_URL`,`SHORT_URL`) VALUES ('$link','$short')";
	$conn ->exec($sql);	
}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
	
mkdir('/xampp/htdocs/'.$short, 0700);	
	$text='<meta http-equiv="refresh" content="0; URL='.$link.'" />
	<?php
$text="'.$short.','.$data.','.$time.'\n";
$fp=fopen ("c:\\\\xampp\\\\htdocs\\\\test\\\\count.csv", "a");   
			fwrite($fp,$text);   
				fclose($fp);
	?>';


$fp = fopen ("c:\\xampp\\htdocs\\".$short."\\index.php", "w");   
			fwrite($fp,$text);   
				fclose($fp);  
	
    //$shortlink='http://94.244.30.21:5999/'.$short; //my work ip
    $shortlink='http://93.73.217.150:8029/'.$short; //my home ip
       // $shortlink='http://94.158.87.217:8029/'.$short; 
echo '<div class="resultlink" id="resultlink" style="margin:300 auto">';
    echo  '<center>Your short URL is : </center>', '<center><a href="'.$shortlink.'"> '.$shortlink.'</a></center>';	

echo '<br>';

echo '<br>';


	
echo '<form action ="table.php" method="post"  align=center style="margin:100 auto" >';
echo '<input type="submit" name="link" value="Show table of all URLs" class="button">';
echo '</form>';







?>