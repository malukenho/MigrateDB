<?php
/**
 * @of_table reservas
 * @to_table EPVDRESERVAUNIDADE
 */
class InsertReserva implements EnumTablesRelation
{
	const CDEMPREEND = 'id_sienge_empreendimento';
	const NUUNIDADE = 'id_sienge_unidade';
	const DTRESERVA = 'data_cad';
	const DTVALIDADERESERVA = 'vencimento';
	const DEOBSERVACAO = 'aprovacao_comentario';
	const CDRESERVAUNIDADE = 'idimobiliaria';
	const CDCREDOR = 'id_sienge_corretor';
	const FLORIGEM = 'condicao_aprovada';
}