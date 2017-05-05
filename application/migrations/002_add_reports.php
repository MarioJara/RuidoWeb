<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_reports extends CI_Migration {

	public function up()
	{
            // Drop table 'groups' if it exists
            $this->dbforge->drop_table('reports', TRUE);

            // Table structure for table 'groups'
            $this->dbforge->add_field(array(
                    'id' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE,
                            'auto_increment' => TRUE
                    ),
                    'period' => array(
                            'type' => 'INT',
                            'constraint' => '3',
                            'unsigned' => TRUE
                    ),
                    'emails' => array(
                            'type' => 'TEXT'
                    ),
                    'admin' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                    ),
                    'company' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                    ),
                    'created_on' => array(
                            'type' => 'DATETIME',
                    )
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('reports');

	}

	public function down()
	{
            $this->dbforge->drop_table('reports', TRUE);
	}
}
