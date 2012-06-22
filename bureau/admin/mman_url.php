<?php
/*
 $Id: mman_url.php 2516 2009-06-14 12:42:14Z benjamin $
 ----------------------------------------------------------------------
 AlternC - Web Hosting System
 Copyright (C) 2002 by the AlternC Development Team.
 http://alternc.org/
 ----------------------------------------------------------------------
 Based on:
 Valentin Lacambre's web hosting softwares: http://altern.org/
 ----------------------------------------------------------------------
 LICENSE

 This program is free software; you can redistribute it and/or
 modify it under the terms of the GNU General Public License (GPL)
 as published by the Free Software Foundation; either version 2
 of the License, or (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 To read the license please visit http://www.gnu.org/copyleft/gpl.html
 ----------------------------------------------------------------------
 Original Author of file: Benjamin Sonntag
 Purpose of file: change and tell the url of the mailman.
 ----------------------------------------------------------------------
*/
require_once("../class/config.php");
include_once("head.php");

$fields = array (
	"id"     => array ("request", "integer", ""),
);
getFields($fields);


if (!($me=$mailman->get_lst($id))) {
	$error=$err->errstr();
	?>
	  <h3><?php __("Mailing lists"); ?></h3>
<?php 
 echo "<p class=\"error\">$error</p>";
 include_once("foot.php");
 exit();
 }

?>
<h3><?php __("Mailing lists"); ?></h3>
<?php
	if ($error) {
		echo "<p class=\"error\">$error</p>";
	}

$cururl=$mailman->get_list_url($id);

__("This is the current url to access administration and public pages for this list. If you want to change it, select another url in the list and submit this form. <br />If you don't know what you are doing, don't change anything here.");

?>
<form method="post" action="mman_dourl.php" name="main" id="main">
<input type="hidden" name="id" value="<?php echo $id ?>" />
<?php echo "<h3>".sprintf(_("Changing management url of list %s"),$me)."</h3>"; ?>
<table class="tedit">
<tr><th><?php __("Current list url"); ?></th><td>
<?php echo $cururl; ?>
	</td></tr>
<tr><th><label for="pass"><?php __("New list management url"); ?> </label></th><td>
	<select name="newurl" class="inl" id="newurl" >
  <?php
  list($name,$ldom)=explode("@",$me);
  $alist=array(
	       "http://".$_SERVER["HTTP_HOST"]."/cgi-bin/mailman/"=>"http://".$_SERVER["HTTP_HOST"]."/cgi-bin/mailman/",
	       "https://".$_SERVER["HTTP_HOST"]."/cgi-bin/mailman/"=>"https://".$_SERVER["HTTP_HOST"]."/cgi-bin/mailman/",
	       "http://".$ldom."/cgi-bin/mailman/"=>"http://".$ldom."/cgi-bin/mailman/",
	       "https://".$ldom."/cgi-bin/mailman/"=>"https://".$ldom."/cgi-bin/mailman/",
	       );
eoption($alist,$cururl);

?>
  </select>
	</td></tr>
<tr><td colspan="2">
  <input type="submit" class="inb" name="submit" value="<?php __("Change the url."); ?>"/>
<input type="button" class="inb" name="cancel" value="<?php __("Cancel"); ?>" onclick="document.location='mman_list.php'"/>
</td></tr>
</table>
  </form>

<script type="text/javascript">
document.forms['main'].newurl.focus();
</script>


<?php include_once("foot.php"); ?>