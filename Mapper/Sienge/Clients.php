<?php
/**
 * @of_table pessoas
 * @to_table ECADCLIENTE
 */
class Clients implements EnumTablesRelation
{
    const idpessoa = 'CDCLIENTE';
    const nome = 'NMCLIENTE';
    const email = 'DEEMAIL';
    const ativo = 'FLATIVO';
    const data_cad = 'DTCADASTRAMENTO';
    const ativo_login = 'FLTPCLIENTE';
    const idpais = 'CDUSUARIOCAD';
    const telefone = 'NUFONECEL';
}