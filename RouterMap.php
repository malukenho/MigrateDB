<?php
/**
 * undocumented class
 *
 * @package default
 * @author 
 */
class RouterMap
{
    /**
     * Class to be reflected is storage here
     *
     * @var object
     */
    private $reflectionClass;
    
    private $filters;
    private $ofDb;
    private $toDb;
    private $id;

    public function __construct(EnumTablesRelation $relationMapper)
    {
        $this->reflectionClass = $relationMapper;
        return $this;
    }

    public function setConnection(PDO $of, PDO $to)
    {
        $this->ofDb = $of;
        $this->toDb = $to;

        return $this;
    }

    /**
     * Register filter to be used in class on mount insert action
     *
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     * @param  \FilterParams $filter
     * @return object RouterMap 
     */
    public function registerFilter(FilterParams $filter)
    {
        $this->filters = $filter;
        return $this;
    }

    public function MapperDatas($uniqueID)
    {
        $this->id = $uniqueID;
        
        try{
            
            if (! $this->isPropertiesOk()) {
                throw new Exception('Please! Look your properties for class '.__CLASS__);
            }

            $fields = $this->getConstants();

            $fieldToDb = array_values($fields);
            $fieldOfDb = array_keys($fields);

            $dataOf = $this->ofDb->query(
                $this->mountSelect($fieldOfDb, $fields['OF_TABLE'])
            );

            $insertDDLs = $this->mountInsert(
                $dataOf->fetchAll(PDO::FETCH_ASSOC),
                $fieldToDb,
                $fields['TO_TABLE']
            );

            $this->toDb->exec($insertDDLs);

        } catch (Exception $error) {
            echo '<br /><strong>Error:</strong> '. $error->getMessage();
            exit;
        }
    }


    /**
     * Check if relevant properties are serted
     * less it, the functionality of class is wront
     */
    private function isPropertiesOk()
    {
        if ($this->ofDb && $this->toDb && $this->reflectionClass) {
            return true;
        }

        return false;
    }

    private function getConstants()
    {
        $reflection = new ReflectionClass(
            get_class($this->reflectionClass)
        );

        return $reflection->getConstants();
    }

    private function mountInsert(array $of, $to, $tableName)
    {
        $query = 'INSERT INTO '.$tableName;
        
        array_shift($to);
        array_shift($to);

        foreach ($of as $fields) {
            $combined = array_combine($to, $fields);

            foreach ($combined as $key => $value) {
                $field[] = $key;
                $datas[] = $this->filters->keekFilterParams($key, $value, $this->id);
            } 

            $query .= '('.implode(', ', $field).')';
            $query .= ' VALUES('.implode(', ', $datas).')';

            $query = rtrim($query, ', ') . ';';
        }
        echo $query. '<br />';
        return  $query;
    }

    protected function mountSelect(array $fields, $table, $complement = null)
    {
        unset($fields['0']);
        unset($fields['1']);

        return $query = 'SELECT '. implode(', ', $fields) 
        . ' FROM '. $table ." $complement";
    }
}