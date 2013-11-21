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
    public function keekFilterParams($key, $value, $adtional = null)
    {
        if($key == 'CDUSUARIO' || $key == 'CDUSUARIOCAD')
            return "'ALFAMA_TEST6'";

        if($key == 'FLTPCLIENTE')
            return ('cpf' == $value) ? "'F'" : "'J'";

        if($key == 'INT' || $key == 'INTEGER')
            return 1;
        
        if($key != 'CDCLIENTE')
            return "'$value'";
        else
            return "{$adtional}";
    }
}