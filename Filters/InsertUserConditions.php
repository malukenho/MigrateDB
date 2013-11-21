<?php
/**
 * This class filter and adjust data to be used in query 
 *
 * @package Sienge_Migration
 * @author  Jefersson Nathan <jeferssonn@alfamaweb.com.br>
 */
class InsertUserConditions implements FilterParams
{
    /**
     * Apply filter to params
     *
     * @return string
     * @author Jefersson Nathan <jeferssonn@alfamaweb.com.br>
     */
    public function keekFilterParams($key, $value)
    {
        if($key == 'CDUSUARIO' || $key == 'CDUSUARIOCAD')
            return "'TESTES_ALFAMA3'";
        elseif($key != 'CDCLIENTE')
            return "'$value'";
        else
            return "{$this->id}";
    }
}