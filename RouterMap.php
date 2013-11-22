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
     * Annotations of table is storage here
     * @to_table @of_table and @complement
     *
     * @var array
     */
    private $_tables;

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

            if(! $this->_tables = $this->_getAnnotations()) {
                throw new Exception(
                    'Annotation @to_table and @of_table not found on class <strong>'
                    . get_class($this->_reflectionClass) . '</strong>'
                );
            }

            $fields = $this->_getConstants();

            $fieldToDb = array_values($fields);
            $fieldOfDb = array_keys($fields);
            
            echo $this->_mountSelect($fieldOfDb);

            $dataOf = $this->_ofDb->query(
                $this->_mountSelect($fieldOfDb)
            );

            $insertDDLs = $this->_mountInsert(
                $dataOf->fetchAll(PDO::FETCH_ASSOC),
                $fieldToDb
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
     * Get annotations @to_table and @of_table of class by reflection to determine
     * what is the class to insert and comsumer data. yet get the @complement to be added
     * to query Select
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return array|boolean
     */
    private function _getAnnotations()
    {
        $reflection = new ReflectionClass(get_class($this->_reflectionClass));
        $docBlock = $reflection->getDocComment();

        preg_match('#\@of_table (.+)#', $docBlock, $of_table);
        preg_match('#\@to_table (.+)#', $docBlock, $to_table);
        preg_match('#\@complement (.+)#', $docBlock, $complement);

        $tables['of_table'] = trim($of_table[1]);
        $tables['to_table'] = trim($to_table[1]);
        $tables['complement'] = trim($complement[1]);

        if ($tables['of_table'] && $tables['to_table'])
            return $tables;

        return false;
    }

    /**
     * Create the structions for all inserts
     *
     * @param array $of
     * @param string $to
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
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
        echo $query. '<br />';
        return  $query;
    }

    /**
     * Mount SELECT query statement
     *
     * @param array $fields
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @return string
     */
    private function _mountSelect(array $fields)
    {
        return $query = 'SELECT '. implode(', ', $fields) 
        . ' FROM '. $this->_tables['of_table'] ." {$this->_tables['complement']}";
    }
}