<?php
// describe.php for bdphp in /Users/Gato/Documents/ETNA/projets/BDPHP_Nov_2013/olivie_c
// 
// Made by OLIVIER Cedric
// Login   <olivie_c@etna-alternance.net>
// 
// Started on  Mon Nov 18 17:38:39 2013 OLIVIER Cedric
// Last update Thu Nov 21 13:43:09 2013 OLIVIER Cedric
//
function func_desc($table)
{
  
  if (table_exists($table[1]))
    {
      $tab = get_format_table($table);
      write("------- TABLE '$table[1]' -------");
      $max = word_maxsize($tab) + 1;
      for ($i = 0; $i < count($tab); $i++)
	print_desc($tab, $max, $i);
      write("------- TABLE '$table[1]' -------");
    }
  else
    write("Table '$table[1]' doesn't exists");
}
function get_cont_tablefile($table)
{
  //retourne le contenu ligne par ligne sous forme de tableau
  global $database;
  if (is_array($table))
    $path = "$database/$table[1].csv";
  else
    $path = "$database/$table.csv";
  $handle = fopen($path, 'r');
  $contents = fread($handle, filesize($path));
  $line = explode("\n", $contents);
  fclose($handle);
  return ($line);
}
function get_format_table($table)
{
  $line = get_cont_tablefile($table);
  $tab = array();
  for ($i = 0 ; $i < 3 ; $i++)
    {
      $tmp = explode(";", $line[$i]);
      if ($i == 0)
	$name = 'var';
      elseif ($i == 1)
	$name = 'type';
      elseif ($i == 2)
	$name = 'opt';
      for ($j = 0 ; $j < count($tmp) ; $j++ )
	$tab[$j][$name] = $tmp[$j];
    }
  return $tab;
}
function print_desc($tab, $max, $i)
{
  $str = "";
  foreach ($tab[$i] as $key => $value)
    {
      if ($key == 'var')
	$str .= "'" . $tab[$i][$key] . "'";
      elseif ($key == 'opt')
	$str .= strtoupper($tab[$i][$key]);
      else
	$str .= $tab[$i][$key];
      if (strlen($tab[$i][$key]) < $max)
	$str = add_space($str, ($max - strlen($tab[$i][$key])) );
    }
  write($str);
}
function get_data_table($table)
{
  $f_table = get_format_table($table);
  $cont = get_cont_tablefile($table);
  $arr = array();
  for ($i = 4 ; $i < count($cont) ; $i++)
    {
      $tmp = explode(";", $cont[$i]);
      for ($j = 0; $j < count($tmp); $j++)
	echo "j = $j | i = $i | arr[" . $f_table[$j] . "] = tmp[j] = " . $tmp[$j] . "\n";
    }
}
function add_space($str, $nb)
{
  for ($i = 0; $i < $nb; $i++)
    $str .= ' ';
  return $str;
}
function word_maxsize($tab)
{
  $max = 0;
  for ($i = 0; $i < count($tab) ; $i++)
    {
      foreach ($tab[$i] as $value)
	if (strlen($value) > $max)
	  $max = strlen($value);
    }
  return $max;
}