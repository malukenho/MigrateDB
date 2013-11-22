<?php
/**
 * This class filter and adjust data to be used in query 
 *
 * @package MigrationDB
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
    public function keekFilterParams($key, $value, $adtional = null)
    {
        if($key == 'CDUSUARIO' || $key == 'CDUSUARIOCAD')
            return "'ALFAMA_TEST10'";

        if($key == 'FLTPCLIENTE')
            return ('cpf' == $value) ? "'F'" : "'J'";
        
        if($key == 'NULL')
            return  'NULL';

        if($key != 'CDCLIENTE')
            return "'$value'";
        else
            return "{$adtional}";
    }
}