<?php
// {{{ICINGA_LICENSE_CODE}}}
// -----------------------------------------------------------------------------
// This file is part of icinga-web.
// 
// Copyright (c) 2009-2013 Icinga Developer Team.
// All rights reserved.
// 
// icinga-web is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
// 
// icinga-web is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
// 
// You should have received a copy of the GNU General Public License
// along with icinga-web.  If not, see <http://www.gnu.org/licenses/>.
// -----------------------------------------------------------------------------
// {{{ICINGA_LICENSE_CODE}}}


Doctrine_Manager::getInstance()->bindComponent('Cronk', 'icinga_web');
/**
 * BaseCronk
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $cronk_id
 * @property string $cronk_uid
 * @property string $cronk_name
 * @property string $cronk_description
 * @property string $cronk_xml
 * @property timestamp $cronk_created
 * @property string $cronk_modified
 * @property integer $cronk_user_id
 * @property boolean $cronk_system
 * @property Doctrine_Collection $NsmUser
 * @property Doctrine_Collection $CronkCategoryCronk
 * @property Doctrine_Collection $CronkPrincipalCronk
 *
 * @package    IcingaWeb
 * @subpackage AppKit
 * @author     Icinga Development Team <info@icinga.org>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseCronk extends Doctrine_Record {
    public function setTableDefinition() {
        $this->setTableName('cronk');

        $this->hasColumn('cronk_id', 'integer', 4, array(
                             'type' => 'integer',
                             'length' => 4,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => true,
                             'autoincrement' => true,
                         ));
        $this->hasColumn('cronk_uid', 'string', 45, array(
                             'type' => 'string',
                             'length' => 45,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('cronk_name', 'string', 45, array(
                             'type' => 'string',
                             'length' => 45,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('cronk_description', 'string', 100, array(
                             'type' => 'string',
                             'length' => 100,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('cronk_xml', 'string', null, array(
                             'type' => 'string',
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('cronk_user_id', 'integer', 4, array(
                             'type' => 'integer',
                             'length' => 4,
                             'fixed' => false,
                             'unsigned' => false,
                             'autoincrement' => false,
                         ));
       $this->hasColumn('cronk_system', 'boolean', 4, array(
                            'type' => 'boolean',
                            'length' => 1,
                            'fixed' => false,
                            'unsigned' => false,
                            'default' => false,
                            'autoincrement' => false,
        ));
        $this->hasColumn('cronk_created', 'timestamp', null, array(
                             'type' => 'datetime',
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('cronk_modified', 'string', 45, array(
                             'type' => 'datetime',
                             'length' => 45,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
    }

    public function setUp() {
        parent::setUp();
        $this->hasMany('CronkCategoryCronk', array(
                           'local' => 'cronk_id',
                           'foreign' => 'ccc_cronk_id'));

        $this->hasMany('CronkPrincipalCronk', array(
                           'local' => 'cronk_id',
                           'foreign' => 'cpc_cronk_id'));
        
        $this->hasOne('NsmUser', array(
                          'local' => 'cronk_user_id',
                          'foreign' => 'user_id'));
        
        $this->hasOne('NsmUser as owner', array(
                'local' => 'cronk_user_id',
                'foreign' => 'user_id'));
        
        $this->hasOne('NsmUser as user', array(
                'local' => 'cronk_user_id',
                'foreign' => 'user_id'));
        
        $this->hasMany('CronkCategory as categories', array(
                'local' => 'ccc_cronk_id',
                'idField' => 'cronk_id',
                'foreign' => 'ccc_cc_id',
                'foreignId' => 'cc_id',
                'refClass' => 'CronkCategoryCronk'));
        
        $this->hasMany('NsmPrincipal as principals', array(
                'local' => 'cpc_cronk_id',
                'idField' => 'cronk_id',
                'foreign' => 'cpc_principal_id',
                'foreignId' => 'principal_id',
                'refClass' => 'CronkPrincipalCronk'));
    }
}
