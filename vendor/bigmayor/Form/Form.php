<?php 
/*
* This file is part of the amevon package.
*
* @package		Amevon
* @author		Allan Amevor
* @copyright	Copyright Amevon Ltd.
* @license		http://amevon.com
* @link		    http://amevon.com
* @since		Version 1.0.0
*/
namespace BigMayor\Html;
class Form
{
	public $defaultClass = 'form-control';
	
	/*
	* 
	* Merge Array:
	* 
	*@param array
	*@param array
	*@param boolen
	*@return array
	*/ 
	public function mergeAttr($param, $defaultParam = array(), $merge = true)
	{
		
		if(!is_array($param) && !is_array($defaultParam)){
			return array();
		}
		if(!empty($param) && empty($defaultParam)){
			return $param;
		}
		if(empty($param) && !empty($defaultParam)){
			return $defaultParam;
		}
		if(is_array($param) && $merge == false){
			return $param;
		}
		else if(is_array($param) && $merge == true){
			if(!is_array($defaultParam)){
				return $param;
			}
			
			foreach($defaultParam as $key=>$value){
				if(!array_key_exists($key, $param)){
					$param[$key]=$value;
				}
		}
		return $param;
		}
		else{
			return false;
		}
	}
	
	
	/**Unique Attribute 
	*
	*@acess protected
	*@return array
	**/
	protected function uniqueAttri(){
		return $uniqueAttri = array('required', 'disabled', 'checked', 'autofocus', 'readonly', 'novalidate', 'multiple');
	} 
	
	
	/*
	* 
	* Generate Html Element Attributes: return string:
	* 
	@param array
	@return array
	@return boolen
	@return string
	|Output Example:  id="ys" class="className" style="padding:373;"
	*/
	private  function makeHtmlAttr($param, $defaultParam = array(), $merge = true ){
		
		$attributes = $this->mergeAttr($param, $defaultParam, $merge);
		
		if(!is_array($attributes) || empty($attributes)){
			return '';
		}
		$s = "";
		foreach($attributes as $key => $value){
			if(in_array($key, $this->uniqueAttri())){
			 	$s .= " " . $key;
			}
			else{
			 	$s .= " " . $key."=\"".$value."\""." ";
			}
		}
		return $s;
	}
	
	
	/*
	* 
	* Generate Form Input Element:
	* 
	*@acess  public
	*@param array
	*@param boolen
	*@return string
	*@Output Example:  <input type="text">
	*/ 
	public function makeControl($param, $defaultParam, $overWrite =true )
	{
		$tag = "";
		$tag .= $this->makeHtmlAttr($param, $defaultParam, $overWrite);
		return  $element = "<input".$tag.">";
	}
	
	
	/*
	* 
	* Generate Textarea Form Input Element:
	* 
	*@param array
	*@param array
	*
	*@param boolen
	*
	*@return string
	*/ 
	protected function makeTextarea($param, $defaultParam, $overWrite=true){
		
		if(isset($param["value"])){
			$value = $param["value"];
			unset($param["value"]);
		}
		else{
			$value = "";
		}
		
		$tag .= $this->makeHtmlAttr($param, $defaultParam, $overWrite);
		
		$textarea = "";
		$textarea .= "<textarea".$tag.">";
		$textarea .= $value;
		$textarea.= "</textarea>";
		
		return $textarea;
		
	}
	
	
	/*
	|-
	| Default Form Attr  
	|-
	*@acess public
	*@return array
	*/
	public function defaultFormAttr(){
		return array ( 
		'method' => 'post', 
		'autocomplete' => 'on',
		'target' => '_blank',
		'enctype' => 'multipart/form-data',
		);
	} 
	

	/*
	* -
	* Open Form Tag:
	* -
	*@acess public
	*@param array
	*@param boolen
	*@return string
	@Output Example:  <form  action="example.php", method="post", target="_blank", enctype='multipart/form-data'>
	*/ 
	public function beginForm($param, $overWrite = true)
	{
		$attributes = $this->makeHtmlAttr($param, $this->defaultFormAttr(), $overWrite);
		$form="<form".$attributes.">";
		return $form;
	}
	
