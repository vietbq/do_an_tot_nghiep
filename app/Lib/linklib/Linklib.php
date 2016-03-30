<?php
define('LINKLIB_ERR_WRONG_ACCESS_KEY', 10001);
define('LINKLIB_ERR_NULL_ACCESS_KEY', 10002);
define('LINKLIB_ERR_NULL_ACCESS_TIME', 10003);
define('LINKLIB_ERR_NULL_UDID', 10004);
define('LINKLIB_ERR_NULL_AUID', 10005);
define('LINKLIB_ERR_NULL_SIGNED_PARAMS', 10006);

/*
Handshake parameters description:
- access_key: md5($access_time.$udid.$auid.LINKLIB_SECRET_KEY)
- access_time: timestamp when API is called.
- udid: user device unique ID. Ex: iOS --> udid, Android --> uuid
- auid: user application ID. Ex: facebook --> fb user id, twitter --> username
*/
class Linklib{    
    private $client_query;
    private $error_arr;
	
	private $params_array = array('access_key' => null, 'access_time' => null, 'udid' => null, 'auid' => null);
    
    function __construct($signed_params){
		if ($signed_params == null){
			$this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_NULL_SIGNED_PARAMS,
                            );
			return null;
		}
        $unsigned_params = $this->decode($signed_params);
		extract($unsigned_params);

        // NULL check
        if (empty($access_key)){
            $this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_NULL_ACCESS_KEY,
                            );
            return null;
        } elseif (empty($access_time)){
            $this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_NULL_ACCESS_TIME,
                            );
            return null;
        } elseif (empty($udid)){
            $this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_NULL_UDID,
                            );
            return null;
        } elseif (empty($auid)){
            $this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_NULL_AUID,
                            );
            return null;
        }
        
        $check_key = md5($access_time.$udid.$auid.LINKLIB_SECRET_KEY);
        // If wrong access key
        if ($check_key != $access_key){
            $this->error_arr = array('ret' => 'NG',
                                'error_code' => LINKLIB_ERR_WRONG_ACCESS_KEY,
                            );
            $this->params_array['access_time'] = null;
			$this->params_array['access_key'] = null;
			$this->params_array['udid'] = null;
			$this->params_array['auid'] = null;        
            $this->client_query = null;
        
            return null;
        }
        
        $this->error_arr = null;
		$this->params_array['access_time'] = $access_time;
		$this->params_array['access_key'] = $access_key;
		$this->params_array['udid'] = $udid;
		$this->params_array['auid'] = $auid;
        if(isset($client_query)){
            $this->client_query = $client_query;
        }
    }
    
    protected function decode($signed_params){
        // TODO: decode signed params here and return unsigned param string.
        $unsigned_params = json_decode($signed_params, true);
        return $unsigned_params;
    }
    
    public function errorAsJson(){
        if (!empty($this->error_arr)){
            return json_encode($this->error_arr);
        }
        return null;
    }
    
    public function errorAsArray(){
        if (!empty($this->error_arr)){
            return $this->error_arr;
        }
        return null;
    }
    
    public function queryAsJson(){
        if (!empty($this->error_arr)){
            return $this->error_arr;
        }
    
        if ($this->client_query == null){
            return null;
        }
                
        return json_encode($this->client_query);
    }
    
    public function queryAsArray(){
        if (!empty($this->error_arr)){
            return $this->error_arr;
        }
        
        if ($this->client_query == null){
            return null;
        }
        
		return $this->client_query;
    }
	
		/**
	 * Return the value of a property of this object
	 * or null if not present.
	 */
	public function get($key) {
		if (isset($this->params_array[$key])){
			return $this->params_array[$key];
		}
		return null;
	}
	
	/**
	 * Set a property to a particular value on this object.
	 * Flags that property as 'dirty' so it will be saved to the
	 * database when save() is called.
	 */
	public function set($key, $value) {
		$this->params_array[$key] = $value;
	}
	
	// --------------------- //
	// --- MAGIC METHODS --- //
	// --------------------- //
	public function __get($key) {
		return $this->get($key);
	}

	public function __set($key, $value) {
		$this->set($key, $value);
	}

	public function __isset($key) {
		return isset($this->params_array[$key]);
	}
}