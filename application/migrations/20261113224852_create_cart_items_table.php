<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_cart_items_table extends CI_Migration
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
			'product_id' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
			'quantity' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
				'default'  => 1,
			),
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
			'UNIQUE KEY uq_cart_user_product (user_id, product_id)',
			'CONSTRAINT fk_cart_items_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE',
			'CONSTRAINT fk_cart_items_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE',
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('cart_items', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('cart_items', TRUE);
	}
}
