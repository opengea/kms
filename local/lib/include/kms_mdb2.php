<?php

/*
 +-----------------------------------------------------------------------+
 | program/include/rcube_mdb2.inc                                        |
 |                                                                       |
 | This file is part of the RoundCube Webmail client                     |
 | Copyright (C) 2005-2007, RoundCube Dev. - Switzerland                 |
 | Licensed under the GNU GPL                                            |
 |                                                                       |
 | PURPOSE:                                                              |
 |   PEAR:DB wrapper class that implements PEAR MDB2 functions           |
 |   See http://pear.php.net/package/MDB2                                |
 |                                                                       |
 +-----------------------------------------------------------------------+
 | Author: Lukas Kahwe Smith <smith@pooteeweet.org>                      |
 +-----------------------------------------------------------------------+

 $Id: rcube_mdb2.inc 850 2007-10-03 00:13:32Z ihug $

*/


/**
 * Obtain the PEAR::DB class that is used for abstraction
 */
require_once('MDB2.php');


/**
 * Database independent query interface
 *
 * This is a wrapper for the PEAR::MDB2 class
 *
 * @package    Database
 * @author     David Saez Padros <david@ols.es>
 * @author     Thomas Bruederli <roundcube@gmail.com>
 * @author     Lukas Kahwe Smith <smith@pooteeweet.org>
 * @version    1.16
 * @link       http://pear.php.net/package/MDB2
 */
