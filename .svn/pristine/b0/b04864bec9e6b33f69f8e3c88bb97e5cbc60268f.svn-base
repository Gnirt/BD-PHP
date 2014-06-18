<?php
// f_auto_exe.php for bdphp in /Users/Gato/Documents/ETNA/projets/BDPHP_Nov_2013/olivie_c
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Mon Nov 18 14:39:18 2013 OLIVIER Cedric
// Last update Mon Nov 18 17:21:06 2013 OLIVIER Cedric
//
function auto_exe($p_file)
{
  $handle = fopen($p_file, 'r');
  $contents = fread($handle, filesize($p_file));
  $contents = preg_replace('/\s+/', ' ', strtolower($contents));
  $cmd_list = explode(';', $contents);
  foreach ($cmd_list as $key => $value)
    if ($value == "")
      unset($cmd_list[$key]);
  for ($i = 0; $i < count($cmd_list); $i++)
    {
      $cmd = explode(' ', trim($cmd_list[$i]));
      exe_cmdline($cmd);
      unset($a_cmd);
    }
  exit;
}