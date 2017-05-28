<?php 
namespace BigMayor\Utility; 
use \BigMayor\Html\Form;
use BigMayor\Utility\AppTrait;
trait FormTrait
{  
   use AppTrait;
   
	protected $form;
	protected $requiredFields;
	protected $allInput;
	protected $inputKeys;
	protected $requestInput;
	protected $dbInput;
	
	
	/*Servic Container
	* 
	* @return Object
	*/
 	public function app()
	{
		return app();
	}
	
	
	/* Request
	* 
	* @return Obj
	*/
 	public function request()
	{
		return request();
	}
	

	/*Form Instance
	* 
	* @return instance
	*/
 	public function form(){
		return $this->form =  new  Form();
	}
	
	
	
	/* Set Input Fields
	/*
	* @param array $keys
	* @return void
	*/
	public function setInputKeys($keys)
	{
		 $this->inputKeys = (array) $keys;
	}
	
	/**
     * Retrieve all input item from the request including session.
     *
     * @param  string || array 
     * @return string|array
     */
    protected function allRequestInput( $keys = null)
    {	
		$this->inputKeys = !empty($keys)? (array) $keys : $this->inputKeys;
		
		$data = $this->request()->all();
		foreach( $this->inputKeys as $k => $v){
			$data[$v] = $this->request()->old($v);
		}
		return  $this->requestInput = $data;
	}

	
	/* Set Required Fields
	/*
	* @param array $required
	* @return void
	*/
	public function setRequiredFields($required)
	{
		 $this->requiredFields = $required;
	}
	
	/* Get requiredFields
	/*
	* @return array
	*/
	public function getRequiredFields()
	{
		return $this->requiredFields;
	}
	
	
	/*Prepare Attr
	/*
	* @param array $attr
	* @param array $customAttr
	*
	* @return array 
	*/
	public function setAttr($attr, $customAttr){
		
		$attributes = array_merge($attr, $customAttr);
		
		$name = @$attributes['name'];
		
		if(isset($this->requiredFields[$name])){
			$attributes['required'] = 'required';
		}
		else{
			unset($attributes['required']);
		}
		return $attributes;
		
	}
	
	/* Check input
	*
	* @return string
	**/
	public function check($old,  $new)
	{
		return $old === $new ? "checked" : '';
	}
	
	  	
	/*CSRF Protection token field
	*
	* @return string
	**/
	public function csrfField()
	{
		return csrf_field();
	}
	

	
	/*
	* Get value from array or object based on a key
	*
	* @param array || object $data
	* @param string $key
	* @param string $default
	*
	* @return mixed
	*/	
	public function getFrom($data, $key, $default = null)
	{
		if(is_array($data) && isset($data[$key])){
			return $data[$key];
		}
		else if(is_object($data) && isset($data->$key)){
			return $data->$key;
		}
		return $default;
	}
	
	/*
	* Get array of key to value map from array or object
	*
	*@return mixed
	*/	
	public function mapFrom($data, $key, $vKey)
	{
		$map = [];
		foreach($data as $k => $row){
			$k = $this->getFrom($row, $key);
			$v = $this->getFrom($row, $vKey);
			$map[$k] = $v; 
		}
	   return $map;
	}
	
	
	/*
	* Get value from array or object based on a key
	*
	*@return mixed
	*/	
	public function findFrom($data, $data2,  $key, $default = null)
	{
		$v =  $this->getFrom($data, $key);
		if(!empty($v)){
			return $v;
		}
		return  $this->getFrom($data2, $key, $default);
	}
	
	
	/* Retrieve an input item from the request or database.
	*
	* @param string $key
	* @param string $default
	*
	* @return string
	*/
	public function val($key,  $default = '')
	{
		return $this->findFrom($this->requestInput, $this->dbInput,  $key, $default);
	}
	
	/**
     * Retrieve an input item from the request
     *
     * @param  string  $key
     * @param  string|array|null  $default
	 *
     * @return string|array
     */
	public function fromRequest($key = null, $default = null)
	{
		return (!empty($this->requestInput[$key]))? $this->requestInput[$key] : $default;
	}

}