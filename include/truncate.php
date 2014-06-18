<?php
// truncate.php for bdphp in /Users/philippe/dev/svn/BDPHP/olivie_c
// 
// Made by Philippe TRING
// Login   <tring_p@etna-alternance.net>
// 
// Started on  Tue Nov 19 17:28:54 2013 Philippe TRING
// Last update Fri Nov 22 15:24:13 2013 Philippe TRING
//
function func_truncate($req)
{
  global $database;
  $tab_name = rtrim($req[1], ';');
  if (table_exists($tab_name))
    {
      $lines = file("$database/$tab_name.csv");
      $default_tab = $lines[0].$lines[1].$lines[2];
      file_put_contents("$database/$tab_name.csv", rtrim($default_tab));
      write("-> Table '$tab_name' is truncate.");
    }
  else
    write("Error: table '$tab_name' doesn't exists");
}