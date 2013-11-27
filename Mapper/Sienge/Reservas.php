<?php
/**
 * @of_table reservas
 * @to_table EVNDCONTRATO
 * @complement WHERE `reservas`.`codigointerno` IS NULL ORDER BY idreserva DESC LIMIT 1
 * @type join
 */
class Reservas implements EnumTablesRelation
{
	const idreserva = 'idreserva';
	const idpessoaa = 'idpessoa';
	const idassociado = 'idassociado';
	const idcorretor = 'idcorretor';
	const idimobiliaria = 'idimobiliaria';
	const idusuario = 'idusuario';
	const idusuario_imobiliaria = 'idusuario_imobiliaria';
	const vencimento = 'vencimento';
	const data_cad = 'data_cad';
	const valor_contrato = 'valor_contrato';
	const valor_venda = 'valor_contrato';
	const valor_saldo_vendedor = 'valor_contrato';
	const condicao_aprovada = 'condicao_aprovada';
	const aprovacao_comentario = 'aprovacao_comentario';

	const valor_repasse = 'valor_repasse';
	const mes_incc = 'mes_incc';
	const num_contrato_view = 'idreserva';
	const idsituacao = 'idsituacao';
	const residuo = 'ativo';
	const ativo = 'ativo';
	const seguro = 'ativo';
	const tiposeguro = 'ativo';
	const correcao = 'ativo';

	const idcondicao = 'idreservascondicoes.reservas_condicoes 
						ON reservas_condicoes.idreserva = reservas.idreserva';

	// const nome_cliente = 'nome.pessoas ON pessoas.idpessoa = reservas.idpessoa';
	const id_sienge_corretor = 'codigointerno.corretores ON corretores.idcorretor = reservas.idcorretor';
	const id_sienge_pessoa = '*.pessoas ON pessoas.idpessoa = reservas.idpessoa AND pessoas.codigointerno';
	const id_sienge_empreendimento = 'codigointerno.empreendimentos ON empreendimentos.codigointerno IS NOT NULL';
	const id_sienge_unidade = 'codigointerno.empreendimentos_unidades ON empreendimentos_unidades.idunidade = reservas.idunidade';
}