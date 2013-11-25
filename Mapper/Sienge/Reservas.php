<?php
/**
 * @of_table reservas
 * @to_table EPVDRESERVAUNIDADE
 * @complement WHERE `reservas`.`id_sienge` IS NULL AND `reservas`.`idcorretor` = `corretores`.`idcorretor` ORDER BY idreserva DESC LIMIT 2
 * @type join
 */
class Reservas implements EnumTablesRelation
{
	const idreserva = 'idreserva';
	const idpessoa = 'idpessoa';
	const idassociado = 'idassociado';
	const idcorretor = 'idcorretor';
	const idimobiliaria = 'idimobiliaria';
	const idusuario = 'idusuario';
	const idusuario_imobiliaria = 'idusuario_imobiliaria';
	const vencimento = 'vencimento';
	const data_cad = 'data_cad';
	const condicao_aprovada = 'condicao_aprovada';
	const aprovacao_comentario = 'aprovacao_comentario';

	const id_sienge_corretor = 'id_sienge.corretores';
	const id_sienge_pessoa = 'id_sienge.pessoas';
	const id_sienge_empreendimento = 'id_sienge.empreendimentos';
	const id_sienge_unidade = 'id_sienge.empreendimentos_unidades';
}