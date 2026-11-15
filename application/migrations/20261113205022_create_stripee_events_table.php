<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_stripee_events_table extends CI_Migration
{

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type'           => 'INT',
				'unsigned'       => TRUE,
				'auto_increment' => TRUE,
			),
			'stripe_event_id' => array(
				'type'       => 'VARCHAR',
				'constraint' => 255,
				'unique'     => TRUE,
			),
			'type' => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
			),
			'payload' => array(
				'type' => 'JSON',
			),
			'processed_at' => array(
				'type'    => 'DATETIME',
				'default' => NULL,
			),
			'error' => array(
				'type' => 'TEXT',
				'null' => TRUE,
			),
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('type');
		$this->dbforge->create_table('stripe_events', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('stripe_events', TRUE);
	}
}
