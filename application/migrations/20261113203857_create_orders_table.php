<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_orders_table extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field(array(			
			'id' => array(
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			),
			'user_id' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
			'status' => array(
				'type'       => 'VARCHAR',
				'constraint' => 20,
				'default'    => 'pending',
			),
			'total_amount' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
			'currency' => array(
				'type'       => 'CHAR',
				'constraint' => 3,
				'default'    => 'usd',
			),
			'stripe_checkout_session_id' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
				'unique'     => TRUE,
			),
			'paid_at' => array(
				'type'    => 'DATETIME',
				'default' => NULL,
			),
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT ON UPDATE CASCADE',
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('status');
		$this->dbforge->create_table('orders', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('orders', TRUE);
	}
}
