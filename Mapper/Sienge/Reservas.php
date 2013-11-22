<?php
/**
 * @of_table reservas
 * @to_table ECADCLIENTE
 * @complement WHERE id_sienge IS NULL ORDER BY idreserva DESC LIMIT 1
 */
class Reservas implements EnumTablesRelation
{
	const idreserva = 'CDCLIENTE';
}
