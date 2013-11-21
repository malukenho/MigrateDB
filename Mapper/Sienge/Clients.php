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
    const telefone = 'NUFONECEL';
}