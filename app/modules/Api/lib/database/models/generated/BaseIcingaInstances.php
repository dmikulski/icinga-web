<?php

/**
 * BaseIcingaInstances
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $instance_id
 * @property string $instance_name
 * @property string $instance_description
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseIcingaInstances extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $prefix = Doctrine_Manager::getInstance()->getConnectionForComponent("IcingaHoststatus")->getPrefix();
        $this->setTableName($prefix.'instances');
        $this->hasColumn('instance_id', 'integer', 2, array(
             'type' => 'integer',
             'length' => 2,
             'fixed' => false,
             'unsigned' => false,
             'primary' => true,
             'autoincrement' => true,
             ));
        $this->hasColumn('instance_name', 'string', 64, array(
             'type' => 'string',
             'length' => 64,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
        $this->hasColumn('instance_description', 'string', 128, array(
             'type' => 'string',
             'length' => 128,
             'fixed' => false,
             'unsigned' => false,
             'primary' => false,
             'default' => '',
             'notnull' => true,
             'autoincrement' => false,
             ));
    }

    public function setUp()
    {
	$this->hasMany('IcingaHosts as hosts', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'
	));
	$this->hasMany('IcingaServices as services', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'
	));
	$this->hasMany('IcingaHostgroups as hostgroups', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'
	));
 	$this->hasMany('IcingaServicegroups as servicegroups', array(
		'local' => 'instance_id',
		'foreign' => 'instance_id'
	));      
	
	parent::setUp();
        
    }
}
