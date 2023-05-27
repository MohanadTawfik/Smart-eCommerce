<?php

/** 
 * Title Function V1.0
 *** this function echo the page title in case the page 
 *** has th variable $pageTitle and echo default title for other pages 
 */

function getTitle()
{
  global $pageTitle;
  if (isset($pageTitle)) {
    echo $pageTitle . " | المتجر الذكي ";
  } else {
    echo " المتجر الذكي ";
  }
}


/**
 * Get items Function V1.0
 *** function to get fields from database
 */

function get_from_table($field, $table, $where = NULL, $and = NULL, $orderField, $ordering = "ASC", $limit = NULL)
{
  global $con;
  $stmt = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderField $ordering  $limit");
  $stmt->execute();
  $items =  $stmt->fetchAll();
  return $items;
}

/**
 * Get items Function V1.0
 *** function to get fields from database
 */

function count_from_table($field, $table, $where = NULL, $and = NULL, $limit = NULL)
{
  global $con;
  $stmt = $con->prepare("SELECT $field FROM $table $where $and $limit");
  $stmt->execute();
  $items =  $stmt->rowCount();
  return $items;
}

/**
 * Get items Function V1.0
 *** function to get fields from database
 */

function count_fields($field, $table, $where = NULL, $and = NULL, $order =  NULL, $limit = NULL)
{
  global $con;
  $stmt = $con->prepare("SELECT $field FROM $table $where $and $order $limit");
  $stmt->execute();
  $items =  $stmt->rowCount();
  return $items;
}

/** 
 * Redirect Home function V2.0
 *** this function redirect to page [parameters function]
 *** $theMsg = echo the message [ error | success] 
 *** $url = the link you want to redirect  
 *** $seconds = seconds before redirecting 
 */

function redirectHome($state, $theMsg, $url = null, $seconds = 2)
{
  if ($url === null) {
    $url = "index.php";
  }
  $_SESSION['state'] = $state;
  $_SESSION['massage'] = $theMsg;
  header("refresh:$seconds;url=$url");
  // exit();
}


/**
 * Check Items Function V1.0
 *** function to items in database [parameters function]
 *** $select = the item to select [ex: users , items , catagories]
 *** $form = the table to select from  [ex: users , items , catagories]
 *** $value = the value of select 
 */

function checkItem($select, $from, $value)
{
  global $con;
  $statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");
  $statement->execute(array($value));
  $count = $statement->rowCount();

  return $count;
}


/**
 * count Items Function V1.0
 *** function to count number of items rows
 *** $item = the item to count
 *** $table = the tale to choose from 
 */

function countItems($item, $table)
{
  global $con;
  $statement = $con->prepare("SELECT COUNT($item) FROM $table");
  $statement->execute();

  echo $statement->fetchColumn();
}


/**
 * Get Latest Records Function V1.0
 *** function to get latest items from database
 *** $select = the item to select 
 *** $form = the table to select from  
 *** $order = the order of select 
 *** $limit = number of records to get 
 */

function getLatest($select, $from, $order, $limit = 5)
{
  global $con;
  $statement = $con->prepare("SELECT $select FROM $from  ORDER BY $order DESC LIMIT $limit");
  $statement->execute();
  $row =  $statement->fetchAll();

  return $row;
}
