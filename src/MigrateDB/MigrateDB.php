<?php
namespace MigrateDB;

/**
 * MigrateDB can create a relational map by Enum Classes
 * and migrate datas by associative tables.
 * 
 * @category Migration
 * @package  MigrateDB
 * @author   Jefersson Nathan <malukenho@phpse.net>
 * @license  GPL/2.0+
 * @version  1.0
 */
class MigrateDB
{
    /**
     * Class to be reflected is storage here
     *
     * @var object
     */
    private $_reflectionClass;
    
    /**
     * @var object \FilterParams
     */
    private $_filters;
    
    /**
     * @var object \PDO
     */
    private $_ofDb;
    
    /**
     * @var object \PDO
     */
    private $_toDb;
    
    /**
     * @var string|integer
     */
    private $_id;

    /**
     * Annotations of table is storage here
     * @to_table @of_table and @complement
     *
     * @var array
     */
    private $_tables;


    /**
     * @var EnumTablesRelations
     */
    private $_replyClass;

    /**
     * Storage the Ids of Row modified
     *
     * @var array
     */
    private $_rowsModified = array();

    /**
     * Persist the class passed on instanciate this class to be reflected after  
     *
     * @param EnumTablesRelation $relationMapper
     * @return object MigrateDB
     * @author Jefersson Nathan <malukenho@phpse.net>
     */
    public function __construct(EnumTablesRelation $relationMapper)
    {
        $this->_reflectionClass = $relationMapper;
        return $this;
    }

    /**
     * Reply the content to the class table associated to the class
     *
     * @param EnumTablesRelation $reply
     * @return object MigrateDB
     * @author Jefersson Nathan <malukenho@phpse.net>
     */
    public function replyTo(EnumTablesRelation $reply)
    {
        $this->_replyClass = $reply;
        $this->_tables = $this->_getAnnotations($this->_replyClass);
        return $this;
    }

    /**
     * Associate content, mount and execute query to insert action
     * You can additionality set a function to be called like a callback
     * passing the $this->_rowsModified array like parameter
     *
     * @param  PDOStatement $datas
     * @param  Mixed        $callback
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     */
    public function with(PDOStatement $datas, $callback = null)
    {
        if (! $this->_replyClass) {
            throw new Exception('Please, set the ReplyTo() method!');
            return false;
        }

        $fields = $datas->fetchAll(PDO::FETCH_ASSOC);
        $rules = $this->_getConstants($this->_replyClass);

        foreach ($fields as $collection) {
            foreach ($collection as $column => $value) {
                $hashtableLocation = array_search($column, $rules);

                $result[$hashtableLocation] = $this->_filters->keekFilterParams(
                    $hashtableLocation, 
                    $value,
                    $this->_id
                );
            }

            // Magic filter :3
            while ($key = array_search('filter', $rules)) {
                $result[$key] = $this->_filters->keekFilterParams(
                    $key, 
                    $rules[$key],
                    $this->_id
                );

                unset($rules[$key]);
            }

            $this->_rowsModified[$collection['idreserva']] = $this->_id;

            if(isset($result['0']))
                unset($result['0']);

            $columns = array_keys($result);
            $values = array_values($result);

            $insert = 'INSERT INTO '.$this->_tables['to_table'] . '('.
                implode(', ', $columns) 
            .')  VALUES('.
                implode(', ', $values) 
            .');';
            $this->_toDb->exec($insert);
            
            $this->_id++;
        }


        if (null !== $callback) {
            if (function_exists($callback)) {
                $callback($this->_rowsModified);
            }
        }
    }

    /**
     * Storage 2 conections internaly on class to be used in other methods and
     * places if necessary. It should be a instance of PDO, this way is more
     * simple to manage the API of differents databasse. So, a facade is not
     * required to this work.  
     *
     * @param PDO $of
     * @param PDO $to
     *
     * @return object MigrateDB
     * @author Jefersson Nathan <malukenho@phpse.net>
     */
    public function setConnection(PDO $of, PDO $to)
    {
        $this->_ofDb = $of;
        $this->_toDb = $to;
        return $this;
    }

    /**
     * Register filter to be used in class on mount insert action
     *
     * @param  \FilterParams $filter
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return object \MigrateDB 
     */
    public function registerFilter(FilterParams $filter)
    {
        $this->_filters = $filter;
        return $this;
    }

    /**
     * mapperData call other methods to check if obrigatory data is setter and 
     * raiser a error message if not. Get constants of class, trate this, and 
     * execute query statement.
     *
     * @param  mixed $uniqueID
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return null
     */
    public function mapperDatas($uniqueID)
    {
        $this->_id = $uniqueID;
        
        try{

            if (! $this->_isPropertiesOk()) {
                throw new Exception('Please! Look your properties for class '.__CLASS__);
            }

            if (! $this->_tables = $this->_getAnnotations()) {
                throw new Exception(
                    'Annotation <b>@to_table</b> and <b>@of_table</b> not found on class <strong>'
                    . get_class($this->_reflectionClass) . '</strong>'
                );
            }

            $fields = $this->_getConstants();

            $fieldToDb = array_values($fields);
            $fieldOfDb = array_keys($fields);

            $dataOf = $this->_ofDb->query(
                $this->_mountSelect($fields, $this->_tables['type'])
            );

            if ('select' == $this->_tables['type']
                || 'join' == $this->_tables['type']
            ) {
                return $dataOf;
            }

            $insertDDLs = $this->_mountInsert(
                $dataOf->fetchAll(PDO::FETCH_ASSOC),
                $fieldToDb
            );

            $this->_toDb->exec($insertDDLs);

        } catch (Exception $error) {
            echo '<br /><strong>Error:</strong> '. $error->getMessage();
        }
    }


