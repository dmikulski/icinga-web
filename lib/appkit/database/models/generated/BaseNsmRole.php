<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseNsmRole extends AppKitDoctrineRecord
{
  public function setTableDefinition()
  {
    $this->setTableName('nsm_role');
    $this->hasColumn('role_id', 'integer', 4, array('type' => 'integer', 'length' => 4, 'primary' => true, 'autoincrement' => true));
    $this->hasColumn('role_name', 'string', 40, array('type' => 'string', 'length' => 40, 'notnull' => true));
    $this->hasColumn('role_description', 'string', 255, array('type' => 'string', 'length' => 40, 'notnull' => false));
    $this->hasColumn('role_disabled', 'boolean', 1, array('type' => 'boolean', 'length' => 1, 'notnull' => true, 'default' => true));
    $this->hasColumn('role_created', 'timestamp', null, array('type' => 'timestamp', 'default' => 'CURRENT_TIMESTAMP', 'notnull' => true));
    $this->hasColumn('role_modified', 'timestamp', null, array('type' => 'timestamp', 'default' => '0000-00-00 00:00:00', 'notnull' => true));
  }

}