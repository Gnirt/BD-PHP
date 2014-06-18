#!/usr/bin/env php
<?php
// bdphp.php for bdphp  in /Users/Gato/Documents/ETNA/projets/BDPHP_Nov_2013/olivie_c
//
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
//
// Started on  Mon Nov 18 09:30:01 2013 OLIVIER Cedric
// Last update Fri Nov 22 15:53:35 2013 Philippe TRING
//
include_once "include/etc.php";
include_once "include/create.php";
include_once "include/base.php";
include_once "include/auto_exe.php";
include_once "include/exit.php";
include_once "include/describe.php";
include_once "include/insert.php";
include_once "include/truncate.php";
include_once "include/drop.php";
include_once "include/delete.php";
include_once "include/select.php";

main();

function main()
{
  func_clear();
  check_options();
  check_usagedata();
  $fd = fopen('php://stdin', 'r');
  $arr = array();
  if ($fd !== false)
    {
      echo "$> ";
      while (($line = fgets($fd)) !== false)
	$arr = check_cmd($line, $arr);
      fclose($fd);
    }
}
function check_usagedata()
{
  global $database;
  if (count($_SERVER['argv']) == 1)
    $database = "./database/".$_SERVER['argv'][0];
  else
    {
      write("Usage: ./bdphp.php [-i inputfile] [-o outputfile] dbfile");
      exit (1);
    }
  if (!is_dir($database))
    create_database($database);
}
function create_database($database, $continue = true)
{
  $mess = "Warning: $database doesn't exists!";
  write("$mess Would you like to create one? (yes/no)");
  $fd = fopen('php://stdin', 'r');
  while ($continue && ($line = fgets($fd)) !== false)
    {
      if ($line === "yes\n")
	if (mkdir($database))
	  $continue = false;
	else
	  write("Error: Can not create database");
      elseif ($line === "no\n")
	{
	  write("Bye bye darling. Come to see me again.");
	  exit (1);
	}
    }
  fclose($fd);
  write("-> A new database has been create");
}