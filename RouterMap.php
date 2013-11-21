<?php
/**
 * This class create a relational map betwen databasses
 * 
 */
class RouterMap
{
	/**
	 *	Class to be reflected
	 */
    private $reflectionClass;
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
			echo '<strong>Error:</strong> '. $error->getMessage();
			exit;
		}
	}

	private function isPropertiesOk()
	{
		if ($this->ofDb 
			&& $this->toDb
			&& $this->reflectionClass
		) {
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

				if($key == 'CDUSUARIO' || $key == 'CDUSUARIOCAD')
					$datas[] = "'TESTES_ALFAMA2'";
				elseif($key != 'CDCLIENTE')
					$datas[] = "'$value'";
				else
					$datas[] = "{$this->id}";
			} 

			$query .= '('.implode(', ', $field).')';
			$query .= ' VALUES('.implode(', ', $datas).')';

			$query = rtrim($query, ', ') . ';';
		}
		echo $query;
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