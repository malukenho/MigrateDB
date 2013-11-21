<?php
class Usuario implements EnumTablesRelation
{
	const OF_TABLE = 'pessoas';
	const TO_TABLE = 'ESEGUSUARIO';

    const idpessoa = 'CDUSUARIO';
    const nome = 'NMUSUARIO';
    const email = 'DEEMAIL';
    const data_cad = 'DTATIVACAO';
}