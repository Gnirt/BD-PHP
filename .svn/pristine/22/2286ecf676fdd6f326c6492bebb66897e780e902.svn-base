<?php
// drop.php for bdphp in /Users/philippe/dev/svn/BDPHP/olivie_c
// 
// Made by Philippe TRING
// Login   <tring_p@etna-alternance.net>
// 
// Started on  Tue Nov 19 21:49:22 2013 Philippe TRING
// Last update Tue Nov 19 21:55:50 2013 Philippe TRING
//
function func_drop($req)
{
  global $database;
  $tab_name = rtrim($req[1], ';');
  if (table_exists($tab_name))
    {
      unlink("$database/$tab_name.csv");
      write("-> Table '$tab_name' dropped.");
    }
  else
    write("Error: table '$tab_name' doesn't exists");
}