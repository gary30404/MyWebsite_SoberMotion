<?php

// utility functions for database
// be sure mysql is connected before using

// notice the SQL injection
function getTableData($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `Timestamp` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["Timestamp"]] = $row;
   return $data;
}

function getTableData_date($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `createTime` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
//      $_D= date("Y/m/d");
      $data[date("Y/m/d",$row["createTime"]/1000)][$row["createTime"]] = $row;
   return $data;
}

function getTableData_detection_date($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `Timestamp` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
   $data[$row["Date"]][$row["Timestamp"]] = $row;
   return $data;
}
function getTableData_TriggerItems($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `Items` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["Items"]][$row["Timestamp"]] = $row;
   return $data;
}
function getTableData_Item($userId, $item){
   $query = "SELECT * FROM `EventLog` WHERE `UserId` = '$userId' AND `item` = '$item' ORDER BY `createTime` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["createTime"]] = $row;
   return $data;
}

function getTableData_Reflection($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `Timestamp` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["RelationKey"]][$row["Timestamp"]]= $row;
   return $data;
}
function getTableData_RelationKey($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `RelationKey` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["RelationKey"]]= $row;
   return $data;
}

function getTableData_comments($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `id` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["id"]] = $row;
   return $data;
}
function getTableData_comments_week($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `EndWeek` ASC LIMIT 0,1";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data = $row;
   return $data;
}
function getTableData_EventLog($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `createTime` ASC, `id` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["createTime"]] = $row;
   return $data;
}
function getTableData_EventLog_Items($userId, $table_name){
   $query = "SELECT * FROM $table_name WHERE `UserId` = '$userId' ORDER BY `item` ASC";
   $result = mysql_query($query);
   $data = array();
   while($row = mysql_fetch_assoc($result))
      $data[$row["item"]] [$row["createTime"]] = $row;
   return $data;
}
?>
