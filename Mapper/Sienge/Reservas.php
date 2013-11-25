<?php
/**
 * @of_table reservas
 * @to_table EPVDRESERVAUNIDADE
 * @complement WHERE `reservas`.`codigointerno` IS NULL ORDER BY idreserva DESC LIMIT 20
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

	const id_sienge_corretor = 'codigointerno.corretores ON corretores.idcorretor = reservas.idcorretor';
	const id_sienge_pessoa = 'codigointerno.pessoas ON pessoas.idpessoa = reservas.idpessoa';
	const id_sienge_empreendimento = 'codigointerno.empreendimentos ON empreendimentos.codigointerno IS NOT NULL';
	const id_sienge_unidade = 'codigointerno.empreendimentos_unidades ON empreendimentos_unidades.idunidade = reservas.idunidade';
}