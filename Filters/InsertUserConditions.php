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

        if ('DTVALIDADERESERVA' == $key && empty($value))
            return 'CURRENT_TIMESTAMP';

        if ('DTRESERVA' == $key)
            return "'".substr($value, 0, -9)."'";

        if ('CDRESERVAUNIDADE' == $key)
            return "2";

        if ('return' == $key)
            return $value;

        if ('FLTPCLIENTE' == $key)
            return ('cpf' == $value) ? "'F'" : "'J'";
        
        if ('NULL' == $key)
            return  'NULL';

        if ('CDCLIENTE' != $key)
            return "'$value'";
        else
            return "{$adtional}";
    }
}