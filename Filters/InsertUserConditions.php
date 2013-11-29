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
        global $mySqlConnecition;

        if($key == 'CDUSUARIO' 
            || $key == 'CDUSUARIOCAD')
                return "'ALFAMA_TEST10'";

        if ('DTVALIDADERESERVA' == $key && empty($value))
            return 'CURRENT_TIMESTAMP';

        if ('CDRESERVAUNIDADE' == $key || 'NUCONTRATO' == $key)
            return "{$adtional}";

        if ('DTCONTRATO' == $key)
            return "'".substr($value, 0, -9)."'";

        if ('CDEMPREEND' == $key) {
            return '701';
        }

        if ('CDEMPRESA' == $key)
            return "'1'";

        if ('FLORIGEM' == $key)
            return "'V'";

        if ('return' == $key)
            return $value;

        if ('FLTPCLIENTE' == $key)
            return ('cpf' == $value) ? "'F'" : "'J'";
        
        if ('NULL' == $key)
            return  'NULL';

        if ('CDCLIENTE' != $key){
            $stmt =$mySqlConnecition->query('SELECT codigointerno FROM pessoas WHERE idpessoa='.$value);
            $rst = $stmt->fetch(PDO::FETCH_ASSOC);
            print_r($rst);
            echo '<br>---<br><br>';
            return "'{$rst['codigointerno']}'";
        }
        
        return "{$adtional}";
    }
}