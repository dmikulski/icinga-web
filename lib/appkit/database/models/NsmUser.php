<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class NsmUser extends BaseNsmUser implements AppKitUserPreferences
{

	const HASH_ALGO = 'sha256';
	
	/**
	 * 
	 * @var Doctrine_Collection
	 */
	private $principals			= null;
	
	/**
	 * 
	 * @var array
	 */
	private $principals_list	= null;
	
	public function setUp () {

		parent::setUp();

		$this->hasMany('NsmRole', array (	'local'		=> 'usro_user_id',
											'foreign'	=> 'usro_role_id',
											'refClass'	=> 'NsmUserRole'));
		
        $options = array (
        	'created' =>  array('name'	=> 'user_created'),
        	'updated' =>  array('name'	=> 'user_modified'),
        );

		$this->actAs('Timestampable', $options);

	}
	
	public function givenName() {
		if ($this->user_lastname && $this->user_firstname) {
			return sprintf('%s, %s', $this->user_lastname, $this->user_firstname);	
		}
		else {
			return $this->user_name;
		}
	}
	
	public function hasRoleAssigned($role_id) {
		foreach ($this->NsmRole as $role) {
			if ($role_id == $role->role_id) {
				return true;
			}
		}
		
		return false;
	}
	
	private function __updatePassword($password) {
		$this->user_salt = $this->__createSalt($this->user_name);
		$this->user_password = hash_hmac(self::HASH_ALGO, $password, $this->user_salt);
	}
	
	private function __createSalt($entropy) {
		return hash(self::HASH_ALGO, uniqid($entropy. '_', mt_rand()));
	}
	
	public function updatePassword($password) {
		if ($this->state() !== self::STATE_TDIRTY) {
			$this->__updatePassword($password);
		}
		else {
			throw new AppKitDoctrineException('Could not change a password on a not existing record!');
		}
		
		return false;
	}
	
	/**
	 * Sets a pref value
	 * @param string $key
	 * @param mixed $val
	 * @param boolean $overwrite
	 * @param boolean $blob
	 * @return unknown_type
	 * @throws AppKitException
	 * @author Marius Hein
	 */
	public function setPref($key, $val, $overwrite = true, $blob = false) {
		
		try {
			$pref = $this->getPrefObject($key);
			
			// DO NOT OVERWRITE
			if ($overwrite === false) return false;
			
			if ($blob == true) {
				$pref->upref_longval = $val;
			}
			else {
				$pref->upref_val = $val;
			}
			
			$pref->save();
		}
		catch (AppKitDoctrineException $e) {
			$pref = new NsmUserPreference();
			$pref->upref_key = $key;

			if ($blob == true) {
				$pref->upref_longval = $val;
			}
			else {
				$pref->upref_val = $val;
			}
			
			$pref->NsmUser = $this;
			$pref->save();
		}
		
		return true;
	}
	
	/**
	 * Returns a preferenceobject from a user
	 * @param string $key
	 * @return NsmUserPreference
	 * @throws AppKitDoctrineException
	 * @author Marius Hein
	 */
	public function getPrefObject($key) {
		$res = Doctrine_Query::create()
		->from('NsmUserPreference p')
		->where('p.upref_user_id=? and p.upref_key=?', array($this->user_id, $key))
		->limit(1)
		->execute();
		
		if ($res->count() == 1 && ($obj = $res->getFirst()) instanceof NsmUserPreference) {
			return $obj;
		}
		
		throw new AppKitDoctrineException('Preference record not found!');
	}
	
	/**
	 * Returns the real value of a preference 
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 * @author Marius Hein
	 */
	public function getPrefVal($key, $default=null, $blob = false) {
		try {
			$obj = $this->getPrefObject($key);
			if ($obj->upref_longval || $blob) {
				return $obj->upref_longval;
			}
			else {
				return $obj->upref_val;
			}
		}
		catch (AppKitDoctrineException $e) {
			return $default;
		}
	}
	
	public function getPrefComponent($key, $component_name) {
		$val = $this->getPrefVal($key);
		if ($val) {
			return Doctrine::getTable($component_name)->find($val);
		}
		
		return null;
	}
	
	/**
	 * Deletes a pref value from the user
	 * @param string $key
	 * @return boolean if something was deleted
	 * @author Marius Hein
	 */
	public function delPref($key) {
		$test = Doctrine_Query::create()
		->delete('NsmUserPreference p')
		->where('p.upref_user_id=? and p.upref_key=?', array($this->user_id, $key))
		->limit(1)
		->execute();
		
		if ($test) return true;
		else return false;
	}
	
	public function getPreferences() {
		$res = Doctrine_Query::create()
		->select('p.upref_val, p.upref_key, p.upref_longval')
		->from('NsmUserPreference p INDEXBY p.upref_key')
		->where('p.upref_user_id=?', array($this->user_id))
		->execute(array(), Doctrine::HYDRATE_ARRAY);
		
		$out = array();
		foreach ($res as $key=>$d) $out[$key] = $d['upref_longval'] ? 'BLOB' : $d['upref_val'];
		
		return $out;
	}
	
	public function getPreferencesList(array $list=array()) {
		$res = Doctrine_Query::create()
		->select('p.upref_val, p.upref_key')
		->from('NsmUserPreference p INDEXBY p.upref_key')
		->where('p.upref_user_id=?', array($this->user_id))
		->andWhereIn('p.upref_key', $list)
		->execute(array(), Doctrine::HYDRATE_ARRAY);
		
		$out = array();
		foreach ($res as $key=>$d) $out[$key] = $d['upref_val'];
		
		return $out;
	}
	
	/**
	 * Returns the status of the corresponding principal
	 * @return boolean
	 */
	public function principalIsValid() {
		return ($this->NsmPrincipal->principal_id > 0) ? true : false;
	}
	
	/**
	 * Returns a list of all belonging principals
	 * @return array
	 */
	public function getPrincipalsList() {
		
		if ($this->principals_list === null) {
			
			$this->principals_list = array_keys( $this->getPrincipals()->toArray() );
				
		}
		
		return $this->principals_list;
	}
	
	
	/**
	 * Return all principals belonging to this
	 * user
	 * @return Doctrine_Collection
	 */
	public function getPrincipals() {
		
		if ($this->principals === null) {
		
			$this->principals = Doctrine_Query::create()
			->select('p.*')
			->from('NsmPrincipal p INDEXBY p.principal_id')
			->leftJoin('p.NsmRole r')
			->leftJoin('r.NsmUserRole ur')
			->andWhere('ur.usro_user_id=? or p.principal_user_id=?', array($this->user_id, $this->user_id))
			->execute();
		
		}
		
		return $this->principals;
		
	}
	
	/**
	 * Return all targets belonging to thsi user
	 * @param string $type
	 * @return Doctrine_Collection
	 */
	public function getTargets($type=null) {
		return $this->getTargetsQuery($type)->execute();
	}
	
	/**
	 * Returns a DQL providing the user targets
	 * @param string $type
	 * @return Doctrine_Query
	 */
	protected function getTargetsQuery($type=null) {
		$q = Doctrine_Query::create()
		->select('t.*')
		->distinct(true)
		->from('NsmTarget t INDEXBY t.target_id')
		->innerJoin('t.NsmPrincipalTarget pt')
		->andWhereIn('pt.pt_principal_id', $this->getPrincipalsList());
		
		if ($type !== null) {
			$q->andWhere('t.target_type=?', array($type));
		}
		
		return $q;
	}

	/**
	 * Returns true if a target exists
	 * @param string $name
	 * @return boolean
	 */
	public function hasTarget($name) {
		$q = $this->getTargetsQuery();
		$q->andWhere('t.target_name=?', array($name));
		
		if ($q->execute()->count() > 0) {
			return true;
		}
		
		return false;
	}
	
	/**
	 * Returns a query with all values to a target
	 * @param string $name
	 * @return Doctrine_Query
	 */
	protected function getTargetValuesQuery($target_name) {
		$q = Doctrine_Query::create()
		->select('tv.*')
		->from('NsmTargetValue tv')
		->innerJoin('tv.NsmPrincipalTarget pt')
		->innerJoin('pt.NsmTarget t with t.target_name=?', $target_name)
		->andWhereIn('pt.pt_principal_id', $this->getPrincipalsList());
		return $q;
	}
	
	/**
	 * Return all target values as Doctrine_Collection
	 * @param string $target_name
	 * @return Doctrine_Collection
	 */
	public function getTargetValues($target_name) {
		return $this->getTargetValuesQuery($target_name)->execute() ;
	}
	
	public function getTargetValue($target_name, $value_name) {
		$q = $this->getTargetValuesQuery($target_name);
		$q->select('tv.tv_val');
		$q->andWhere('tv.tv_key=?', array($value_name));
		$res = $q->execute();
		
		$out = array();
		foreach ($res as $r) {
			$out[] = $r->tv_val;
		}
		return $out;
	}
}