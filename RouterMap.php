<?php
/**
 * RouterMap can create a relational map by Enum Classes
 * and migrate datas by associative tables.
 * 
 * @category Migration
 * @package  MigrationDB
 * @author   Jefersson Nathan <jeferssonn@alfamaweb.com.br>
 * @version  $Id$
 */
class RouterMap
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
     * Persist the class passed on instanciate this class to be reflected after  
     *
     * @param EnumTablesRelation $relationMapper
     * @return object RelationMap
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     */
    public function __construct(EnumTablesRelation $relationMapper)
    {
        $this->_reflectionClass = $relationMapper;
        return $this;
    }

    /**
     * Storage 2 conections internaly on class to be used in other methods and
     * places if necessary. It should be a instance of PDO, this way is more
     * simple to manage the API of differents databasse. So, a facade is not
     * required to this work.  
     *
     * @param  \PDO $of
     * @param  \PDO $to
     *
     * @return object RelationMap
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
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
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return object \RouterMap 
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
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return null
     */
    public function mapperDatas($uniqueID)
    {
        $this->_id = $uniqueID;
        
        try{
            
            if (! $this->_isPropertiesOk()) {
                throw new Exception('Please! Look your properties for class '.__CLASS__);
            }

            $fields = $this->_getConstants();

            $fieldToDb = array_values($fields);
            $fieldOfDb = array_keys($fields);

            $dataOf = $this->_ofDb->query(
                $this->_mountSelect($fieldOfDb, $fields['OF_TABLE'])
            );

            $insertDDLs = $this->_mountInsert(
                $dataOf->fetchAll(PDO::FETCH_ASSOC),
                $fieldToDb,
                $fields['TO_TABLE']
            );

            $this->_toDb->exec($insertDDLs);

        } catch (Exception $error) {
            echo '<br /><strong>Error:</strong> '. $error->getMessage();
            exit;
        }
    }


    /**
     * Check if relevant properties are serted
     * less it, the functionality of class is wront
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
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
     * Get constants of class storaged on RouterMap::_reflectionClass by 
     * reflection
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return array
     */
    private function _getConstants()
    {
        $reflection = new ReflectionClass(get_class($this->_reflectionClass));
        return $reflection->getConstants();
    }

    /**
     * Create the structions for all inserts
     *
     * @param array $of
     * @param string $to
     * @param string $tableName
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return string
     */
    private function _mountInsert(array $of, $to, $tableName)
    {
        $query = 'INSERT INTO '.$tableName;
        
        array_shift($to);
        array_shift($to);

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
        echo $query. '<br />';
        return  $query;
    }

    /**
     * Mount SELECT query statement
     *
     * @param array $fields
     * @param mixed $table
     * @param mixed $complement
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return string
     */
    private function _mountSelect(array $fields, $table, $complement = null)
    {
        unset($fields['0']);
        unset($fields['1']);
        return $query = 'SELECT '. implode(', ', $fields) 
        . ' FROM '. $table ." $complement";
    }
}