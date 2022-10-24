<?php
namespace App\Modules;

use PDO;
/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @author DataTables - https://github.com/DataTables/DataTables
 * @mod Zercle Technology - https://github.com/zercle/datatables-ssp
 *
 * @license MIT - http://datatables.net/license_mit
 */

class DataTableSSP
{
    private static $DEBUG = false;

    /**
     * Create the data output array for the DataTables rows
     *
     * @param  array $columns Column information array
     * @param  array $data Data from the SQL get
     * @return array          Formatted data in a row based format
     */
    static function data_output($columns, $data)
    {
        $out = array();

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    $row[$column['dt']] = empty($columns[$j]['as']) ? $column['formatter']($data[$i][$column['db']], $data[$i]) : $column['formatter']($data[$i][$column['as']], $data[$i]);
                } else {
                    $row[$column['dt']] = empty($columns[$j]['as']) ? $data[$i][$columns[$j]['db']] : $data[$i][$columns[$j]['as']];
                }
            }

            $out[] = $row;
        }

        return $out;
    }


    /**
     * Database connection
     *
     * Obtain an PHP PDO connection from a connection details array
     *
     * @param  array|PDO $conn SQL connection details. The array should have
     *    the following properties
     *     * host - host name
     *     * db   - database name
     *     * user - user name
     *     * pass - user password
     * @return PDO connection
     */
    static function db($conn)
    {
        if (is_array($conn)) {
            return self::sql_connect($conn);
        }

        return $conn;
    }


    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @return string SQL limit clause
     */
    static function limit($request)
    {
        $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }

        return $limit;
    }


    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @return string SQL order by clause
     */
    static function order($request, $columns, $extraOrder = null)
    {
        $order = '';

        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = $column['db'] . ' ' . $dir;
                }
            }

            $order = 'ORDER BY ' . ($extraOrder ? $extraOrder . ', ':'') . implode(', ', $orderBy);
        }

        return $order;
    }


    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array $columns Column information array
     * @param  array $bindings Array of values for PDO bindings, used in the
     *    sql_exec() function
     * @return string SQL where clause
     */
    static function filter($request, $columns, &$bindings)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $globalSearch[] = $column['db'] . " LIKE " . $binding;
                }
            }
        }

        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                $str = $requestColumn['search']['value'];

                if ($requestColumn['searchable'] == 'true' &&
                    $str != '') {
                    $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                    $columnSearch[] = $column['db'] . " LIKE " . $binding;
                }
            }
        }

        // Combine the filters into a single string
        $where = '';

        if (count($globalSearch)) {
            $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $where = $where === '' ?
                implode(' AND ', $columnSearch) :
                $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        if ($where !== '') {
            $where = 'WHERE ' . $where;
        }

        return $where;
    }


    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array|PDO $conn PDO connection resource or connection parameters array
     * @param  string $table SQL table to query
     * @param  string $primaryKey Primary key of the table
     * @param  array $columns Column information array
     * @return array          Server-side processing response array
     */
    static function simple($request, $conn, $table, $primaryKey, $columns)
    {
        $bindings = array();
        $db = self::db($conn);

        // Build the SQL query string from the request
        $limit = self::limit($request);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);

        // Main query to actually get the data
        $sqlString = "SELECT ";
        $sqlString .= implode(", ", self::pluck($columns, 'db')) . " ";
        $sqlString .= "FROM $table ";
        $sqlString .= $where . " ";
        $sqlString .= $order . " ";
        $sqlString .= $limit . " ";
        $data = self::sql_exec($db, $bindings, $sqlString);

        // Data set length after filtering
        $sqlString = "SELECT ";
        $sqlString .= "COUNT($primaryKey) ";
        $sqlString .= "FROM $table ";
        $sqlString .= $where;
        $resFilterLength = self::sql_exec($db, $bindings, $sqlString);
        $recordsFiltered = $resFilterLength[0][0];

        // Total data set length
        $sqlString = "SELECT ";
        $sqlString .= "COUNT($primaryKey) ";
        $sqlString .= "FROM $table ";
        $resTotalLength = self::sql_exec($db, $sqlString);
        $recordsTotal = $resTotalLength[0][0];

        /*
         * Output
         */
        return array(
            "draw" => isset ($request['draw']) ?
                intval($request['draw']) :
                0,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => self::data_output($columns, $data)
        );
    }


    /**
     * The difference between this method and the `simple` one, is that you can
     * apply additional `where` conditions to the SQL queries. These can be in
     * one of two forms:
     *
     * * 'Result condition' - This is applied to the result set, but not the
     *   overall paging information query - i.e. it will not effect the number
     *   of records that a user sees they can have access to. This should be
     *   used when you want apply a filtering condition that the user has sent.
     * * 'All condition' - This is applied to all queries that are made and
     *   reduces the number of records that the user can access. This should be
     *   used in conditions where you don't want the user to ever have access to
     *   particular records (for example, restricting by a login id).
     *
     * @param  array $request Data sent to server by DataTables
     * @param  array|PDO $conn PDO connection resource or connection parameters array
     * @param  array|string $table SQL table to query
     * @param  string $primaryKey Primary key of the table
     * @param  array $columns Column information array
     * @param  string $whereResult WHERE condition to apply to the result set
     * @param  string $whereAll WHERE condition to apply to all queries
     * @param  string $groupBy Group by condition to apply to all queries
     * @param  string $orderBy Order by condition to apply to all queries
     * @param  bool $debug Debug SQL query when error
     *
     * @return array Server-side processing response array
     */
    static function complex($request, $conn, $table, $primaryKey, $columns, $whereResult = null, $whereAll = null, $groupBy = null, $orderBy = null, $debug = false)
    {
        $bindings = array();
        $db = self::db($conn);
        self::$DEBUG = $debug;
        $whereAllSql = '';

        // Build the SQL query string from the request
        $limit = self::limit($request);
        $where = self::filter($request, $columns, $bindings);

        // temp orderBY
        $temp_orderBy = '';
        if (!empty($orderBy)) {
          $temp_orderBy = self::_flatten($orderBy, ', ');
        }
        // order
        $order = self::order($request, $columns, $temp_orderBy);

        $whereResult = self::_flatten($whereResult);
        $whereAll = self::_flatten($whereAll);
        $groupBy = self::_flatten($groupBy, ', ');
        $table = self::_flatten($table, ' ');

        if ($whereResult) {
            $where = $where ?
                $where . ' AND ' . $whereResult :
                'WHERE ' . $whereResult;
        }

        if ($whereAll) {
            $where = $where ?
                $where . ' AND ' . $whereAll :
                'WHERE ' . $whereAll;

            $whereAllSql = 'WHERE ' . $whereAll;
        }

        if ($groupBy) {
            $groupBy = empty($groupBy) ? null : 'GROUP BY ' . $groupBy;
        }

        // Main query to actually get the data
        $sqlString = "SELECT " . implode(", ", self::pluckSelect($columns, 'db')) . " ";
        // debug true
        if ($debug) $sqlString = "SELECT * ";
        $sqlString .= "FROM " . $table . " ";
        $sqlString .= $where . " ";
        $sqlString .= empty($groupBy) ? '' : $groupBy . " ";
        $sqlString .= $order . " ";
        $sqlString .= $limit . " ";
        $data = self::sql_exec($db, $bindings, $sqlString);

        // Data set length after filtering
        $resFilterLength = self::sql_exec($db, $bindings,
            "SELECT COUNT(" . $primaryKey . ") FROM " . $table . " " . $where . " " . (empty($groupBy) ? '' : $groupBy . " ")
        );
        $recordsFiltered = $resFilterLength[0][0];
        if($resFilterLength && count($resFilterLength) > 1) {
          $recordsFiltered = count($resFilterLength);
        }

        // Total data set length
        $resTotalLength = self::sql_exec($db, $bindings,
            "SELECT COUNT(" . $primaryKey . ") FROM " . $table . " " . $whereAllSql . " " . (empty($groupBy) ? '' : $groupBy . " ")
        );
        $recordsTotal = $resTotalLength[0][0];
        if($resTotalLength && count($resTotalLength) > 1) {
          $recordsTotal = count($resTotalLength);
        }

        /*
         * Output
         */
        return array(
            "draw" => isset ($request['draw']) ?
                intval($request['draw']) :
                0,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => self::data_output($columns, $data)
        );
    }


    /**
     * Connect to the database
     *
     * @param  array $sql_details SQL server connection details array, with the
     *   properties:
     *     * host - host name
     *     * db   - database name
     *     * user - user name
     *     * pass - user password
     * @return PDO Database connection handle
     */
    static function sql_connect($sql_details)
    {
      /*
        try {
            return @new PDO(
                "mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
                $sql_details['user'],
                $sql_details['pass'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            self::fatal(
                "An error occurred while connecting to the database. " .
                "The error reported by the server was: " . $e->getMessage()
            );
        }
        */
    }


    /**
     * Execute an SQL query on the database
     *
     * @param  PDO $db Database handler
     * @param  array|string $bindings Array of PDO binding values from bind() to be
     *   used for safely escaping strings. Note that this can be given as the
     *   SQL query string if no bindings are required.
     * @param  string $sql SQL query to execute.
     * @return array         Result from the query (all rows)
     */
    static function sql_exec($db, $bindings, $sql = null)
    {
        // Argument shifting
        if ($sql === null) {
            $sql = $bindings;
        }

        // Bind parameters
        $sql_value = [];
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $sql_value[] = $bindings[$i]['val'];
                // $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }
        
        if (intval(count($sql_value)) == self::harfSay($sql, '?')) {
          return \Core\Model::query($sql, $sql_value);
        } else {
          return \Core\Model::query($sql, []);
        }
        //
        /*
        $stmt = $db->prepare($sql);
        //echo $sql;

        // Bind parameters
        if (is_array($bindings)) {
            for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
                $binding = $bindings[$i];
                $stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
            }
        }

        // Execute
        try {
            $stmt->execute();
        } catch (PDOException $e) {
            self::fatal(
                "An SQL error occurred: " . $e->getMessage(),
                self::$DEBUG ? $stmt->debugDumpParams() : null
            );
        }

        // Return all
        return $stmt->fetchAll(PDO::FETCH_BOTH);
        */
    }


    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Internal methods
     */

    /**
     * Throw a fatal error.
     *
     * This writes out an error message in a JSON string which DataTables will
     * see and show to the user in the browser.
     *
     * @param  string $msg Message to send to the client
     * @param string $debug
     */
    static function fatal($msg, $debug = null)
    {
        echo json_encode(array(
            "error" => $msg,
            "debug" => $debug
        ));

        exit(1);
    }

    static function harfSay($kelime, $harf)
    {
        $kac = 0;
        $say = strlen($kelime);
        for ($n=0; $n < $say; $n++) {
            if ($kelime[$n] == $harf) {
                $kac++;
            }
        }
        return $kac;
    }

    /**
     * Create a PDO binding key which can be used for escaping variables safely
     * when executing a query with sql_exec()
     *
     * @param  array &$a Array of bindings
     * @param  *      $val  Value to bind
     * @param  int $type PDO field type
     * @return string       Bound key to be used in the SQL where this parameter
     *   would be used.
     */
    static function bind(&$a, $val, $type)
    {
        // $key = ':binding_' . count($a);
        $key = '= ?';
        if (strpos($val,"%") !== false) {
          $key = '?';
        }
        $a[] = array(
            'key' => $key,
            'val' => $val,
            'type' => $type
        );

        return $key;
    }


    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param  array $a Array to get data from
     * @param  string $prop Property to read
     * @return array        Array of property values
     */
    static function pluck($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            $out[] = $a[$i][$prop];
        }

        return $out;
    }

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     * @param  array $a Array to get data from
     * @param  string $prop Property to read
     *
     * @return array        Array of property values
     */
    static function pluckSelect($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
           $out[] = empty($a[$i]['as']) ? $a[$i][$prop] : $a[$i][$prop] . ' AS ' . $a[$i]['as'];
        }

        return $out;
    }

    /**
     * Return a string from an array or a string
     *
     * @param  array|string $a Array to join
     * @param  string $join Glue for the concatenation
     * @return string Joined string
     */
    static function _flatten($a, $join = ' AND ')
    {
        if (!$a) {
            return '';
        } else if ($a && is_array($a)) {
            return implode($join, $a);
        }
        return $a;
    }
}
