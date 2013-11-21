<?php
class ClientsData implements EnumTablesRelation
{
    const OF_TABLE = 'pessoas';
    const TO_TABLE = 'EPVDPRECLIENTE';

    const estado_civil = 'CDESTCIVIL';
    const idpessoa =  'CDPRECLIENTE';
    const data_nasc = 'DTNASCIMENTO';
    const f = 'FLSEXO';
    
    // const CDMUNICIPIO = 'NULL'; // FOREING KE;
    // const CDPROFISSAO = 'NULL'; // FOREING KE;
    // const endereco = 'DEENDERECO';
    // const DECOMPLEMENTO = 'complemento';
    // const NMBAIRRO = 'bairro';
    // const NUCEP = 'cep';
    // const VLRENDAFAMILIAR = 'renda_familiar';
    // const NUCPF = 'documento';
    // const FLVISIVEL = 'NULL';
    // const DEEMAIL = 'email';
    // const CDCLIENTE = $uniqueID; // FOREING KE;
    // const CDLOCALCAPTACAO = 'NULL';
    // const NMAPELIDO = 'NULL';
    // const CDCOLABCADASTRO = 'NULL';
    // const CDCOLABULTIMAALT = 'NULL';
    // const NMCLIENTE = 'nome';
    // const DTCADASTRO = 'data_cad';
    // const DTULTIMAATUALIZACAO = 'ultimo_acesso';
    // const FLTIPO = 'documento_tipo';
    // const DTVISIBILIDADE = 'NULL'; // NUL;
    // const FLVISIBILIDADE = 'L';
    // const CDEQUIPEVISIB = 'NULL'; // FOREING KE;
    // const CDCOLABORADORVISIB = 'NULL'; // FOREING KE;
    // const CDFAIXAETARIA = 'NULL'; // FOREING KE;
    // const FLCLIENTE = 'S';
    // const DEOBSERVACAO = 'observacoes';
    // const QTFILHOS = 'NULL'; //NUL;
    // const DTULTVINCULO = 'NULL'; //NUL;
    // const CDCOLABULTVINC = 'NULL'; // FOREING KE;
    // const CDNUMERO = 'NULL'; //NUL;
    // const NMNACIONALIDADE = 'nome_do_pais';
    // const NMNATURALIDADE = 'naturalidad';
}