<?php
// base.php for bdphp in /Users/Gato/PHP_ETNA
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Mon Nov 18 13:51:32 2013 OLIVIER Cedric
// Last update Fri Nov 22 15:15:02 2013 Philippe TRING
//
function check_options()
{
  global $OUT;
  $opt = getopt('i:o:', $_SERVER['argv']);
  formating_argv($opt);
  if (isset($opt['o']))
    $OUT = $opt['o'];
  if (isset($opt['i']))
    {
      check_usagedata();
      auto_exe($opt['i']);
    }
}
function formating_argv($opt)
{
  unset($_SERVER['argv'][0]);
  foreach ($_SERVER['argv'] as $key => $value)
    {
      if ($value[0] == '-')
	unset($_SERVER['argv'][$key]);
      foreach ($opt as $val)
	if ($value == $val)
	  unset($_SERVER['argv'][$key]);
    }
  $arr = array();
  foreach ($_SERVER['argv'] as $value)
    if (isset($value))
      array_push($arr, $value);
  $_SERVER['argv'] = $arr;
}
function write($str)
{
  global $OUT;
  if (isset($OUT))
    {
      if ($fo = @fopen($OUT, 'a'))
	fwrite($fo, $str . "\n");
      else
	exit("Error: No outputfile\n");
    }
  echo $str . "\n";
}
function check_cmd($line, $a_cmd)
{
  $line = preg_replace('/\s+/', ' ', strtolower(trim($line)));
  if ($line != "")
    $a_cmd = array_merge($a_cmd, explode(" ", $line));
  if (strpos($line, ';') === (strlen($line) - 1))
    {
      if (strlen($a_cmd[count($a_cmd) - 1]) == 1)
	unset($a_cmd[count($a_cmd) - 1]);
      else
	$a_cmd[count($a_cmd) - 1] = substr($a_cmd[count($a_cmd) - 1], 0, -1);
      exe_cmdline($a_cmd);
      echo "$> ";
      unset($a_cmd);
    }
  elseif (strpos($line, ';'))
    {
      write("syntax error");
      unset($a_cmd);
    }
  if (!isset($a_cmd))
    $a_cmd = array();
  return $a_cmd;
}
function exe_cmdline($a_cmd)
{
  if (isset($a_cmd[0]))
    {
      $ptr = "func_".$a_cmd[0];
      if (function_exists($ptr))
	$ptr($a_cmd);
      else
	write("Syntax error : function $a_cmd[0] doesn't exists");
    }
  else
    write("TU FOUS MA GUELLE ?");
}