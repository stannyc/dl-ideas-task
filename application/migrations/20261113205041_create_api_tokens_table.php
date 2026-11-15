<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Migration_create_api_tokens_table extends CI_Migration
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
			'token_hash' => array(
				'type'       => 'CHAR',
				'constraint' => 64,
				'unique'     => TRUE,
			),
			'name' => array(
				'type'       => 'VARCHAR',
				'constraint' => 100,
				'null'       => TRUE,
			),
			'expires_at' => array(
				'type' => 'DATETIME',
			),
			'last_used_at' => array(
				'type'    => 'DATETIME',
				'default' => NULL,
			),
			'revoked_at' => array(
				'type'    => 'DATETIME',
				'default' => NULL,
			),

			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'CONSTRAINT fk_api_tokens_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE',
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('api_tokens', TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table('api_tokens', TRUE);
	}
}
