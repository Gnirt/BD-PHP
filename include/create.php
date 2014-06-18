<?php
// create.php for bdphp in /Users/Gato/PHP_ETNA
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Mon Nov 18 13:54:39 2013 OLIVIER Cedric
// Last update Fri Nov 22 15:49:12 2013 Philippe TRING
//

function func_create($req)
{
  $list_type = array('integer', 'float', 'bool', 'string');
  $list_option = array('primary_key', 'not_null');
  $error = false;
  $req = implode(" ", $req);
  if (!preg_match_all("/create table (\w+)\s*\((.+)\)\s*/", $req, $match))
    write("Create table syntax error in request");
  else
    {
      $tab_name = $match[1][0];
      $col = explode(',', $match[2][0]);
      foreach ($col as $v)
	{
	  $v = explode(' ', trim($v));
	  if (count($v) < 2 || !in_array($v[1], $list_type))
	    $error = true;
	  if (count($v) == 3 && !in_array($v[2], $list_option))
	    $error = true;
	  else if (count($v) == 3 && $v[2] == 'primary_key')
	    array_shift($list_option);
	}
      if ($error || in_array('primary_key', $list_option))
	write("Create table unknown type, options or duplicate primary key");
      else
	create_table($col, $tab_name);
    }
}

function create_table($col, $tab_name)
{
  global $database;
  $duplicate = false;
  $l1 = $l2 = $l3 = '';
  if (table_exists($tab_name))
    write("Error: Table '$tab_name' already exists");
  else
    {
      foreach ($col as $v)
	{
	  $v = explode(' ', trim($v));
	  $l1 .= $v[0].";";
	  $l2 .= $v[1].";";
	  $l3 .= isset($v[2]) ? $v[2].";" : 'null;';
	}
      $res = rtrim($l1, ';')."\n".rtrim($l2, ';')."\n".rtrim($l3, ';');
      file_put_contents("$database/$tab_name.csv", $res, FILE_APPEND);
      write("-> Table '$tab_name' created.");
    }
}