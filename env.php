<?

/**
 * Файл среды. Содержит базовые функции, которые так или иначе пытаются создать среду системы
 */

mysql_connect("localhost", "root", "");
mysql_select_db("fl_alex");
mysql_query("set names utf8");

/**
 * Запрос в БД
 * @param string $sql
 */
function jj_db_query($sql){
   return mysql_query($sql);
   
}

/**
 * Какая-то функция для записи в лог информации
 * @param string $message
 * @param int $UserId
 * @param int $int
 */
function jj_db_log( $message, $UserId, $int ){
    echo $message;
    exit;
}

/**
 * Эмуляция функция проверки
 * @param type $param
 * @param type $is_code
 * @param type $type
 * @return type
 */
function jj_valid_input($param, $is_code=false, $type='text'){
 if ($type == 'integer') {
  return is_int($param);
 } else {
  return is_string($param);
 }
}

// --------------- Added by Andrey Parsadanian ---------------

function jj_db_get_types($tablename) {
 $sql = "DESCRIBE `".$tablename."`";
 
 $ret = jj_db_query($sql);
 
 $data = jj_db_fetch_all_assoc($ret, 'Field');
 
 return $data;
}

function jj_normalize_types($types) {
 $r = array();
 if (sizeof($types)) {
  $typename_int   = "integer";
  $typename_text  = "text";
  $typename_other = "other";
  
  foreach ($types as $k=>$vs) {
   $v = $vs->Type;
   if (
    (strpos(" ".$v,"int("     )) ||
    (strpos(" ".$v,"long"     )) ||
    (strpos(" ".$v,"bigint"   )) ||
    (strpos(" ".$v,"mediumint")) ||
    (strpos(" ".$v,"smallint" )) ||
    (strpos(" ".$v,"tinyint"  )) ||
    (strpos(" ".$v,"decimal"  )) ||
    (strpos(" ".$v,"float"    )) ||
    (strpos(" ".$v,"double"   )) ||
    (strpos(" ".$v,"real"     )) ||
    (strpos(" ".$v,"bit"      ))
   ) {
    $r[$k] = $typename_int;
   } else if (
    (strpos(" ".$v,"varchar("   )) ||
    (strpos(" ".$v,"char"       )) ||
    (strpos(" ".$v,"text"       )) ||
    (strpos(" ".$v,"tinytext"   )) ||
    (strpos(" ".$v,"mediumtext" )) ||
    (strpos(" ".$v,"longtext"   )) ||
    (strpos(" ".$v,"datetime"   )) ||
    (strpos(" ".$v,"timestamp"  ))
   ) {
    $r[$k] = $typename_text;
   } else {
    $r[$k] = $typename_other;
   }
   
  }
 }
 
 return $r;
}
