<?php
/**
 * @of_table reservas
 * @to_table EVNDCONTRATOCOND	
 */
class InsertContractConditions implements EnumTablesRelation
{
	const NUCONTRATO = 'idreserva';
  	// const CDTIPOCONDICAO   CHAR(2) NOT NULL,
  // NUSEQ            DECIMAL(2) NOT NULL,
  // CDEMPRESA        DECIMAL(4) NOT NULL,
  // CDEMPREEND       DECIMAL(5) NOT NULL,
  // CDPORTADOR       DECIMAL(5),
  // CDINDEXADOR      DECIMAL(4),
  // DT1VENCTO        DATE NOT NULL,
  // DTBASE           DATE NOT NULL,
  // DTBASEJUR        DATE,
 	const VLTOTALCOND = 'valor_contrato';
  // QTPARCELAS       INTEGER NOT NULL,
  // NUORDEM          INTEGER NOT NULL,
  // FLCOINCIDE       CHAR NOT NULL,
  // FLJURO           CHAR NOT NULL,
	const PEJUROS = 'valor_repasse';
  // QTCARENCIA       INTEGER,
	const VLSALDODEVEDOR = 'valor_comissao';
  // DTBASESDDEV      DATE,
  // QTPARCELASSDDEV  INTEGER,
	const VLTOTALCJUROS = 'valor_venda';
}