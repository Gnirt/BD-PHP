<?php
// etc.php for bdphp in /Users/philippe/dev/svn/BDPHP/olivie_c
// 
// Made by Philippe TRING
// Login   <tring_p@etna-alternance.net>
// 
// Started on  Tue Nov 19 17:52:22 2013 Philippe TRING
// Last update Tue Nov 19 17:52:41 2013 Philippe TRING
//
function table_exists($tab_name)
{
  global $database;
  $res = false;
  if ($handle = @opendir($database))
    {
      while (false !== ($entry = readdir($handle)))
	if ($entry == $tab_name.".csv")
	  $res = true;
      closedir($handle);
    }
  return $res;
}