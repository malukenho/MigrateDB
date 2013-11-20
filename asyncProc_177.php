<pre>#!/usr/bin/env php
<?php
# file.php [id] [time] 

error_reporting(-1);
ini_set('display_errors', 1);

$absolutePath = realpath(dirname(__FILE__));

// +-------------------------------------+
// |        CONFIG ENVIRONMENT           |
// +-------------------------------------+

if(! in_array('firebird', PDO::getAvailableDrivers())) {
    printf('%sThe <strong>firebird</strong> drive not found', nl2br(PHP_EOL));
    exit(2);
}

// if ('cli' != php_sapi_name()) {
//     printf(
//         '%sCannot execute this script by <strong>%s</strong> SAPI',
//         nl2br(PHP_EOL),
//         php_sapi_name()
//     );
//     exit(1);
// }

// checkParams()
$contractID = 1;
$uniqueID = 7758;

// +-------------------------------------+
// |        CREATE CONNECTIONS           |
// +-------------------------------------+

// 177.43.233.34 162.243.16.203 matriz.massai.com.br
$fireBirdConnection = new PDO(
    'firebird:dbname=177.43.233.34:/home/SiengeWeb/SIENGE.FDB',
    'sysdba',
    'masterkey'
);

$fireBirdConnection->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

$lmao = $fireBirdConnection->query(
    "SELECT * FROM ECADCLIENTE 
        WHERE NMCLIENTE 
        LIKE '%Fulano%'
    ORDER BY CDCLIENTE DESC"
);

print_r($lmao->fetchAll(PDO::FETCH_OBJ));
die('Closed.');


$mySqlConnection = new PDO(
    sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['database']), 
    $config['usuario'], 
    $config['senha']
);

$mySqlConnection->setAttribute(
    PDO::ATTR_ERRMODE,
    PDO::ERRMODE_EXCEPTION
);

// +-------------------------------------+
// |               CONTRACT              |
// +-------------------------------------+

$contractInfo = $mySqlConnection->query(
    'SELECT * FROM reservas WHERE idreserva=' . $contractID
)->fetch(PDO::FETCH_OBJ);

// EVNDCONTRATO
$contractRelational = array(
    'NUCONTRATO' => 'NULL',
    'DTCONTRATO' => $contractInfo->data_cad,
    'DTPREVENTREGA' => '',
    'FLSITUACAO' => '',
    'CDPLANO' => '',
    'DEOBSERVACAO' => '',
    'DEDETALHE' => '',
    'VLTOTALCONTRATO' => $contractInfo->valor_contrato,
    'VLTOTALVENDA' => $contractInfo->valor_contrato,
    'FLGERARRESIDUO' => 'N',
    'FLDILUIRRESIDUO' => 'N',
    'PEJUROMORA' => '',
    'PEMULTAMORA' => '',
    'TPJUROMORA' => '',
    'VLMORADIA' => '0',
    'FLSEGURO' => '',
    'FLTIPOSEGURO' => '',
    'VLFIXOSEGURO' => '',
    'FLCORRECAO' => '',
    'NUMESREAJUSTE' => '',
    'NUCOTA' => 'NULL',
    'CDEMPRESA' => '', // FOREING KEY
    'CDEMPREEND' => '', // FOREING KEY
    'CDINDEXMORA' => '', // FOREING KEY
    'NUTITULO' => '', // FOREING KEY
    'CDCONTA' => '',
    'CDOPERACAOCTB' => '', // FOREING KEY
    'NUTITULOORIGINAL' => '',
    'NUCONTRATOVIEW' => '',
    'DTEMISSAO' => '',
    'DECLAUSULAESP' => '',
    'DTFISICA' => '',
    'TPCONTRATO' => '',
    'TPCORRECAOANUAL' => '',
    'FLCALCULOMULTA' => '',
    'CDPROPOSTA' => '', // FOREING KEY
    'TPCANCELAMENTO' => '',
    'TPSUBCANCELAMENTO' => '',
    'VLUNIDADE' => '',
    'PEDESCONTO' => '',
    'VLTAXAADM' => '',
    'FLSITUACAODISTRATO' => '',
    'DTMOMENTOREPAC' => '',
    'DTREATIVACAO' => '',
    'TPDESCONTO' => 'M',
    'PEDEVMINIMO' => ''
);

$contractParams = bindParams($contractRelational);

// execute query of top

