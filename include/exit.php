<?php
// exit.php for bdphp in /Users/philippe/dev/svn/BDPHP/olivie_c
// 
// Made by Philippe TRING
// Login   <tring_p@etna-alternance.net>
// 
// Started on  Mon Nov 18 15:14:35 2013 Philippe TRING
// Last update Fri Nov 22 17:24:36 2013 Philippe TRING
//
function func_quit($params = null)
{
  exit(0);
}

function func_clear($req = null)
{
  $clearscreen = chr(27)."[H".chr(27)."[2J";
  print $clearscreen;
}