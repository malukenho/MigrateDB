<?php
class Clients implements EnumTablesRelation
{
	const OF_TABLE = 'pessoas';
	const TO_TABLE = 'ECADCLIENTE';

    const idpessoa = 'CDCLIENTE';
    const nome = 'NMCLIENTE';
    const email = 'DEEMAIL';
    const ativo = 'FLATIVO';
    const data_cad = 'DTCADASTRAMENTO';
    const ativo_login = 'FLTPCLIENTE';
    const idpais = 'CDUSUARIOCAD';
    //const NUFONECEL = 'telefone';
    //const FLTPCLIENTE = 'documento_tipo';
    //const CDTIPOCLIENTE = 'null';
    //const DEMSN = 'null';
    //const DESKYPE = 'null';
    //const NMSENHAPORTAL =  'null';
    //const CDPRECLIENTE =  '200';
    //const FLCLIENTE =  'null';
    //const CDUSUARIOALT =  'GUYPORTO';
    //const DTULTALTERACAO = 'CURRENT_TIMESTAMP';
    //const NMUSUARIOPORTAL = 'NULL';
    //const CDCREDOR = 'null';
    //const CDCLIENTESAC =  'null';
    //const FLUTILIZAPCR = 'N';
}