// ECADCREDOR
$credorRelational = array(
    'CDCREDOR' => '',
    'CDTIPOPAGAMENTO' => '',
    'CDMUNICIPIO' => '',
    'DECOMPLEMENTO' => '',
    'DEEMAIL' => '',
    'DEENDERECO' => '',
    'DEMSN' => '',
    'DESKYPE' => '',
    'DTHOMOLOGACAO' => '',
    'FLATIVO' => '',
    'FLFISJUR' => '',
    'FLME' => '',
    'FLTIPOCONTA' => '',
    'FLCONTROLADO' => '',
    'NMBAIRRO' => '',
    'NMCREDOR' => '',
    'NMFANTASIA' => '',
    'NUCEP' => '',
    'NUFAX' => '',
    'NUFONE' => '',
    'NUIDENTIDADE' => '',
    'NURAMAL' => '',
    'NUCMC' => '',
    'NUCNPJ' => '',
    'NUCPF' => '',
    'NUINCRICAOEST' => '',
    'NUINSCRICAOMUNIC' => '',
    'QTPRAZOMEDENTR' => '',
    'VLDEDUCAO' => '',
    'VLNOTA' => '',
    'DEOBSERVACAO' => '',
    'DESITE' => '',
    'DVAGENCIA' => '',
    'DVCONTA' => '',
    'DVDAC' => '',
    'NMAGENCIA' => '',
    'NUAGENCIA' => '',
    'NMFAVORECIDO' => '',
    'NUCNPJFAVORECIDO' => '',
    'NUCPFFAVORECIDO' => '',
    'NUCONTA' => '',
    'CDIMPREL' => '',
    'CDBANCO' => '',
    'PECOMISSAO' => '',
    'FLADIANTAMENTO' => '',
    'CDAUXILIAR' => '',
    'CDUSUARIOALT' => '',
    'DTULTALTERACAO' => '',
    'CDCARGOFUNCAO' => '',
    'FLFUNCIONARIO' => '',
    'FLCOLABUSOPVD' => '',
    'NUREGISTRO' => '',
    'DTADMISSAO' => '',
    'DTDEMISSAO' => '',
    'CDUSUARIOSIE' => '',
    'FLCOLABUSOSGQ' => '',
    'CDSETOROBRA' => '',
    'TPREGCONSISTENTE' => '',
    'CDUSUARIOCAD' => '',
    'DTCADASTRAMENTO' => '',
    'FLFORNECEDOR' => '',
    'FLCORRETOR' => '',
    'FLCOLABORADOR' => '',
    'CDEMPRESATRABALHA' => '',
    'CDNUMERO' => '',
    'FLUTILIZAPCR' => '',
    'NMUSUARIOPORTAL' => '',
    'NMSENHAPORTAL' => '',
    'FLORGAOPUBLICO' => '',
    'NUCRECI' => '',
    'DECERTIFICADO' => '',
    'CDCREDORFATURCOMIS' => '',
    'CDUSUARIOPCR' => ''
);

// ECADTIPOPAGAMENTO
$tipoPagamentoRelational = array(
    'CDTIPOPAGAMENTO' => '',
    'DETIPOPAGAMENTO' => '',
    'FLBUSCARINFCREDOR' => '',
    'CDOPERACAOBANCARIO' => '', // FOREING KEY
    'CDTIPOSERVICO' => '', // FOREING KEY
    'CDOPERACAOPAGTO' => '',
    'FLATIVO' => ''
);

// ECADMUNICIPIO
$municipioRolational = array(
    'CDMUNICIPIO' => '',
    'CDUF' => '', // FOREING KEY
    'NMMUNICIPIO' => '',
    'CDMUNICRECEITA' => '',
    'CDMUNFEDERAC' => '',
    'CDMUNESTADUAL' => '',
    'CDMUNIBGD' => ''
);

// ECADUF
$ufRelational = array(
    'CDUF' => '',
    'CDPAIS' => '', // FOREING KEY
    'SGUF' => '',
    'NMUF' => ''
);

// ECADCARGOFUNCAO
$cargoFuncaoRelational = array(
    'CDCARGOFUNCAO' => '',
    'NMCARGOFUNCAO' => '',
    'FLVISAOGERALPVD' => '',
    'FLATIVO' => '',
    'CDCBO' => '',
    'CDCARGOSUPERIOR' => '', // FOREING KEY
    'VLCUSTOHORA' => ''
);

// ECADBANCO
$bancoRelational = array(
    'CDBANCO' => '',
    'NMBANCO' => '',
    'QTTAMANHODVAGENCIA' => '',
    'QTTAMANHODVCONTA' => '',
    'QTTAMANHODVDAC' => '',
    'FLCONCDIGITAL' => ''
);

