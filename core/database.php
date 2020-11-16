<?php
include_once 'config.php';

class Database extends PDO
{
    public function __construct()
    {
        $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::ATTR_EMULATE_PREPARES => false);
        parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET, DB_USER, DB_PWD, $options);
    }
    
    static public function debugPDO($raw_sql, $parameters)
    {
        $keys = array();
        $values = $parameters;

        foreach ($parameters as $key => $value) {

            // check if named parameters (':param') or anonymous parameters ('?') are used
            if (is_string($key)) {
                $keys[] = '/' . $key . '/';
            } else {
                $keys[] = '/[?]/';
            }

            // bring parameter into human-readable format
            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            } elseif (is_array($value)) {
                $values[$key] = implode(',', $value);
            } elseif (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }
        $raw_sql = preg_replace($keys, $values, $raw_sql, 1, $count);

        return $raw_sql;
    }
    
    public function ImperativeQuery($sql, $parameters = null)
    {
        $query = $this->prepare($sql);
        $query->execute($parameters);
    }
    
    private function ExecuteRetrievingQuery($sql, $parameters = null)
    {
        $query = $this->prepare($sql);
        $query->execute($parameters);
        return $query;
    }
    
    public function RetrievingQuery($sql, $parameters = null, $all = true, $column = -1)
    {
        $query = $this->ExecuteRetrievingQuery($sql, $parameters);
        if ($column >= 0)
            return $query->fetchColumn($column);
        else
            if ($all)
                return $query->fetchAll();
            else
                return $query->fetch();
    }
    
    public function RowCount($sql, $parameters = null)
    {
        $query = $this->ExecuteRetrievingQuery($sql, $parameters);
        return $query->rowCount();
    }
    
    public function ExistenceQuery($sql, $parameters = null, $boolean = true)
    {
        if ($boolean)
        {
            if ($this->RowCount($sql, $parameters) > 0)
                return true;
            else
                return false;
        }
        else
        {
            if ($this->RowCount($sql, $parameters) > 0)
                return 1;
            else
                return 0;
        }
    }
    
    public function QueryStructureFromJSON($json)
	{
		$columns = "";
		$labels = "";
		$values = array();
		
		foreach ($json as $k => $v)
		{
			$columns .= $k . ",";
			$labels .= ":" . $k . ",";
			$values[":".$k] = $v;
		}
		
		$var = new stdClass();
		$var->columns = rtrim($columns, ',');
		$var->labels = rtrim($labels, ',');
		$var->values = $values;
		
		return $var;
	}
}