class rcube_mdb2
  {
  var $db_dsnw;               // DSN for write operations
  var $db_dsnr;               // DSN for read operations
  var $db_connected = false;  // Already connected ?
  var $db_mode = '';          // Connection mode
  var $db_handle = 0;         // Connection handle
  var $db_error = false;
  var $db_error_msg = '';

  var $a_query_results = array('dummy');
  var $last_res_id = 0;


  /**
   * Object constructor
   *
   * @param  string  DSN for read/write operations
   * @param  string  Optional DSN for read only operations
   */
  function __construct($db_dsnw, $db_dsnr='', $pconn=false)
    {
    if ($db_dsnr=='')
      $db_dsnr=$db_dsnw;

    $this->db_dsnw = $db_dsnw;
    $this->db_dsnr = $db_dsnr;
    $this->db_pconn = $pconn;
    
    $dsn_array = MDB2::parseDSN($db_dsnw);
    $this->db_provider = $dsn_array['phptype'];
    }


  /**
   * PHP 4 object constructor
   *
   * @see  rcube_mdb2::__construct
   */
  function rcube_db($db_dsnw,$db_dsnr='')
    {
    $this->__construct($db_dsnw,$db_dsnr);
    }


  /**
   * Connect to specific database
   *
   * @param  string  DSN for DB connections
   * @return object  PEAR database handle
   * @access private
   */
  function dsn_connect($dsn)
    {
    // Use persistent connections if available
    $dbh = MDB2::connect($dsn, array('persistent' => $this->db_pconn, 'portability' => MDB2_PORTABILITY_ALL ^ MDB2_PORTABILITY_EMPTY_TO_NULL));

    if (PEAR::isError($dbh))
      {
      $this->db_error = TRUE;
      $this->db_error_msg = $dbh->getMessage();
      
      raise_error(array('code' => 500, 'type' => 'db', 'line' => __LINE__, 'file' => __FILE__,
                        'message' => $dbh->getMessage()), TRUE, FALSE);
      }
    else if ($this->db_provider=='sqlite')
      {
      $dsn_array = MDB2::parseDSN($dsn);
      if (!filesize($dsn_array['database']) && !empty($this->sqlite_initials))
        $this->_sqlite_create_database($dbh, $this->sqlite_initials);
      }
    else
      $dbh->setCharset('utf8');

    return $dbh;
    }


  /**
   * Connect to appropiate databse
   * depending on the operation
   *
   * @param  string  Connection mode (r|w)
   * @access public
   */
  function db_connect($mode)
    {
    $this->db_mode = $mode;

    // Already connected
    if ($this->db_connected)
      {
      // no replication, current connection is ok
      if ($this->db_dsnw==$this->db_dsnr)
        return;

      // connected to master, current connection is ok
      if ($this->db_mode=='w')
        return;

      // Same mode, current connection is ok
      if ($this->db_mode==$mode)
        return;
      }

    if ($mode=='r')
      $dsn = $this->db_dsnr;
    else
      $dsn = $this->db_dsnw;

    $this->db_handle = $this->dsn_connect($dsn);
    $this->db_connected = true;
    }


    
  /**
   * Getter for error state
   *
   * @param  boolean  True on error
   */
  function is_error()
    {
    return $this->db_error ? $this->db_error_msg : FALSE;
    }
    

  /**
   * Execute a SQL query
   *
   * @param  string  SQL query to execute
   * @param  mixed   Values to be inserted in query
   * @return number  Query handle identifier
   * @access public
   */
  function query()
    {
    $params = func_get_args();
    $query = array_shift($params);

    return $this->_query($query, 0, 0, $params);
    }


  /**
   * Execute a SQL query with limits
   *
   * @param  string  SQL query to execute
   * @param  number  Offset for LIMIT statement
   * @param  number  Number of rows for LIMIT statement
   * @param  mixed   Values to be inserted in query
   * @return number  Query handle identifier
   * @access public
   */
  function limitquery()
    {
    $params = func_get_args();
    $query = array_shift($params);
    $offset = array_shift($params);
    $numrows = array_shift($params);

    return $this->_query($query, $offset, $numrows, $params);
    }


  /**
   * Execute a SQL query with limits
   *
   * @param  string  SQL query to execute
   * @param  number  Offset for LIMIT statement
   * @param  number  Number of rows for LIMIT statement
   * @param  array   Values to be inserted in query
   * @return number  Query handle identifier
   * @access private
   */
  function _query($query, $offset, $numrows, $params)
    {
    // Read or write ?
    if (strtolower(trim(substr($query,0,6)))=='select')
      $mode='r';
    else
      $mode='w';

    $this->db_connect($mode);

    if ($this->db_provider == 'sqlite')
      $this->_sqlite_prepare();

    if ($numrows || $offset)
      $result = $this->db_handle->setLimit($numrows,$offset);

    if (empty($params))
        $result = $this->db_handle->query($query);
    else
      {
      $params = (array)$params;
      $q = $this->db_handle->prepare($query);
      if ($this->db_handle->isError($q))
        {
        $this->db_error = TRUE;
        $this->db_error_msg = $q->userinfo;

        raise_error(array('code' => 500, 'type' => 'db', 'line' => __LINE__, 'file' => __FILE__,
                          'message' => $this->db_error_msg), TRUE, TRUE);
        }
      else
        {
        $result = $q->execute($params);
        $q->free();
        }
      }

    // add result, even if it's an error
    return $this->_add_result($result);
    }


  /**
   * Get number of rows for a SQL query
   * If no query handle is specified, the last query will be taken as reference
   *
   * @param  number  Optional query handle identifier
   * @return mixed   Number of rows or FALSE on failure
   * @access public
   */
  function num_rows($res_id=NULL)
    {
    if (!$this->db_handle)
      return FALSE;

    if ($result = $this->_get_result($res_id))
      return $result->numRows();
    else
      return FALSE;
    }


  /**
   * Get number of affected rows fort he last query
   *
   * @return mixed   Number of rows or FALSE on failure
   * @access public
   */
  function affected_rows($result = null)
    {
    if (!$this->db_handle)
      return FALSE;

    return $this->_get_result($result);
    }


  /**
   * Get last inserted record ID
   * For Postgres databases, a sequence name is required
   *
   * @param  string  Sequence name for increment
   * @return mixed   ID or FALSE on failure
   * @access public
   */
  function insert_id($sequence = '')
    {
    if (!$this->db_handle || $this->db_mode=='r')
      return FALSE;

    return $this->db_handle->lastInsertID($sequence);
    }


  /**
   * Get an associative array for one row
   * If no query handle is specified, the last query will be taken as reference
   *
   * @param  number  Optional query handle identifier
   * @return mixed   Array with col values or FALSE on failure
   * @access public
   */
  function fetch_assoc($res_id=NULL)
    {
    $result = $this->_get_result($res_id);
    return $this->_fetch_row($result, MDB2_FETCHMODE_ASSOC);
    }


  /**
   * Get an index array for one row
   * If no query handle is specified, the last query will be taken as reference
   *
   * @param  number  Optional query handle identifier
   * @return mixed   Array with col values or FALSE on failure
   * @access public
   */
  function fetch_array($res_id=NULL)
    {
    $result = $this->_get_result($res_id);
    return $this->_fetch_row($result, MDB2_FETCHMODE_ORDERED);
    }


  /**
   * Get co values for a result row
   *
   * @param  object  Query result handle
   * @param  number  Fetch mode identifier
   * @return mixed   Array with col values or FALSE on failure
   * @access private
   */
  function _fetch_row($result, $mode)
    {
    if (PEAR::isError($result))
      {
      raise_error(array('code' => 500, 'type' => 'db', 'line' => __LINE__, 'file' => __FILE__,
                        'message' => $this->db_link->getMessage()), TRUE, FALSE);
      return FALSE;
      }

    return $result->fetchRow($mode);
    }


  /**
   * Formats input so it can be safely used in a query
   *
   * @param  mixed   Value to quote
   * @return string  Quoted/converted string for use in query
   * @access public
   */
  function quote($input, $type = null)
    {
    // create DB handle if not available
    if (!$this->db_handle)
      $this->db_connect('r');

    // escape pear identifier chars
    $rep_chars = array('?' => '\?',
                       '!' => '\!',
                       '&' => '\&');

    return $this->db_handle->quote($input, $type);
    }


  /**
   * Quotes a string so it can be safely used as a table or column name
   *
   * @param  string  Value to quote
   * @return string  Quoted string for use in query
   * @deprecated     Replaced by rcube_MDB2::quote_identifier
   * @see            rcube_MDB2::quote_identifier
   * @access public
   */
  function quoteIdentifier($str)
	{
    return $this->quote_identifier($str);
	}


  /**
   * Quotes a string so it can be safely used as a table or column name
   *
   * @param  string  Value to quote
   * @return string  Quoted string for use in query
   * @access public
   */
  function quote_identifier($str)
    {
    if (!$this->db_handle)
      $this->db_connect('r');

    return $this->db_handle->quoteIdentifier($str);
    }


  /**
   * Return SQL function for current time and date
   *
   * @return string SQL function to use in query
   * @access public
   */
  function now()
    {
    switch($this->db_provider)
      {
      case 'mssql':
        return "getdate()";

      default:
        return "now()";
      }
    }


  /**
   * Return SQL statement to convert a field value into a unix timestamp
   *
   * @param  string  Field name
   * @return string  SQL statement to use in query
   * @access public
   */
  function unixtimestamp($field)
    {
    switch($this->db_provider)
      {
      case 'pgsql':
        return "EXTRACT (EPOCH FROM $field)";
        break;

      case 'mssql':
        return "datediff(s, '1970-01-01 00:00:00', $field)";

      default:
        return "UNIX_TIMESTAMP($field)";
      }
    }


  /**
   * Return SQL statement to convert from a unix timestamp
   *
   * @param  string  Field name
   * @return string  SQL statement to use in query
   * @access public
   */
  function fromunixtime($timestamp)
    {
    switch($this->db_provider)
      {
      case 'mysqli':
      case 'mysql':
      case 'sqlite':
        return "FROM_UNIXTIME($timestamp)";

      default:
        return date("'Y-m-d H:i:s'", $timestamp);
      }
    }


  /**
   * Adds a query result and returns a handle ID
   *
   * @param  object  Query handle
   * @return mixed   Handle ID or FALE on failure
   * @access private
   */
  function _add_result($res)
    {
    // sql error occured
    if (PEAR::isError($res))
      {
      raise_error(array('code' => 500, 'type' => 'db', 'line' => __LINE__, 'file' => __FILE__,
                        'message' => $res->getMessage() . " Query: " . substr(preg_replace('/[\r\n]+\s*/', ' ', $res->userinfo), 0, 512)), TRUE, FALSE);
      return FALSE;
      }
    else
      {
      $res_id = sizeof($this->a_query_results);
      $this->a_query_results[$res_id] = $res;
      $this->last_res_id = $res_id;
      return $res_id;
      }
    }


  /**
   * Resolves a given handle ID and returns the according query handle
   * If no ID is specified, the last ressource handle will be returned
   *
   * @param  number  Handle ID
   * @return mixed   Ressource handle or FALE on failure
   * @access private
   */
  function _get_result($res_id=NULL)
    {
    if ($res_id==NULL)
      $res_id = $this->last_res_id;

     if ($res_id && isset($this->a_query_results[$res_id]))
       return $this->a_query_results[$res_id];
     else
       return FALSE;
    }


  /**
   * Create a sqlite database from a file
   *
   * @param  object  SQLite database handle
   * @param  string  File path to use for DB creation
   * @access private
   */
  function _sqlite_create_database($dbh, $file_name)
    {
    if (empty($file_name) || !is_string($file_name))
      return;

    $data = '';
    if ($fd = fopen($file_name, 'r'))
      {
      $data = fread($fd, filesize($file_name));
      fclose($fd);
      }

    if (strlen($data))
      sqlite_exec($dbh->connection, $data);
    }


  /**
   * Add some proprietary database functions to the current SQLite handle
   * in order to make it MySQL compatible
   *
   * @access private
   */
  function _sqlite_prepare()
    {
    include_once('include/rcube_sqlite.inc');

    // we emulate via callback some missing MySQL function
    sqlite_create_function($this->db_handle->connection, "from_unixtime", "rcube_sqlite_from_unixtime");
    sqlite_create_function($this->db_handle->connection, "unix_timestamp", "rcube_sqlite_unix_timestamp");
    sqlite_create_function($this->db_handle->connection, "now", "rcube_sqlite_now");
    sqlite_create_function($this->db_handle->connection, "md5", "rcube_sqlite_md5");
    }


  }  // end class rcube_db

?>
