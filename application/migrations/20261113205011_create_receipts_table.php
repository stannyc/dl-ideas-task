<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_receipts_table extends CI_Migration {


	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			),
 			'invoice_id' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
				'unique'   => TRUE,
			),
 			'receipt_number' => array(
				'type'       => 'VARCHAR',
				'constraint' => 30,
				'unique'     => TRUE,
			),
 			'stripe_payment_intent_id' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE,
			),
 			'amount_paid' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
			'currency' => array(
				'type'       => 'CHAR',
				'constraint' => 3,
				'default'    => 'usd',
			),
 			'payment_method' => array(
				'type'       => 'VARCHAR',
				'constraint' => 50,
				'null'       => TRUE,
			),
 			'paid_at' => array(
				'type' => 'DATETIME',
			),
 
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP', 
			'CONSTRAINT fk_receipts_invoice FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE RESTRICT',
		));
 
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('receipts', TRUE);
	}
 
	public function down()
	{
		$this->dbforge->drop_table('receipts', TRUE);
	}


}
