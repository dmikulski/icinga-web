<?php

interface IcingaApiInterface {};
class LegacyApiResultModel {
    protected $data;
    
    public function __construct($data) {
        $this->data = is_int($data) ? array("count" =>array($data)) : $data;
    }
    public function getRow() {
        $d = current($this->data);
        next($this->data);
        return $d;
    }
    public function getAll() {
        if(is_object($this->data))
            return $this->data->toArray();
        else if(is_array($this->data))
            return $this->data;
    }

}

class ApiLegacyLayerCountObject {
    public function count() {
        return 1;
    }
    private $count;
    public function get($noMatterWhat) {
        return $this->count;
    }
    public function __construct($c) {
        $this->count = $c;
    }
}

class Api_Store_LegacyLayer_IcingaApiModel extends IcingaApiDataStoreModel implements IcingaApiInterface 
{
    protected $isCount = false;
    protected $resultType = Doctrine_Core::HYDRATE_ARRAY; 
    protected $searchFilter = false;
    protected $searchType = false;
    
    public function setResultType($type) {
        if($type == IcingaApiConstants::RESULT_OBJECT)
            parent::setResultType("RECORD");
        if($type == IcingaApiConstants::RESULT_ARRAY)
            parent::setResultType("ARRAY");
        return $this;
    }
    
    protected function setupModifiers() {
        $this->searchFilter = $this->createFilterGroup();

        $this->registerStoreModifier("Store.Modifiers.StorePaginationModifier","Api");
        $this->registerStoreModifier($this->searchFilter);
        $this->registerStoreModifier("Store.Modifiers.StoreSortModifier","Api");
        $this->registerStoreModifier("Store.Modifiers.StoreGroupingModifier","Api");
        
        $this->registerStoreModifier("Store.LegacyLayer.TargetModifier","Api");  
    }
 
    public function createSearch() {
        $this->reset();
        return $this;
    }
   
    public function setSearchOrder ($column, $direction = 'asc') { 
        $this->result = null; 
        $column = $this->resolveColumnAlias($column);    
        $this->setSortfield($column);
        $this->setDir(strtoupper($direction)); 	
        return $this;
    }
    public function reset() {
        $this->result = null;
        $this->isCount = false;

    }	
    public function setSearchLimit ($start, $length = false) {
        $this->result = null;
        $this->setOffset($start);
        if($length)
            $this->setLimit($length);
        return $this;
    }

    public function setSearchTarget($target) {
        $this->result = null; 
        parent::setSearchTarget($target);
        return $this;
    }
    
    public function setResultColumns($target) {
        $this->result = null;
        parent::setResultColumns($target);
        return $this;
    }

    public function execRead() {
        $request = $this->createRequestDescriptor(); 
        $this->applyModifiers($request); 
        $result = null;
        $this->lastQuery = $request; 
        $request->autoResolveAliases(); 
        
        if(!$this->isCount) { 
            $result = $request->execute(NULL,$this->resultType); 
        } else {
            $result = $request->count(); 
        }
        return $result; 
    }
    private $result = null;
    
    public function fetch() {
        if($this->result)
            return $this->result;   

        $data =  $this->execRead();     

        if($this->isCount) {
            $fields = $this->getFields();
            $_data = array(array());
            foreach($fields as $field) {
                $countField = explode(".",$field,2);
                if(count($countField) > 1)
                    $countField = $countField[1];
                
                $_data[0]["COUNT_".strtoupper($countField)] = $data;  
            }
            $data = $_data;  
        }
        $this->result = $this->getContext()->getModel(
            "Store.LegacyLayer.LegacyApiResult","Api",array(
                "result" => $data 
            )
        );
        return $this->result;
    }
  
    public function resolveFilterFields(IcingaApiSearchFilterInterface &$filter) {
        if($filter instanceof IcingaApiSearchFilter) { 
		    $filter->setField($this->resolveColumnAlias($filter->getField()));
            $filterfields[] = $filter->getField();
        } else {
            foreach($filter as $i) {
                $this->resolveFilterFields($i);
            }
        }
    } 

	/**
	 * You should now use createFilter and createFilterGroup and use them as the filter parameter
	 * Using $value and $defaultMatch is @deprecated
	 * (non-PHPdoc)
	 * @see objects/search/IcingaApiSearchInterface#setSearchFilter()
	 */
	public function setSearchFilter ($filter, $value = false, $defaultMatch = IcingaApiConstants::MATCH_EXACT) {       
		if($filter instanceof IcingaApiSearchFilterInterface) {
            $this->resolveFilterFields($filter);   
            $this->searchFilter->addFilter($filter);

		} else if (!is_array($filter) && $value === false) {
			throw new AppKitException('setSearchFilter(): invalid definition of key-value pair(s)!');
		
		} else { // support the previous behaviour of the API and wrap it with filtergroups
			// convert filter into array
			if (!is_array($filter)) {
				$filter = array(array($filter, $value, $defaultMatch));
			} else {
				if(isset($filter["val"])) {
					$this->reIndexFilter($filter);
        	        $filterfields[] = $filter[0][0];
                }
		    }
			// loop through array and apply filters
			foreach ($filter as $filterData) {
				// check length
				$filterDataCount = count($filterData);
				if ($filterDataCount < 1 || $filterDataCount > 3) {
					throw new AppKitException('setSearchFilter(): invalid definition of key-value pair(s)!');
				}
				// set default match type
				if ($filterDataCount == 2) {
					$filterData[2] = $defaultMatch;
				}
				
				$matchType = $filterData[2];

				// add values to filter
				$filtersForGroup = $this->createFilterGroup();
				$filtersForGroup->setType(IcingaApiConstants::SEARCH_OR);
				
                if (!is_array($filterData[1])) {
					$filterData[1] = array($filterData[1]);
				}
				foreach ($filterData[1] as $filterValue) {
	                $filterfields[] = $this->resolveColumnAlias($filterData[0]);
					$filtersForGroup->addFilter($this->createFilter($this->resolveColumnAlias($filterData[0]),$filterValue,$filterData[2]));
				}
				$this->searchFilter->addFilter($filtersForGroup);
			}
		} 
		return $this;
	}

	protected function reIndexFilter(&$filter) {
		$filter[1] = $filter["val"];
		$filter[0] = $this->resolveColumnAlias($filter["field"]);
		$filter[2] = $filter["op"];
		unset($filter["val"]);
		unset($filter["field"]);
		unset($filter["op"]);
		$filter = array($filter);
	}


	public function createFilterGroup($type = null) {
		
        $filterGroup = IcingaApiSearchFilterGroup::createInstance($this,$type);
		return $filterGroup;
	}

	public function createFilter($field = null,$value = null,$match = null) {
		$filter = IcingaApiSearchFilter::createInstance($this,$field,$value,$match);
		return $filter;
	}
	
   	public function setSearchGroup ($columns) {
		if (!is_array($columns)) {
			$columns = array($columns);
		}
        
        $this->setFields($columns,true); 
        foreach($columns as &$column) {
            $column = $this->resolveColumnAlias($column);    
        }
        $this->setGroupfields($columns);
        return $this;
    }
    
    public function setSearchType($type) {
        $this->searchType = $type;
        if($type == IcingaApiConstants::SEARCH_TYPE_COUNT) 
            $this->isCount = true;
        else
            $this->isCount = false;
        return $this;
    }   
    public function getSearchType() {
        return $this->searchType;
    }
} 