// ECADPAIS
$paisRelational = array(
    'CDPAIS' => '',
    'NMPAIS' => '',
    'CDPAISIBGE' => '' // FOREING KEY
);

// ECADPAISIBGE
$paisIbge = array(
    'CDPAISIBGE' => '',
    'NMPAISIBGE' => ''
);

// EVNDCORCONTRATO
$corContratoRelarional = array(
    'CDCREDOR' => '', // FOREING KEY
    'NUCONTRATO' => '',
    'FLPRINCIPAL' => '',
    'CDEMPRESA' => '',
    'CDEMPREEND' => ''
);

// +-------------------------------------+
// |               CLIENT                |
// +-------------------------------------+

$people = $mySqlConnection->query(
    'SELECT 
        c.*, 
        (SELECT nome FROM paises WHERE idpais = c.`idpais`) nome_do_pais,
        (SELECT nome FROM estados WHERE idestado = c.`idestado`) nome_do_estado
    FROM 
        pessoas c 
    WHERE 
        c.`idpessoa`=' . $contractInfo->idpessoa
);

$people = $people->fetch(PDO::FETCH_OBJ);


// print_r($people);


// Insert client on firebird database
// First step to insert data of client
// is storage the data in ECADCLIENTE
$people->documento_tipo = ('cpf' == $people->documento_tipo) ? 'F' : 'J'; 

print_r($people);

$ecadClienteRelational = array(
    'CDCLIENTE' => $uniqueID,
    'NMCLIENTE' => $people->nome,
    'CDTIPOCLIENTE' => 'NULL', // FOREING KEY
    'DEEMAIL' => $people->email,
    'FLATIVO' => 'S',
    'NUFONECEL' => $people->telefone,
    'FLTPCLIENTE' => $people->documento_tipo,
    'DEMSN' => 'NULL',
    'DESKYPE' => 'NULL',
    'NMSENHAPORTAL' =>  'NULL',
    'CDPRECLIENTE' =>  '200',
    'FLCLIENTE' =>  'NULL',
    'CDUSUARIOALT' =>  'GUYPORTO',
    'DTULTALTERACAO' => 'CURRENT_TIMESTAMP',
    'CDUSUARIOCAD' => 'ADMIN',
    'DTCADASTRAMENTO' => 'CURRENT_TIMESTAMP',
    'NMUSUARIOPORTAL' => 'NULL',
    'CDCREDOR' => 'NULL',
    'CDCLIENTESAC' =>  'NULL',
    'FLUTILIZAPCR' => 'N'
);

$ecadClientParamsFormated = bindParams($ecadClienteRelational);

$b = $fireBirdConnection->exec(
    sprintf(
        'INSERT INTO ECADCLIENTE %s VALUES %s', 
        $ecadClientParamsFormated['columns'],
        $ecadClientParamsFormated['values']
    )
);


// TODO: tratar estado civil
--$people->estado_civil;

$epvdPreCliente = array(
    'CDESTCIVIL' => $people->estado_civil,
    'CDPRECLIENTE' =>  $uniqueID,
    'CDPROFISSAO' => 'NULL', // FOREING KEY
    'CDMUNICIPIO' => 'NULL', // FOREING KEY
    'DTNASCIMENTO' => $people->data_nasc,
    'FLSEXO' => 'F',
    'DEENDERECO' => $people->endereco,
    'DECOMPLEMENTO' => $people->complemento,
    'NMBAIRRO' => $people->bairro,
    'NUCEP' => $people->cep,
    'VLRENDAFAMILIAR' => $people->renda_familiar,
    'NUCPF' => $people->documento,
    'FLVISIVEL' => 'NULL',
    'DEEMAIL' => $people->email,
    'CDCLIENTE' => $uniqueID, // FOREING KEY
    'CDLOCALCAPTACAO' => 'NULL',
    'NMAPELIDO' => 'NULL',
    'CDCOLABCADASTRO' => 'NULL',
    'CDCOLABULTIMAALT' => 'NULL',
    'NMCLIENTE' => $people->nome,
    'DTCADASTRO' => $people->data_cad,
    'DTULTIMAATUALIZACAO' => $people->ultimo_acesso,
    'FLTIPO' => $people->documento_tipo,
    'DTVISIBILIDADE' => 'NULL', // NULL
    'FLVISIBILIDADE' => 'L',
    'CDEQUIPEVISIB' => 'NULL', // FOREING KEY
    'CDCOLABORADORVISIB' => 'NULL', // FOREING KEY
    'CDFAIXAETARIA' => 'NULL', // FOREING KEY
    'FLCLIENTE' => 'S',
    'DEOBSERVACAO' => $people->observacoes,
    'QTFILHOS' => 'NULL', //NULL
    'DTULTVINCULO' => 'NULL', //NULL
    'CDCOLABULTVINC' => 'NULL', // FOREING KEY
    'CDNUMERO' => 'NULL', //NULL
    'NMNACIONALIDADE' => $people->nome_do_pais,
    'NMNATURALIDADE' => $people->naturalidade
);

