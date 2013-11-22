<?php
/**
 * @of_table pessoas
 * @to_table ESEGUSUARIO
 */
class Usuario implements EnumTablesRelation
{
    const idpessoa = 'CDUSUARIO';
    const nome = 'NMUSUARIO';
    const email = 'DEEMAIL';
    const data_cad = 'DTATIVACAO';
}