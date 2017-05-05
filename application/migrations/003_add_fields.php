<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fields extends CI_Migration {

	public function up()
	{
            // Table structure for table 'groups'
            $this->dbforge->add_column('measurements', array(
                    'time_interval' => array(
                            'type' => 'MEDIUMINT',
                            'constraint' => '8',
                            'unsigned' => TRUE
                    ),
                    'area' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255'
                    ),
                    'external_type' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255'
                    ),
                    'external_model' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255',
                    ),
                    'external_serial' => array(
                            'type' => 'VARCHAR',
                            'constraint' => '255'
                    )
            ));

	}

	public function down()
	{
            $this->dbforge->drop_column('measurements', 'time_interval');
            $this->dbforge->drop_column('measurements', 'area');
            $this->dbforge->drop_column('measurements', 'external_type');
            $this->dbforge->drop_column('measurements', 'external_model');
            $this->dbforge->drop_column('measurements', 'external_serial');
	}
}
