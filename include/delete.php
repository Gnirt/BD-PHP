<?php
// delete.php for bdphp in /Users/philippe/dev/svn/BDPHP/olivie_c
// 
// Made by Philippe TRING
// Login   <tring_p@etna-alternance.net>
// 
// Started on  Thu Nov 21 14:53:23 2013 Philippe TRING
// Last update Fri Nov 22 15:08:49 2013 Philippe TRING
//
function func_delete($req)
{
  $req = implode(" ", $req);
  $regex = '/delete from (\w+) where (.*?)\s*(?=or (.+)|$)/';
  if (!preg_match($regex, $req, $match))
    write('Error in delete syntax !');
  else if (isset($match[3]))
    delete_column($match[1], $match[2], $match[3]);
  else
    delete_column($match[1], $match[2]);
}

function delete_column($tab_name, $cond, $or = null, $rows = 0)
{
  $file_content = '';
  if (!$tab_value = get_table_value($tab_name))
    write("Error table '$tab_name' doesn't exists or there's no data");
  else
    {
      $cond = explode(" ", $cond);
      if (!array_key_exists($cond[0], $tab_value))
	write("Error: '$cond[0]' column doesn't exists in '$tab_name'");
      else
	{
	  foreach ($tab_value[$cond[0]] as $i => $v)
	    if (check_cond($v, $cond[1], $cond[2]))
	      unset($tab_value[$cond[0]][$i]);
	  $max_len = max(array_map('count', $tab_value));
	  for ($a = 0; $a < $max_len; $a++)
	    if (isset($tab_value[$cond[0]][$a]))
	      {
		$line = '';
		foreach ($tab_value as $k => $v)
		  $line .= $tab_value[$k][$a].';';
		$file_content .= rtrim($line, ';');
	      }
	    else
	      $rows = $rows + 1;
	  file_rewrite_data($file_content, $tab_name, $rows, $or);
	}
    }
}

function check_cond($l_arg, $op, $r_arg)
{
  switch ($op)
    {
    case "=":
      return ($l_arg == $r_arg) ? true : false;
    case "not":
      return ($l_arg != $r_arg) ? true : false;
    case "<":
      return ($l_arg < $r_arg) ? true : false;
    case ">":
      return ($l_arg > $r_arg) ? true : false;
    case "<=":
      return ($l_arg <= $r_arg) ? true : false;
    case ">=":
      return ($l_arg >= $r_arg) ? true : false;
      //case "like":
      //return ($l_arg < $r_arg) ? true : false;
    default:
      write('Wrong comparison operator');
    }
}
//return an array[column_name][line_nbr]
function get_table_value($tab_name)
{
  if (!table_exists($tab_name))
    return false;
  else
    {
      global $database;
      $res = array();
      $lines = file("$database/$tab_name.csv");
      foreach ($lines as $line_num => $line)
	{
	  if ($line_num == 0)
	    $key = explode(";", rtrim($line));
	  if ($line_num > 2)
	    {
	      $line = explode(';', $line);
	      foreach ($key as $i => $k)
		$res[$k][] = $line[$i];
	    }
	}
    }
  return $res;
}

function file_rewrite_data($data, $tab_name, $rows, $or)
{
  global $database;
  $file = "$database/$tab_name.csv";
  $lines = file($file);
  $default_tab = $lines[0].$lines[1].$lines[2];
  if (!empty($data))
    {
      file_put_contents($file, $default_tab);
      file_put_contents($file, $data, FILE_APPEND);
    }
  if (isset($or))
    delete_column($tab_name, $or, null, $rows);
  else
    write("-> $rows row(s) deleted.");
}