    /**
     * Check if relevant properties are serted
     * less it, the functionality of class is wront
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return boolean
     */
    private function _isPropertiesOk()
    {
        if ($this->_ofDb && $this->_toDb && $this->_reflectionClass) {
            return true;
        }
        return false;
    }

    /**
     * Get constants of class storaged on MigrateDB::_reflectionClass by 
     * reflection
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return array
     */
    private function _getConstants($class = null)
    {
        if (null !== $class) {
            $reflect = get_class($class);
        } else {
            $reflect = get_class($this->_reflectionClass);
        }
 
        $reflection = new ReflectionClass($reflect);
        return $reflection->getConstants();
    }

    /**
     * Get annotations @to_table and @of_table of class by reflection to determine
     * what is the class to insert and comsumer data. yet get the @complement to be added
     * to query Select and the @type set the typo of action
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return array|boolean
     */
    private function _getAnnotations($class = null)
    {
        $class = isset($class) ? $class : $this->_reflectionClass;

        $reflection = new ReflectionClass(get_class($class)); 
        $docBlock = $reflection->getDocComment();

        preg_match('#\@of_table (.+)#', $docBlock, $of_table);
        preg_match('#\@to_table (.+)#', $docBlock, $to_table);
        preg_match('#\@complement (.+)#', $docBlock, $complement);
        preg_match('#\@type (.+)#', $docBlock, $type);

        $tables['of_table'] = trim($of_table[1]);
        $tables['to_table'] = trim($to_table[1]);
        $tables['complement'] = str_replace('$1', $this->_id, trim($complement[1]));
        $tables['type'] = trim($type[1]);

        if ($tables['of_table'] && $tables['to_table']) {
            return $tables;
        }

        return false;
    }

    /**
     * Create the structions for all inserts
     *
     * @param array $of
     * @param string $to
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return string
     */
    private function _mountInsert(array $of, $to)
    {
        $query = 'INSERT INTO '.$this->_tables['to_table'];
        
        foreach ($of as $fields) {
            $combined = array_combine($to, $fields);

            foreach ($combined as $key => $value) {
                $field[] = $key;
                $datas[] = $this->_filters->keekFilterParams($key, $value, $this->_id);
            }

            $query .= '('.implode(', ', $field).')';
            $query .= ' VALUES('.implode(', ', $datas).')';
            $query = rtrim($query, ', ') . ';';
        }

        return  $query;
    }

    /**
     * Mount SELECT query statement by type passed
     *
     * @param array  $fields
     * @param string $type
     *
     * @author Jefersson Nathan <malukenho@phpse.net>
     * @return string
     */
    private function _mountSelect(array $fields, $type = 'as')
    {
        switch ($type) {
            case 'join':
                foreach ($fields as $as => $columnAndTable) {

                    preg_match('#.+\s+(ON\s+.+)#', $columnAndTable, $joinAvaliable);

                    preg_match('#(.+?\s)#', $columnAndTable, $m);

                    if ($m) {
                        $columnAndTable = $m[0];
                    }

                    $temp = explode('.', $columnAndTable);
                  
                    if (2 != count($temp)) {
                        $temp[] = $this->_tables['of_table'];
                    }
                  
                    $joinRelation[$temp[1]][$as][0] = $temp[0];

                    if ($joinAvaliable) {
                        $joinRelation[$temp[1]][$as][1] = $joinAvaliable[1];
                    } 
                }

                foreach ($joinRelation as $key => $value) {
                    if ($key != $this->_tables['of_table']) {
                        $temp_values = array_values($value);
                        $on = '';

                        if (2 == count($temp_values[0])) {
                            $on = ' ' . $temp_values[0][1];
                        }

                        $join[] = ' INNER JOIN `'.trim($key).'` '.$on;
                    }
                }

                $this->_tables['complement'] = implode(' ', $join) .' '. $this->_tables['complement'];

                unset($temp);
                unset($fields);
                
                foreach ($joinRelation as $table => $columns) {
                    foreach ($columns as $alias => $nameColumn) {

                        $sqlPattern = ('*' == trim($nameColumn[0])) 
                                        ? '`%s`.%s' 
                                        : '`%s`.`%s` AS %s';

                        $temp[] = sprintf(
                            $sqlPattern,
                            trim($table),
                            trim($nameColumn[0]),
                            $alias
                        );
                    }
                }
                
                $fields = $temp;

                break;

            case 'as':
                foreach ($fields as $field => $alias) {
                    $result[] = "`$field` AS `$alias`";
                }
                $fields = $result;
                break;    
        }
       
        return  'SELECT '. implode(', ', $fields) 
            . ' FROM '. $this->_tables['of_table'] 
            ."  {$this->_tables['complement']}";

    }

}