$epvdParamsFormated = bindParams($epvdPreCliente);

// Insert client data
/*$b = $fireBirdConnection->query(
    sprintf(
        'INSERT INTO EPVDPRECLIENTE %s VALUES %s',
        $epvdParamsFormated['columns'],
        $epvdParamsFormated['values']
    )
);

var_dump($b);
*/

// ECADANEXOOBRA
$anexoOnbra = array(
    'NUANEXOOBRA' => '',
    'CDEMPREEND' => '', // FOREING KEY
    'DEANEXO' => '',
    'NMANEXO' => '',
    'IMANEXO' => '',
    'FLANEXOPORTALCLI' => ''
);


// ECADAREANEGOCIO
$reaNegocio = array( 
    'CDEMPRESA' => '', // FOREING KEY
    'CDAREANEGOCIO' => '',
    'DEAREANEGOCIO' => ''
);

// ECADEMPRESA
$empresa = array(
    'CDEMPRESA' => '',
    'NMEMPRESA' => '',
    'CDGRUPOEMPRESA' => '', // FOREING KEY
    'DEENDERECO' => '',
    'DECOMPLEMENTO' => '',
    'NMBAIRRO' => '',
    'CDMUNICIPIO' => '', // FOREING KEY
    'NUCEP' => '',
    'NUCNPJ' => '',
    'NUINSCREST' => '',
    'DTINICPERBASE' => '',
    'FLCONDOMINIO' => '',
    'NUFONE' => '',
    'NUFAX' => '',
    'DEEMAIL' => '',
    'DEENDERECOCOB' => '',
    'DECOMPLEMENTOCOB' => '',
    'NMBAIRROCOB' => '',
    'CDMUNICIPIOCOB' => '', // FOREING KEY
    'NUCEPCOB' => '',
    'NUFONECOB' => '',
    'DESITE' => '',
    'NMREPRESENTANTE' => '',
    'CDESTCIVILREP' => '', // FOREING KEY
    'CDPROFISSAOREP' => '', // FOREING KEY
    'NMNACIONALIDADEREP' => '',
    'NMNATURALIDADEREP' => '',
    'NUCPFREP' => '',
    'NUIDENTIDADEREP' => '',
    'DEENDERECOREP' => '',
    'DECOMPLENDERECOREP' => '',
    'NMBAIRROREP' => '',
    'NUCEPREP' => '',
    'CDMUNICIPIOREP' => '', // FOREING KEY
    'NUTELEFONEREP' => '',
    'FLATIVA' => '',
    'CDEMPRESAVIEW' => '',
    'NUCMC' => '',
    'NUCREA' => '',
    'FLTRIBUTACAO' => '',
    'FLUSACONTSIENGE' => '',
    'CDUSUARIOALT' => '',
    'DTULTALTERACAO' => '',
    'CDUSUARIOCAD' => '',
    'DTCADASTRAMENTO' => '',
    'CDNUMERO' => '',
    'DTFUNDACAO' => '',
    'NUPISREPRESENTANTE' => '',
    'NMFANTASIA' => '',
    'NMEMPRESACONTADOR' => '',
    'DTBLOQUEIOCOMP' => ''
);

// +-------------------------------------+
// |                AGENT                |
// +-------------------------------------+

//createTemporaryTable($mySqlConnection);

/*
insertOnTemporaryTable(
    array(
        'client_id' => 1, 
        'client_name' => 'test the insert action'
    ),
    $mySqlConnection
);
*/
# print_r(selectAllOfTemporaryTable($mySqlConnection));


# By args
# DB Connection -> OK!
# Mapper data 
#    - contract
#       - files
#    - user
#       - files, pics, accounts
#    - agent
#       - accounts, employer
# register on cron

# usar path absoluto