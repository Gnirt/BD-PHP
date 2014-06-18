<?php
// select.php for Select bdphp in /Users/Gato/Documents/ETNA/projets/BDPHP_Nov_2013/olivie_c
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Wed Nov 20 17:33:31 2013 OLIVIER Cedric
// Last update Fri Nov 22 16:18:37 2013 OLIVIER Cedric
//
function func_select($arr)
{
  $col = get_request($arr);
  if ($col)
    $val = get_values($col['table']);
  if ($val)
    {
      format_col_values($col['column'], $val);
      change_colname_to_value($col['condition'], $col['table']);
    }
  //format_cond_value($col['condition'], $val);
  //print_r($val);
}
function change_colname_to_value(&$arr, $tables)
{
  //req les noms de col des tables concerne
  
  if (count($tables) > 1)
    {
      print_r($arr);
      for ($j = 0; $j < count($arr); $j++)
	{
	  for ($i = 0; $i < count($tables); $i++)
	    {
	      if (preg_match("#(?=$tables[$i].(.+))#", $arr[$j][0], $match))
		echo "--|$match|--\n";
	      else
		echo "no match\n";
	    }
	}
    }
}
function format_col_values($col_name, &$val)
{
  foreach ($val as $key => $value)
    {
      $see = false;
      $key = preg_replace('/\s+/', ' ', trim($key));
      foreach ($col_name as $value2)
	if ($value2 == $key)
	  $see = true;
      if (!$see)
	unset($val[$key]);
    }
}
function get_values($tables)
{
  $values = array();
  for ($i = 0 ; $i < count($tables); $i++)
    {
      $tmp = get_table_value($tables[$i]);
      if (!is_array($tmp))
	{
	  write("Error: Table '$tables[$i]' doesn't exist");
	  return false;
	}
       elseif (!empty($tmp))
	 {
	   if (empty($values))
	     $values = $tmp;
	   else
	     $values = array_push($values, $tmp);
	 }
    }
  return $values;
}
function get_request($arr)
{
  $req['column'] = get_column($arr);
  $req['table'] = get_table($arr);
  $req['condition'] = get_condition($arr);
  $check = true;
  foreach ($req as $value)
    if ($value === false)
      $check = false;

  if ($check == false)
    {
      write("Error: You have a syntaxic error");
      return false;
    }
  else
    return $req;
}
function get_condition($arr)
{
  $pos = get_start_pos($arr, "where");
  $exit = false;
  while (!$exit && isset($arr[$pos]))
    {
      if ($arr[$pos] == 'and')
	{
	  $cond[] = $tmp;
	  $tmp = array();
	}
      elseif (isset($arr[$pos + 1]) &&
	      $arr[$pos] . " " . $arr[$pos + 1] == 'order by')
	$exit = true;
      else
	$tmp[] = $arr[$pos];
      $pos++;
    }
  $cond[] = $tmp;
  if (check_condition_sem($cond))
    return $cond;
  else
    return false;
}
function get_start_pos($arr ,$find)
{
  $pos = 0;
  while (isset($arr[$pos]) && $arr[$pos] != "where")
    $pos++;
  if (!isset($arr[$pos]))
      return (0);
  $pos++;
  return ($pos);
}

function check_condition_sem($arr)
{
  for ($i = 0; $i < count($arr); $i++)
    if (count($arr[$i]) != 3)
      return false;
  return true;
}
function get_column($arr)
{
  $pos = 1;
  $tmp = "";
  while (isset($arr[$pos]) && $arr[$pos] != 'from')
    $tmp .= $arr[$pos++];
  if (!isset($arr[$pos]))
    return false;
  $tmp = explode(",", $tmp);
  return $tmp;
}
function get_table($arr)
{
  $pos = 1;
  $tmp = "";
  while (isset($arr[$pos]) && $arr[$pos] != 'from')
    $pos++;
  $pos++;
  while (isset($arr[$pos]) && $arr[$pos] != 'where')
    $tmp .= $arr[$pos++];
  $tmp = explode(",", $tmp);
  foreach ($tmp as $value)
    if ($value == "")
      return false;
  return ($tmp);
}