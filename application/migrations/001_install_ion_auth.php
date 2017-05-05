<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Install_ion_auth extends CI_Migration {

	public function up()
	{
		// Drop table 'groups' if it exists
		$this->dbforge->drop_table('groups', TRUE);

		// Table structure for table 'groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
			),
			'description' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('groups');

		// Dumping data for table 'groups'
		$data = array(
			array(
				'id' => '1',
				'name' => 'admin',
				'description' => 'Administrator'
			),
			array(
				'id' => '2',
				'name' => 'members',
				'description' => 'General User'
			)
		);
		$this->db->insert_batch('groups', $data);


		// Drop table 'users' if it exists
		$this->dbforge->drop_table('users', TRUE);

		// Table structure for table 'users'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'username' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '80',
			),
			'salt' => array(
				'type' => 'VARCHAR',
				'constraint' => '40'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '100'
			),
			'activation_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'forgotten_password_time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'remember_code' => array(
				'type' => 'VARCHAR',
				'constraint' => '40',
				'null' => TRUE
			),
			'created_on' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
			),
			'last_login' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'active' => array(
				'type' => 'TINYINT',
				'constraint' => '1',
				'unsigned' => TRUE,
				'null' => TRUE
			),
			'first_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'last_name' => array(
				'type' => 'VARCHAR',
				'constraint' => '50',
				'null' => TRUE
			),
			'company' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null' => TRUE
			),
			'phone' => array(
				'type' => 'VARCHAR',
				'constraint' => '20',
				'null' => TRUE
			)

		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users');

		// Dumping data for table 'users'
		$data = array(
			'id' => '1',
			'ip_address' => '127.0.0.1',
			'username' => 'administrator',
			'password' => '$2a$07$SeBknntpZror9uyftVopmu61qg0ms8Qv1yV6FG.kQOSM.9QhmTo36',
			'salt' => '',
			'email' => 'admin@admin.com',
			'activation_code' => '',
			'forgotten_password_code' => NULL,
			'created_on' => '1268889823',
			'last_login' => '1268889823',
			'active' => '1',
			'first_name' => 'Admin',
			'last_name' => 'istrator',
			'company' => 'ADMIN',
			'phone' => '0',
		);
		$this->db->insert('users', $data);


		// Drop table 'users_groups' if it exists
		$this->dbforge->drop_table('users_groups', TRUE);

		// Table structure for table 'users_groups'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'user_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			),
			'group_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('users_groups');

		// Dumping data for table 'users_groups'
		$data = array(
			array(
				'id' => '1',
				'user_id' => '1',
				'group_id' => '1',
			),
			array(
				'id' => '2',
				'user_id' => '1',
				'group_id' => '2',
			)
		);
		$this->db->insert_batch('users_groups', $data);


		// Drop table 'login_attempts' if it exists
		$this->dbforge->drop_table('login_attempts', TRUE);

		// Table structure for table 'login_attempts'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'ip_address' => array(
				'type' => 'VARCHAR',
				'constraint' => '16'
			),
			'login' => array(
				'type' => 'VARCHAR',
				'constraint' => '100',
				'null', TRUE
			),
			'time' => array(
				'type' => 'INT',
				'constraint' => '11',
				'unsigned' => TRUE,
				'null' => TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('login_attempts');
                
                
                // Drop table 'files' if it exists
		$this->dbforge->drop_table('files', TRUE);

		// Table structure for table 'files'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'loudness' => array(
				'type' => 'TINYINT',
                                'unsigned' => TRUE,
				'constraint' => '3',
                                'default' => '0',
			),
                        'checked' => array(
				'type' => 'TINYINT',
                                'unsigned' => TRUE,
				'constraint' => '1',
                                'default' => '0',
			),
			'checked_on' => array(
				'type' => 'datetime',
                                'null', TRUE
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('files');
                
                
                // Drop table 'measurements' if it exists
		$this->dbforge->drop_table('measurements', TRUE);

		// Table structure for table 'measurements'
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
				'auto_increment' => TRUE
			),
                        'file_id' => array(
				'type' => 'MEDIUMINT',
				'constraint' => '8',
				'unsigned' => TRUE,
			),
                        'company' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'admin' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'space' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                    
			'activity' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'tasks' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'primary_source' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'other_sources' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'events_characteristics' => array(
				'type' => 'VARCHAR',
				'constraint' => '255'
			),
			'hours' => array(
				'type' => 'TINYINT',
				'constraint' => '3',
                                'unsigned' => TRUE,
			),
			'count' => array(
				'type' => 'TINYINT',
				'constraint' => '3',
                                'unsigned' => TRUE,
			),
			'other_afected' => array(
				'type' => 'TINYINT',
				'constraint' => '3',
                                'unsigned' => TRUE,
			),
			'use_protection' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                        'protection_type' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                        'protection_model' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                        'aditional' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                        'position' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
                        'image' => array(
				'type' => 'TEXT'
			),
			'loudness' => array(
				'type' => 'TINYINT',
				'constraint' => '3',
				'unsigned' => TRUE
			),
			'created_on' => array(
				'type' => 'datetime'
			)
		));
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('measurements');

	}

	public function down()
	{
		$this->dbforge->drop_table('users', TRUE);
		$this->dbforge->drop_table('groups', TRUE);
		$this->dbforge->drop_table('users_groups', TRUE);
		$this->dbforge->drop_table('login_attempts', TRUE);
                $this->dbforge->drop_table('files', TRUE);
                $this->dbforge->drop_table('measurements', TRUE);
	}
}
