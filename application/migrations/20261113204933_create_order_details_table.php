<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_order_details_table extends CI_Migration {


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
			),
			'product_id' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			), 
			'product_name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 150,
			),
			'unit_price' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			), 
			'quantity' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
				'default'  => 1,
			),
			'line_total' => array(
				'type'     => 'INT',
				'unsigned' => TRUE,
			),
 
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP', 			
			'CONSTRAINT fk_order_details_order FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE',			
			'CONSTRAINT fk_order_details_product FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT',
		));
 
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('order_details', TRUE);
	}
 
	public function down()
	{
		$this->dbforge->drop_table('order_details', TRUE);
	}


}
