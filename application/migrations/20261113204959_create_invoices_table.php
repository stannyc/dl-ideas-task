<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_invoices_table extends CI_Migration {


	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			),
			'order_id' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
				'unique'   => TRUE,
			), 
			'invoice_number' => array(
				'type'       => 'VARCHAR',
				'constraint' => 30,
				'unique'     => TRUE,
			),
 			'amount' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
			'currency' => array(
				'type'       => 'CHAR',
				'constraint' => 3,
				'default'    => 'usd',
			),
 			'status' => array(
				'type'       => 'VARCHAR',
				'constraint' => 20,
				'default'    => 'unpaid',
			),
 			'paid_at' => array(
				'type'    => 'DATETIME',
				'default' => NULL,
			),
 			'issued_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
 			'CONSTRAINT fk_invoices_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE RESTRICT',
		));
 
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('status');
 		$this->dbforge->create_table('invoices', TRUE);
	}
 
	public function down()
	{
		$this->dbforge->drop_table('invoices', TRUE);
	}


}
