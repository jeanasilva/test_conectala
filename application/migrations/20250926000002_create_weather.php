<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_weather extends CI_Migration {

    public function up()
    {
        $this->load->dbforge();

        $fields = array(
            'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
            'city' => array('type' => 'VARCHAR', 'constraint' => '150'),
            'temperature' => array('type' => 'DECIMAL', 'constraint' => '6,2', 'null' => TRUE),
            'description' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => TRUE),
            'raw' => array('type' => 'TEXT', 'null' => TRUE),
            'fetched_at' => array('type' => 'DATETIME'),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('city');
        $this->dbforge->create_table('weather', TRUE);
    }

    public function down()
    {
        $this->load->dbforge();
        $this->dbforge->drop_table('weather', TRUE);
    }
}
