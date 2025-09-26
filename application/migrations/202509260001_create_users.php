<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_users extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        $fields = array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'name' => array('type' => 'VARCHAR', 'constraint' => '100'),
            'email' => array('type' => 'VARCHAR', 'constraint' => '150'),
            'password_hash' => array('type' => 'VARCHAR', 'constraint' => '255'),
            'created_at' => array('type' => 'DATETIME'),
            'updated_at' => array('type' => 'DATETIME'),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('email');
        $this->dbforge->create_table('users', TRUE);

        // unique index for email
        $this->db->query("ALTER TABLE `users` ADD UNIQUE (`email`)");
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('users', TRUE);
    }
}
