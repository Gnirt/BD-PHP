<?php
// insert.php for bdphp insert in /Users/Gato/Documents/ETNA/projets/BDPHP_Nov_2013/olivie_c
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Tue Nov 19 13:38:39 2013 OLIVIER Cedric
// Last update Fri Nov 22 18:21:25 2013 OLIVIER Cedric
//
function func_insert($arr)
{
  $arr = implode(" ", $arr);
  if (!preg_match_all("/insert (\w+)\s*\((.+)\)\s*/", $arr, $match))
    write("error syntax for insert");
  else
    {
      $table_name = $match[1][0];
      if(table_exists($table_name))
	insert_data($table_name, $match[2][0]);
      else
	write("Table $table_name doesn't exists!");
    }
}
function insert_data($t_name, $arr)
{
  global $database;
  $p_table = get_format_table($t_name);
  $arr = explode(",", $arr);
  $arr = get_insert_tab($arr, $p_table);
  if (is_array($arr))
    {
      $str = "\n";
       foreach ($p_table as $col)
	{
	  $see = false;
	  foreach ($arr as $key => $value)
	    {
	      if ($col['var'] == $key)
		{
		  $str .= "$value;";
		  $see = true;
		}
	    }
	  if (!$see)
	    $str .= "null;";
	}
      $str = substr($str,0, -1);
      $handle = fopen("$database/".$t_name.".csv", "a+");
      fwrite($handle, $str);
      fclose($handle);
      write("-> Insert done.");
    }
}
function get_insert_tab($arr, $p_table)
{
  $tmp = array();
  for ($i = 0;  $i < count($arr) ; $i++)
    {
      $tab = explode("=", $arr[$i]);
      if (isset($tab[0]) && isset($tab[1]))
	{
	  $key =  preg_replace('/\s+/', ' ', strtolower(trim($tab[0])));
	  $data =  preg_replace('/\s+/', ' ', strtolower(trim($tab[1])));
	  if ($data == "")
	    {
	      write("Error: Syntaxe error doesn't have value at '$key'");
	      return false;
	    }
	  else
	    $tmp[$key] = $data;
	}
	else
	{
	  $err = preg_replace('/\s+/', ' ', strtolower(trim($arr[$i])));
	  write("Error: Syntaxe error '" . $err . "'");
	  return false;
	}
    }
  if (check_type_values($tmp, $p_table))
    return $tmp;
  else
    return false;
}
function check_type_values($arr, $p_table)
{
  foreach ($arr as $key => $value)
    {
      $see = false;
      for ($i = 0; $i < count($p_table) ; $i++)
	{
	  if ($key == $p_table[$i]['var'])
	    $see = true;
	}
      if (!$see)
	{
	  write("Error: Column name doesn’t exists");
	  return (false);
	}
    }
  if (!check_type($p_table, $arr))
    return false;
  return true;
}
function check_type($p_table, $arr)
{
  foreach ($arr as $key => $value)
    {
      for ($j = 0; $j < count($p_table); $j++)
	{
	  if ($p_table[$j]['var'] == $key &&
	      ($p_table[$j]['type'] != my_get_type($value) &&
	       $p_table[$j]['type'] != 'string'))
	    {
	      write("error: " . $p_table[$j]['var'] . " must be a " . $p_table[$j]['type']);
	      return false;
	    }
	  elseif ($p_table[$j]['var'] == $key)
	    $p_table[$j][0] = 'check';
	}
    }
  for ($i = 0 ; $i < count($p_table); $i++)
    {
      
      if (!isset($p_table[$i][0]) &&
	  ($p_table[$i]['opt'] == 'not_null' ||
	   $p_table[$i]['opt'] == 'primary_key'))
	{
	  write("error: " . $p_table[$i]['var'] . " can't be null");
	  return false;
	}
    }
  return true;
}
function my_get_type($str)
{
  if (is_numeric($str))
    if (preg_match("#[.,]{1}#", $str))
      return "float";
    else
      return "integer";
  else
    if ($str == "true" || $str == "false")
      return "bool";
    else
      return "string";
}