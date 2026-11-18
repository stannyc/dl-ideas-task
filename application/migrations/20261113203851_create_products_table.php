<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_products_table extends CI_Migration
{
	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			),
			'name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 200,
			),
			'description' => array(
				'type'      => 'TEXT',
				'null'		=> TRUE,
			),
			'price' => array(
				'type' 		=> 'DECIMAL',
			),
			'currency' => array( //Deprecated, Stripe can't process multi currency checkout, default currency will set in .env
				'type' 		=> 'VARCHAR',
				'constraint' => 10,
				'default' 	=> 'sgd'
			),
			'is_active' => array( 
				'type' 		=> 'TINYINT',
				'default' 	=> 0,
			),
			'image' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'null'       => TRUE,
			),
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('products', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('products', TRUE);
	}
}
