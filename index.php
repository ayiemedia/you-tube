<?php
//Copyright (C) 2010 Joe Tasker

//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.

//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.

//    You should have received a copy of the GNU General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>
session_start();
$name = $_SESSION['name'];
Header('Cache-Control: no-cache');
Header('Pragma: no-cache');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Chatbox</title>
<script>
function wopen(url, name, w, h)
{
w += 32;
h += 96;
 var win = window.open(url,
  name, 
  'width=' + w + ', height=' + h + ', ' +
  'location=no, menubar=no, ' +
  'status=no, toolbar=no, scrollbars=no, resizable=no');
 win.resizeTo(w, h);
 win.focus();
}
</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/
libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var auto_refresh = setInterval(
function ()
{
$('#chatfile').load('chatfile.html');
}, 1000);  
</script>
<style type="text/css">
<!--
.style1 {
	font-family: "Trebuchet MS";
	font-size: x-large;
	color: #FFFFFF;
}
.style2 {
	font-family: "Trebuchet MS";
	font-size: small;
	color: #FFFFFF;
}
.style3 {font-family: "Trebuchet MS"; font-size: small; color: #000000; }
-->
</style></head>

<body>
<table width="300px" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" frame="box" rules="rows">
  <tr>
    <td bgcolor="#00CCFF"><span class="style1">Chatbox</span></td>
  </tr>
  <tr>
    <td><div id="chatfile" class="style3" style="width: 300px; height: 150px; overflow-y: scroll;"><?php echo file_get_contents('chatfile.html'); ?></div></td>
  </tr>
  <tr>
    <td bgcolor="#00CCFF" class="style2"><form id="chatbox" name="chatbox" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p align="center">User: 
          <input name="un" type="text" id="un" value="<?php echo $name; ?>" size="20" />
      </p>
        <p align="center">Message: 
          <textarea name="m" id="m"></textarea>
           </p>
        <p align="center">
          <input name="send" type="submit" id="send" value="Send" />
        </p>
    </form>    </td>
  </tr>
</table>
<p align="center" class="style3">
  <?php
if(isset($_POST['send'])){
$text = $_POST['m'];
$name = $_POST['un'];
$_SESSION['name'] = $name;
$replace = array(
  'shit' => '$%&@#*!', 
  'fuck' => '$%&@#*!',
  'knob' => '$%&@#*!',
  'cunt' => '$%&@#*!',
  'bitch' => '$%&@#*!',
  'slut' => '$%&@#*!',
  'slag' => '$%&@#*!',
  'dick' => '$%&@#*!',
  'ass' => '$%&@#*!',
  'tit' => '$%&@#*!',
  'cum' => '$%&@#*!',
  'prick' => '$%&@#*!',
  ':-)' => '{smiley_smile.gif}',
  ':-D' => '{smiley_grin.gif}',
  ':-(' => '{smiley_sad.gif}',
  ':-S' => '{smiley_worried.gif}',
  ':-P' => '{smiley_tongue.gif}',
  ':-0' => '{smiley_surprised.gif}',
  '8-)' => '{smiley_cool.gif}',
);
$text = str_ireplace(
  array_keys($replace), 
  array_values($replace), 
  $text
);
$text = strip_tags($text, '<b>,<i>');
$image = split("{",$text);
$part1 = $image[0];
$image = split("}",$image[1]);
$part2 = $image[1];
$image = $image[0];
if(stristr($image,"http://")){
$image = '<i>Please do not link to external images</i>';
echo $part1 . $image . $part2;
}elseif(stristr($image,"www.")){
$image = '<i>Please do not link to external images</i>';
$write = $name . ' : ' . $part1 . $image . $part2 . '<br>';
}elseif(stristr($image,"smiley")){
$image = '<img src="emoticons/' . $image . '"/>';
$write = $name . ' : ' . $part1 . $image . $part2 . '<br>';
}else{
$write = $name . ' : ' . $text . '<br>';
}
$previous = file_get_contents('chatfile.html');
$write = $write . $previous;
$chatfile = fopen('chatfile.html', 'w');
fwrite($chatfile, $write);
fclose($chatfile);
echo '<script type="text/javascript">window.location.reload()</script>';
}
?>
<a href="smileys.php" target="popup" onClick="wopen('smileys.php', 'popup', 300, 300); return false;">View available Smileys </a></p>

<p></p>
</body>
</html>
