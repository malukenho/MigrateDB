<?php
/**
 * @of_table reservas
 * @to_table EVNDCONTRATO
 */
class InsertReserva implements EnumTablesRelation
{
	const NUCONTRATO = 'idreserva';
	const VLTOTALCONTRATO = 'valor_contrato'; 
	const VLTOTALVENDA = 'valor_venda'; 
	const VLFIXOSEGURO = 'valor_repasse';
	const CDEMPRESA = 'idpessoa';
	const CDEMPREEND = 'id_sienge_empreendimento';
	const DTCONTRATO = 'data_cad';
	const NUMESREAJUSTE = 'mes_incc';
	const NUCONTRATOVIEW = 'num_contrato_view';
	const FLSITUACAO = 'idsituacao';
	const FLGERARRESIDUO = 'ativo';
	const FLDILUIRRESIDUO = 'residuo';
	const FLSEGURO = 'seguro';
	const FLTIPOSEGURO = 'tiposeguro';
	const FLCORRECAO = 'correcao';
	// const NUUNIDADE = 'id_sienge_unidade';
	// const DTRESERVA = 'data_cad';
	// const DTVALIDADERESERVA = 'vencimento';
	// const DEOBSERVACAO = 'aprovacao_comentario';
	// const CDRESERVAUNIDADE = 'idimobiliaria';
	// const CDCREDOR = 'id_sienge_corretor';
	// const FLORIGEM = 'condicao_aprovada';
}