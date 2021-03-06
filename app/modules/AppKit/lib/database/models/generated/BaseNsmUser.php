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

Doctrine_Manager::getInstance()->bindComponent('NsmUser', 'icinga_web');
/**
 * BaseNsmUser
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @property integer $user_id
 * @property integer $user_account
 * @property string $user_name
 * @property string $user_lastname
 * @property string $user_firstname
 * @property string $user_password
 * @property string $user_salt
 * @property string $user_authsrc
 * @property string $user_authid
 * @property string $user_authkey
 * @property string $user_email
 * @property string $user_description
 * @property integer $user_disabled
 * @property timestamp $user_created
 * @property timestamp $user_modified
 * @property Doctrine_Collection $NsmPrincipal
 * @property Doctrine_Collection $NsmUserPreference
 * @property Doctrine_Collection $NsmUserRole
 *
 * @package    IcingaWeb
 * @subpackage AppKit
 * @author     Icinga Development Team <info@icinga.org>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseNsmUser extends Doctrine_Record {

    public function setTableDefinition() {
        $this->setTableName('nsm_user');
        $this->hasColumn('user_id', 'integer', 4, array(
                             'type' => 'integer',
                             'length' => 4,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => true,
                             'autoincrement' => true,
                         ));
        $this->hasColumn('user_account', 'integer', 4, array(
                             'type' => 'integer',
                             'length' => 4,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => 0,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_name', 'string', 127, array(
                             'type' => 'string',
                             'length' => 127,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_lastname', 'string', 40, array(
                             'type' => 'string',
                             'length' => 40,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_firstname', 'string', 40, array(
                             'type' => 'string',
                             'length' => 40,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_password', 'string', 64, array(
                             'type' => 'string',
                             'length' => 64,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_salt', 'string', 64, array(
                             'type' => 'string',
                             'length' => 64,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_authsrc', 'string', 45, array(
                             'type' => 'string',
                             'length' => 45,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => 'internal',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_authid', 'string', 512, array(
                             'type' => 'string',
                             'length' => 512,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_authkey', 'string', null, array(
                             'type' => 'string',
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_email', 'string', 254, array(
                             'type' => 'string',
                             'length' => 40,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false
                         ));
        $this->hasColumn('user_description', 'string', 255, array(
                             'type' => 'string',
                             'length' => 255,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => false,
                             'autoincrement' => false
                         ));
        $this->hasColumn('user_disabled', 'integer', 1, array(
                             'type' => 'integer',
                             'length' => 1,
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'default' => '1',
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_created', 'timestamp', null, array(
                             'type' => 'timestamp',
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
        $this->hasColumn('user_modified', 'timestamp', null, array(
                             'type' => 'timestamp',
                             'fixed' => false,
                             'unsigned' => false,
                             'primary' => false,
                             'notnull' => true,
                             'autoincrement' => false,
                         ));
    }


    public function setUp() {
        parent::setUp();

        $this->hasOne('NsmPrincipal as principal', array(
                          'local' => 'user_id',
                          'foreign' => 'principal_user_id'
                      ));
        
        $this->hasMany('NsmUserPreference as preferences', array(
                           'local' => 'user_id',
                           'foreign' => 'upref_user_id'));

        $this->hasMany('NsmUserRole as roles', array(
                           'local' => 'user_id',
                           'foreign' => 'usro_user_id'));
        
        $this->hasMany('Cronk as cronks', array(
                           'local' => 'user_id',
                           'foreign' => 'cronk_user_id'
        ));
        
        $this->hasMany('CronkPrincipalCronk as cronkPrincipals', array(
                           'local' => 'principal_user_id',
                           'foreign' => 'principal_id',
                           'refClass' => 'NsmPrincipal'
        ));
    }
    public static function getInitialData() {
        return  array(
                    array(
                        "user_id"=>1,
                        "user_account"=>0,
                        "user_name" => 'root',
                        "user_firstname" => 'Enoch',
                        "user_lastname" => 'Root',
                        "user_password" => '42bc5093863dce8c150387a5bb7e3061cf3ea67d2cf1779671e1b0f435e953a1',
                        "user_salt" => '0c099ae4627b144f3a7eaa763ba43b10fd5d1caa8738a98f11bb973bebc52ccd',
                        "user_authsrc" => 'internal',
                        //              "user_authid" => '',
                        "user_email" => 'root@localhost.local',
                        "user_disabled" => 0
                    )
                );
    }
    public static function getPgsqlSequenceOffsets() {
        return array("nsm_user_user_id_seq" => 2);
    }
}
