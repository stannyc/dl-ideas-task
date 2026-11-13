<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_users_table extends CI_Migration {
    public function up() {

		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',				
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => 100,
				'unique' => TRUE,				
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => 150,				
			),
			'password_hash' => array(
				'type' => 'VARCHAR',				
				'constraint' => 255
			),
			'role' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
				'default' => 'user'
			),
			'is_active' => array(
				'type' => 'TINYINT',
				'default' => 1
			),
			'created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP',
			'updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
		));

		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

	}

    public function down() {
		$this->dbforge->drop_table('users', TRUE);
	}
}