	public function openForm($param, $overWrite = true)
	{
		return $this->beginForm($param, $overWrite);
	}
	
	/*
	* -
	* Close Form:
	* -
	*@acess public
	@return string
	*/ 
	public function endForm()
	{
		return "</form>";
	}
	
	/*
	* -
	* Close Form:
	* -
	*@acess public
	*@return string
	*/ 
	public function closeForm()
	{
		return $this->endForm();
	}
		
	/*
	* -
	* Generate Html textarea input control:
	* -
	* @param string $name
	* @param string $value
	* @param array  $attr
	*
	*@return string 
	*/ 
	public function textarea($name, $value = '', $attr = array())
	{
		$defaultAttr = array( 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		
		return $this->makeTextarea($attr, $defaultAttr, $overWrite=true);
	}
	
	
	/*
	* -
	*Generate Html Text input control:
	* -
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="text" class="form-control">
	*/ 
	public function text($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'text',  'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html password input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="password" class="form-control">
	*/
	public function password($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'password', 'autocomplete'=>'off',  'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
		
		
	/*
	* --
	* Make html email input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="email" class="form-control">
	*/
	public function email($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'email', 'autocomplete'=>'off',  'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html url input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="url" class="form-control">
	*/
	public function url($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'url', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	/*
	* --
	* Make html tel input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="url" class="form-control">
	*/
	public function tel($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'tel', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html search input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="search" class="form-control">
	*/
	public function search($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'search', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	

	/*
	* --
	* Make html color input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="color" class="form-control">
	*/
	public function color($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'color', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	/*
	* --
	* Make html date input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="date" class="form-control">
	*/
	public function date($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'date', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html datetime input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="datetime" class="form-control">
	*/
	public function datetime($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'datetime', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
		
	}
	
	/*
	* --
	* Make html week input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="week" class="form-control">
	*/
	public function week($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'week', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html month input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="month" class="form-control">
	*/
	public function month($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'month', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}

	
	/*
	* --
	* Make html time input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="time" class="form-control">
	*/
	public function time($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'time', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html file input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="file">
	*/
	public function fileInput($name, $attr = array())
	{
		$defaultAttr = array('type'=>'file');
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html file input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="file">
	*/
	public function file($name, $attr = array())
	{
		return $this->fileInput($name, $attr);
	}

	
	/*
	* --
	* Make html Number input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="time" class="form-control">
	*/
	public function number($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'number', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html range input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="range" class="form-control">
	*/
	public function range($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'range', 'class'=>$this->defaultClass);
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
		
	/*
	* --
	* Make html hidden input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="hidden" class="form-control">
	*/
	public function hidden($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'hidden');
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html Button input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="button" class="form-control">
	*/
	public function button($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'button', 'class'=>'btn btn-default');
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html submit input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="submit" class="form-control">
	*/
	public function submit($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'submit', 'class'=>'btn btn-default');
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
	
	
	/*
	* --
	* Make html reset input control:
	* -----------
	*@param string $name
	*@param string $value
	*@param array  $attr
	*@return string  Example:  <input name="name" value="value"  type="submit" class="form-control">
	*/
	public function reset($name, $value = '', $attr = array())
	{
		$defaultAttr = array('type'=>'reset', 'class'=>'btn btn-default');
		$attr['name'] = $name;
		$attr['value'] = $value;
		return $this->makeControl($attr, $defaultAttr);
	}
		
		
		
	/*
	* 
	* Method for populating Select Option
	* 
	*@acess public
	*@param array $option
	*@param array || string $selected
	*@return string example:
				<option value="key1">Value1</option>
				<option value="key2" selected>value2</option>
				<option value="key3" selected>value3</option>
	*/ 
	public  function makeOption($option, $selected = '')
	{
		$selected = (is_array($selected))? $selected : array($selected);
		if(!is_array($option) || empty($option)){
			return false;
		}
		$output = "";
		foreach($option as $key => $value){
			//dump($value);
			if(in_array($key, $selected) && !empty($selected)){
				//dump($value);
				$output .= "<option value=\"$key\" selected > $value </option>"."\n";
			}
			else if(in_array($value, $selected, true)){
			//dump($value);
			//dump($selected);
				$output .= "<option value=\"$key\" selected > $value </option>"."\n";
			}
			else if(array_key_exists($key, $selected) && !empty($selected)){
				$output .= "<option value=\"$key\" selected > $value </option>"."\n";
			}
			else{
				$output .= "<option value=\"$key\" > $value </option>"."\n";
			}
		}
		return $output;
	}
	
	
	/*
	* 
	* Method for populating Select Option
	* 
	*@acess public
	*@param array $option
	*@param array || string $selected
	*@return string example:
			<select name="name" class="form-control">
				<option value="key1">Value1</option>
				<option value="key2">value2</option>
				<option value="key3">value3</option>
			</select>
	*/
	public function makeSelect($option, $attr, $selected = '' )
	{
		$defaultAttr = array('class'=>$this->defaultClass);
		$attr = $this->makeHtmlAttr($attr, $defaultAttr);
		$s = "<select".$attr.">";
		$s .= $this->makeOption($option, $selected);
		$s .= "</select>";
		return $s;
	}
	
	
	/*
	* -
	* Generating a drop-down select list with or without Selected Default:
	* -
	*@acess public
	*@param string
	*@param array
	*@param array || string
	*@param array
	*@return string,  Example:  
					<select name="name">
						<option value="key" >Value</option>
						<option value="key" selected >Value</option>
					</select>
	*/ 
	public function select($name, $option, $selected = '', $attr = array()){
		$attr['name'] = $name;
		return $this->makeSelect($option, $attr, $selected);
	}
	
	/*
	* 
	* Generate one or more selected Options
	* 
	* @param array $data
	*@return string
	*/ 
	public  function selected($data)
	{
		$data = (array) $data ;
		$s = '';
		foreach($data as $value => $title){
			$s .= "\n"."<option value='$value' selected=\"selected\"> $title </option>"."\n";
		}
		return $s;
	} 
		
		
	/*
	* 
	* Generate empty Option
	* 
	*@acess public
	*@return string
	*/ 
	public  function emptyOption()
	{
		return "\n"."<option value=''> Select </option>"."\n";
	} 
		
	
	/*
	* --
	* Generating A Drop-Down List With A Range
	* -----------
	|@acess public
	|@param string $name
	|@param int $min :  Required. Specifies the lowest value of the array
	|@param int max 	Required. Specifies the highest value of the array
	|@param int step 	Optional. Specifies the increment used in the range. Default is 1
	|@return string example: 
					<select name="range">
						<option value="1" >1</option>
						<option value="2" >2</option>
					</select>
	*/
	public function selectRange($name, $min, $max, $step = 1,  $selected = null, $attr = array())
	{	
		$o = range($min, $max, $step);
		$option = array();
		if(is_array($o) && !empty($o)){
			foreach($o as $key => $value){
				$option[$value] =  $value;
			}
		}
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	/*
	* 
	* Get Day: 1-31
	*@return array
	*/ 
	public   function dayOption(){
		$day = array();
		for($d = 1; $d <= 31; $d++){
		 $day[$d]=$d;
		}
		return $day;
	} 

	/*
	* --
	* Generating drop-down List of day
	* -----------
	|@acess public
	|@param string $name
	|@param array || string 
	|@param param $attr
	|@return string example: 
					<select name="day">
						<option value="1" >1</option>
						<option value="2" >2</option>
					</select>
	*/
	public function selectDay($name, $selected = '', $attr = array())
	{
		$option = $this->dayOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	/*
	* 
	*Get Month: 1 2 3 4
	*@acess public
	*@return array
	*/ 
	public   function monthOption(){
		$month = array();
		for($m = 1; $m <= 12; $m++){
			$month[$m]=$m;
		}
		return $month;
	} 
	
	
	/*
	* --
	* Generating drop-down List of days
	* -----------
	|@acess public
	|@param string $name
	|@param array || string 
	|@param param $attr
	|@return string example: 
					<select name="day">
						<option value="1" >1</option>
						<option value="2" >2</option>
					</select>
	*/
	public function selectMonth($name, $selected = '', $attr = array())
	{
		$option = $this->monthOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	/*
	* --
	* Generating drop-down List of years
	* -----------
	|@acess public
	|@param string $name
	|@param array || string 
	|@param int   $yearsBack
	|@param param $attr
	|@return string example: 
					<select name="year">
						<option value="1983" >1983</option>
						<option value="1984" >1984</option>
					</select>
	*/
	public   function selectYear($name,  $selected = '', $yearsBack = 100, $attr = array())
	{
		
		$currentYear = date('Y');
		$min = $currentYear - $yearsBack;
		$option =  range($min, $currentYear, 1);
		return $this->select($name, $option, $selected, $attr);

	} 
	
	
	/*
	* 
	*Get title Option: 
	*@acess public
	*@return array
	*/ 
	public function titleOption(){
		return array(
			"Mr"=>"Mr", 
			"Mrs"=>"Mrs", 
			"Miss"=>"Miss", 
			"Ms"=>"Ms", 
			"Dr"=>"Dr", 
			"Prof"=>"Prof"
		);
	}
	
	
	/*
	* --
	* Generating drop-down List of title
	* -----------
	|@acess public
	|@param string $name
	|@param array || string $selected
	|@param param $attr
	|@return string example: 
					<select name="title">
						<option value="Mr" >Mr</option>
						<option value="Mrs" >Mrs</option>
					</select>
	*/
	public function selectTitle($name, $selected = '', $attr = array())
	{
		$option = $this->titleOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	
	/*
	|-
	| Get Gender Option: 
	|-
	*@acess public
	*@return array
	*/
	public function genderOption(){
		return array(
			"Male"=>"Male", 
			"Female"=>"Female", 
			"Other"=>"other",
		);
	}
	
	
	/*
	* --
	* Generating drop-down List of gender
	* -----------
	|@acess public
	|@param string $name
	|@param array || string $selected
	|@param param $attr
	|@return string example: 
					<select name="title">
						<option value="Mr" >Mr</option>
						<option value="Mrs" >Mrs</option>
					</select>
	*/
	public function selectGender($name, $selected = '', $attr = array())
	{
		$option = $this->genderOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	
	/*
	|-
	| Get Counry Code Option: 
	|--
	@return array
	*/
	public function countryCodeOption()
	{
		return array(
		'AF'=>'Afghanistan',
		'AL'=>'Albania',
		'DZ'=>'Algeria',
		'AS'=>'American Samoa',
		'AD'=>'Andorra',
		'AO'=>'Angola',
		'AI'=>'Anguilla',
		'AQ'=>'Antarctica',
		'AG'=>'Antigua And Barbuda',
		'AR'=>'Argentina',
		'AM'=>'Armenia',
		'AW'=>'Aruba',
		'AU'=>'Australia',
		'AT'=>'Austria',
		'AZ'=>'Azerbaijan',
		'BS'=>'Bahamas',
		'BH'=>'Bahrain',
		'BD'=>'Bangladesh',
		'BB'=>'Barbados',
		'BY'=>'Belarus',
		'BE'=>'Belgium',
		'BZ'=>'Belize',
		'BJ'=>'Benin',
		'BM'=>'Bermuda',
		'BT'=>'Bhutan',
		'BO'=>'Bolivia',
		'BA'=>'Bosnia And Herzegovina',
		'BW'=>'Botswana',
		'BV'=>'Bouvet Island',
		'BR'=>'Brazil',
		'IO'=>'British Indian Ocean Territory',
		'BN'=>'Brunei',
		'BG'=>'Bulgaria',
		'BF'=>'Burkina Faso',
		'BI'=>'Burundi',
		'KH'=>'Cambodia',
		'CM'=>'Cameroon',
		'CA'=>'Canada',
		'CV'=>'Cape Verde',
		'KY'=>'Cayman Islands',
		'CF'=>'Central African Republic',
		'TD'=>'Chad',
		'CL'=>'Chile',
		'CN'=>'China',
		'CX'=>'Christmas Island',
		'CC'=>'Cocos (Keeling) Islands',
		'CO'=>'Columbia',
		'KM'=>'Comoros',
		'CG'=>'Congo',
		'CK'=>'Cook Islands',
		'CR'=>'Costa Rica',
		'CI'=>'Cote D\'Ivorie (Ivory Coast)',
		'HR'=>'Croatia (Hrvatska)',
		'CU'=>'Cuba',
		'CY'=>'Cyprus',
		'CZ'=>'Czech Republic',
		'CD'=>'Democratic Republic Of Congo (Zaire)',
		'DK'=>'Denmark',
		'DJ'=>'Djibouti',
		'DM'=>'Dominica',
		'DO'=>'Dominican Republic',
		'TP'=>'East Timor',
		'EC'=>'Ecuador',
		'EG'=>'Egypt',
		'SV'=>'El Salvador',
		'GQ'=>'Equatorial Guinea',
		'ER'=>'Eritrea',
		'EE'=>'Estonia',
		'ET'=>'Ethiopia',
		'FK'=>'Falkland Islands (Malvinas)',
		'FO'=>'Faroe Islands',
		'FJ'=>'Fiji',
		'FI'=>'Finland',
		'FR'=>'France',
		'FX'=>'France, Metropolitan',
		'GF'=>'French Guinea',
		'PF'=>'French Polynesia',
		'TF'=>'French Southern Territories',
		'GA'=>'Gabon',
		'GM'=>'Gambia',
		'GE'=>'Georgia',
		'DE'=>'Germany',
		'GH'=>'Ghana',
		'GI'=>'Gibraltar',
		'GR'=>'Greece',
		'GL'=>'Greenland',
		'GD'=>'Grenada',
		'GP'=>'Guadeloupe',
		'GU'=>'Guam',
		'GT'=>'Guatemala',
		'GN'=>'Guinea',
		'GW'=>'Guinea-Bissau',
		'GY'=>'Guyana',
		'HT'=>'Haiti',
		'HM'=>'Heard And McDonald Islands',
		'HN'=>'Honduras',
		'HK'=>'Hong Kong',
		'HU'=>'Hungary',
		'IS'=>'Iceland',
		'IN'=>'India',
		'ID'=>'Indonesia',
		'IR'=>'Iran',
		'IQ'=>'Iraq',
		'IE'=>'Ireland',
		'IL'=>'Israel',
		'IT'=>'Italy',
		'JM'=>'Jamaica',
		'JP'=>'Japan',
		'JO'=>'Jordan',
		'KZ'=>'Kazakhstan',
		'KE'=>'Kenya',
		'KI'=>'Kiribati',
		'KW'=>'Kuwait',
		'KG'=>'Kyrgyzstan',
		'LA'=>'Laos',
		'LV'=>'Latvia',
		'LB'=>'Lebanon',
		'LS'=>'Lesotho',
		'LR'=>'Liberia',
		'LY'=>'Libya',
		'LI'=>'Liechtenstein',
		'LT'=>'Lithuania',
		'LU'=>'Luxembourg',
		'MO'=>'Macau',
		'MK'=>'Macedonia',
		'MG'=>'Madagascar',
		'MW'=>'Malawi',
		'MY'=>'Malaysia',
		'MV'=>'Maldives',
		'ML'=>'Mali',
		'MT'=>'Malta',
		'MH'=>'Marshall Islands',
		'MQ'=>'Martinique',
		'MR'=>'Mauritania',
		'MU'=>'Mauritius',
		'YT'=>'Mayotte',
		'MX'=>'Mexico',
		'FM'=>'Micronesia',
		'MD'=>'Moldova',
		'MC'=>'Monaco',
		'MN'=>'Mongolia',
		'MS'=>'Montserrat',
		'MA'=>'Morocco',
		'MZ'=>'Mozambique',
		'MM'=>'Myanmar (Burma)',
		'NA'=>'Namibia',
		'NR'=>'Nauru',
		'NP'=>'Nepal',
		'NL'=>'Netherlands',
		'AN'=>'Netherlands Antilles',
		'NC'=>'New Caledonia',
		'NZ'=>'New Zealand',
		'NI'=>'Nicaragua',
		'NE'=>'Niger',
		'NG'=>'Nigeria',
		'NU'=>'Niue',
		'NF'=>'Norfolk Island',
		'KP'=>'North Korea',
		'MP'=>'Northern Mariana Islands',
		'NO'=>'Norway',
		'OM'=>'Oman',
		'PK'=>'Pakistan',
		'PW'=>'Palau',
		'PA'=>'Panama',
		'PG'=>'Papua New Guinea',
		'PY'=>'Paraguay',
		'PE'=>'Peru',
		'PH'=>'Philippines',
		'PN'=>'Pitcairn',
		'PL'=>'Poland',
		'PT'=>'Portugal',
		'PR'=>'Puerto Rico',
		'QA'=>'Qatar',
		'RE'=>'Reunion',
		'RO'=>'Romania',
		'RU'=>'Russia',
		'RW'=>'Rwanda',
		'SH'=>'Saint Helena',
		'KN'=>'Saint Kitts And Nevis',
		'LC'=>'Saint Lucia',
		'PM'=>'Saint Pierre And Miquelon',
		'VC'=>'Saint Vincent And The Grenadines',
		'SM'=>'San Marino',
		'ST'=>'Sao Tome And Principe',
		'SA'=>'Saudi Arabia',
		'SN'=>'Senegal',
		'SC'=>'Seychelles',
		'SL'=>'Sierra Leone',
		'SG'=>'Singapore',
		'SK'=>'Slovak Republic',
		'SI'=>'Slovenia',
		'SB'=>'Solomon Islands',
		'SO'=>'Somalia',
		'ZA'=>'South Africa',
		'GS'=>'South Georgia And South Sandwich Islands',
		'KR'=>'South Korea',
		'ES'=>'Spain',
		'LK'=>'Sri Lanka',
		'SD'=>'Sudan',
		'SR'=>'Suriname',
		'SJ'=>'Svalbard And Jan Mayen',
		'SZ'=>'Swaziland',
		'SE'=>'Sweden',
		'CH'=>'Switzerland',
		'SY'=>'Syria',
		'TW'=>'Taiwan',
		'TJ'=>'Tajikistan',
		'TZ'=>'Tanzania',
		'TH'=>'Thailand',
		'TG'=>'Togo',
		'TK'=>'Tokelau',
		'TO'=>'Tonga',
		'TT'=>'Trinidad And Tobago',
		'TN'=>'Tunisia',
		'TR'=>'Turkey',
		'TM'=>'Turkmenistan',
		'TC'=>'Turks And Caicos Islands',
		'TV'=>'Tuvalu',
		'UG'=>'Uganda',
		'UA'=>'Ukraine',
		'AE'=>'United Arab Emirates',
		'UK'=>'United Kingdom',
		'US'=>'United States',
		'UM'=>'United States Minor Outlying Islands',
		'UY'=>'Uruguay',
		'UZ'=>'Uzbekistan',
		'VU'=>'Vanuatu',
		'VA'=>'Vatican City (Holy See)',
		'VE'=>'Venezuela',
		'VN'=>'Vietnam',
		'VG'=>'Virgin Islands (British)',
		'VI'=>'Virgin Islands (US)',
		'WF'=>'Wallis And Futuna Islands',
		'EH'=>'Western Sahara',
		'WS'=>'Western Samoa',
		'YE'=>'Yemen',
		'YU'=>'Yugoslavia',
		'ZM'=>'Zambia',
		'ZW'=>'Zimbabwe'
		);
	}
	
	
	/*
	|-
	| Get Counry Option: 
	|-
	@return array
	*/
	public function countryOption()
	{
		$data = $this->countryCodeOption();
		$country = array();
		foreach($data as $key => $value){
			$country[$value] = $value;
		}
		return $country;
	}
	
	
	/*
	* --
	* Generating drop-down List of country
	* -----------
	|@acess public
	|@param string $name
	|@param array || string $selected
	|@param param $attr
	|@return string example: 
					<select name="title">
						<option value="Mr" >Mr</option>
						<option value="Mrs" >Mrs</option>
					</select>
	*/
	public function selectCountry($name, $selected = '', $attr = array())
	{
		$option = $this->countryOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	
	
	/*
	* --
	* Generating drop-down List of country code
	* -----------
	|@acess public
	|@param string $name
	|@param array || string $selected
	|@param param $attr
	|@return string example: 
					<select name="title">
						<option value="Mr" >Mr</option>
						<option value="Mrs" >Mrs</option>
					</select>
	*/
	public function countryCode($name, $selected = '', $attr = array())
	{
		$option = $this->countryCodeOption();
		return $this->select($name, $option, $selected, $attr);
	}
	
	

	/*
	* 
	* Method for generating html radio input
	* 
	*@acess public
	*@param string $name
	*@param array $option
	*@param string $checked
	*@param array $attr
	*@return string example:
				  <input type="radio" name="gender" value="male" checked> Male<br>
  				  <input type="radio" name="gender" value="female"> Female<br>
  				  <input type="radio" name="gender" value="other"> Other<br><br>
	*/ 
	public  function makeRadio($name, $option, $checked = '', $attr = array())
	{
		if(!is_array($option) || empty($option)){
			return '';
		}
		$s = "";
		foreach($option as $key => $value){
			
			$attr['name'] = $name;
			$attr['type'] = "radio";
			$attr['value'] = $key;
			$attr['id'] = uniqid(rand());
			
			if($selected == $key ){
				$attr['checked'] = 'checked';
			}
			
			$as = $this->makeHtmlAttr($attr);
			$s .= "<input".$as."> &nbsp; &nbsp;" . $value. "\n";
			
		}
		return $s;
	}
	

	/*
	* 
	* This method is an aliase of makeRadio
	*/ 
	public  function radio($name, $option, $checked = '', $attr = array())
	{
		return $this->makeRadio($name, $option, $checked, $attr);
	}
	
	
	/*
	* 
	* Method for generating html checkbox input
	* 
	*@acess public
	*@param string $name
	*@param array $option
	*@param string $checked
	*@param array $attr
	*@return string example:
				  <input type="checkbox" name="gender" value="male" checked> Male<br>
  				  <input type="checkbox" name="gender" value="female"> Female<br>
  				  <input type="checkbox" name="gender" value="other"> Other<br><br>
	*/ 
	public  function makeCheckbox($name, $option, $checked = '', $attr = array())
	{
		if(!is_array($option) || empty($option)){
			return '';
		}
		$s = "";
		foreach($option as $key => $value){
			
			$attr['name'] = $name . "[]";
			$attr['type'] = "checkbox";
			$attr['value'] = $key;
			$attr['id'] = uniqid(rand());
			
			if(array_key_exists($key, $checked)){
				$attr['checked'] = 'checked';
			}
			else if(in_array($key,  $checked)){
				$attr['checked'] = 'checked';
			}
			
			$as = $this->makeHtmlAttr($attr);
			if(isset($attr['checked'])){
				unset($attr['checked']);
			}
			$s .= "<div> <input".$as."> &nbsp; &nbsp;" . $value. "</div>\n";
			
		}
		return $s;
	}
	
	
	/*
	* 
	* This method is an aliase of makeRadio
	*/ 
	public  function checkbox($name, $option, $checked = '', $attr = array())
	{
		return $this->makeCheckbox($name, $option, $checked, $attr);
	}


 }
 
//http://xdsoft.net/jqplugins/datetimepicker/