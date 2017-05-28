<?php
namespace BigMayor\Html;
/**
 * Html Navigation and List Generator
 *
 * @author  Allan Amevor
 * @website: http://www.amevon.com
 * @Last Update 16/07/2016
 
 * Implementation Example:
 *
 * -------------------------------- STEP 1:--------------------------------
	 Create Data Structure like this:	
	 $data = [
		0 => [
				'id' => 1, //Possible "id" key could be: 'id', "menu_id", "term_id"
				'url' => 'http://www.amevon.com',
				'title' => 'News', //Possible "title" key could be: 'menu_title', "title", "label", "name"
				'target' => '_parent',
				'parent' => 0,  //Possible "parent" key could be: 'parent', "parent_id"
				'prepend' => '', 
			    'append' => '', 
			],
		1 => [
				'id' => 2,
				'url' => 'http://www.amevon.com',
				'title' => 'Shop',
				'target' => '_self',
				'parent' => 0,
			],
		1 => [
				'id' => 3,
				'url' => 'http://www.amevon.com',
				'title' => 'Home',
				'target' => '_self',
				'parent' => 2,
				'prepend' => '', 
			    'append' => '', 
			],
	]

* -----------------------STEP 2:---------------------------------------
* create obj like this:
* $obj = new NavMaker();

* --------------------------------------STEP 3--------------------------
* Call any of this method depending on your need:
 
* 					  $param = ["before"=>"", "after"=>"", "col_class"=>"", "col_no"=>3"]
* $obj->makeMegaNav($data, $param);  // Create mega dropdown menu


* 					$param = [
							"before"=>string, 
							"after"=>string, 
							"liAttr"=>array(), 
							"LinkAttr"=>array", 
							"isLink"=>bool",
							"addBadge"=>bool",
							"badgeClass"=>"string"
						]
* $obj->makeNav($data, $param); // This create flat or single menu


						* $param = [
								"before"=>"", //string, 
								"after"=>"", //string, 
								"liAttr"=>array(), 
								"LinkAttr"=>array,
								"dropdownLi" => array,
								"dropdownLink" => array, 
								"dropdownU" => array,  
								"dropdownIndicator" => '<b class=\"caret\"></b> ',   //string  
								"isLink"=>bool",
								"addBadge"=>bool",
								"badgeClass"=>"string"
							]
* $obj->makeDropdownNav($data, $param); // This create dropdown menu
*
*/
class NavMaker
{
	
	protected $data;
	protected $id; 
	protected $title;
	protected $src;
	protected $url;
	protected $target;
	protected $activeClass;
	protected $listType = 'ul';
	protected $listChild;
	protected $totalChilderen;
	protected $childeren;
	
	protected $liAttr;
	protected $LinkAttr;
	protected $dropdownLi;
	protected $dropdownLink;
	protected $dropdownU;
	protected $dropdownIndicator;
	protected $isLink;
	protected $append;
	protected $prepend;
	protected $badgeClass;
	
	/*
	* Set Parent It:
	* @param array $data
	* return void
	*
	*/
	protected  function setParentId($param){
	
		if(isset($param["parent_id"])){
			$this->parentId = (int) $param["parent_id"];
		}
		else if((isset($param["parent"]))){
			$this->parentId = (int) $param["parent"];
		}
	}
		
	
	/*
	* Set Id:
	* @param array $data
	* return void
	*
	*/
	protected  function setId($param){
		
		if(isset($param["id"])){
			$this->id = (int) $param["id"];
		}
		else if((isset($param["menu_id"]))){
			$this->id = (int) $param["menu_id"];
		}
		else if((isset($param["term_id"]))){
			$this->id = (int) $param["term_id"];
		}
	}
	
	
	/*
	* Set Url:
	* @param array $data
	* return void
	*
	*/
	protected  function setUrl($param){

		if(isset($param["url"])){
			$this->url = $param["url"];
		}
		else if((isset($param["link"]))){
			$this->url = $param["link"];
		}
	}
	
	
	/*
	* Set Title or Label:
	* @param array $data
	* return void
	*
	*/
	protected  function setTitle($param){
		
		if(isset($param["title"])){
			$this->title = $param["title"];
		}
		else if(isset($param["menu_title"])){
			$this->title = $param["menu_title"];
		}
		else if(isset($param["label"])){
			$this->title = $param["label"];
		}
		else if(isset($param["name"])){
			$this->title = $param["name"];
		}
		
	}
	
	/*
	* Set Link Target:
	* @param array $data
	* return void
	*
	*/
	protected  function setTarget($param){
		
		if(isset($param["target"])){
			$this->target = $param["target"];
		}
		
	}
	

	/*
	* Get Item Properties:
	* @param array $data
	* return void
	*
	*/
	protected  function setItemProperties($param){
		
		$this->prepend = (isset($param["prepend"])) ? $param["prepend"] : "";
		$this->append = (isset($param["append"])) ? $param["append"] : "";

		$this->setParentId($param);
		$this->setId($param);
		$this->setUrl($param);
		$this->setTitle($param);
		$this->setTarget($param);
	}

	
	/*
	* Set active class:
	* @param array string
	* return $this
	*
	*/
	protected  function setActiveClass($class){
		$this->activeClass = $class;
		return $this;	
	}
	
	
	/*
	* Convert attribute in array to html string:
	* acess public
	* @param array $attributes
	*
	* return : Output Example:  id="ys" class="className" style="padding:373;"
	*
	*/
	protected  function attrToSrting( $attributes = array())
	{
		
		$tag="";
		if(is_array($attributes) and !empty($attributes)){
			foreach($attributes as $key=>$value){
				if(!empty($value)){
					$tag.=" ".$key."=\"".$value."\""." ";
				}
			}
		}
		return $tag;
		
	}
	
	
	/*
	* Open Tag
	* acess public
	* @param array $attributes
	*
	* return string : Example: <li id="ys" class="className" style="padding:373;">  </li>
	*
	*/
	protected  function beginTag($tag,$attributes){
		
		$attr = $this->attrToSrting($attributes);
		return "<".$tag." ".$attr .">"."\n";
	}	

	protected  function beginList($listType, $attributes){
	
		$s = $this->attrToSrting($attributes);
		$html = "<".$listType." ".$s .">"."\n";
		return $html;
	}

	/*
	* Close ul || ol || div
	* return : string   :example: </ul> || </ol> || </div>
	*
	*/
	protected function endList(){
		
		if($this->listType =='ul' ){
			return '</ul>'."\n";
		}
		else if($this->listType == 'ol'){
			return '</ol>'."\n";
		}
		else if($this->listType == 'div'){
			return '</div>'."\n";
		}
	}
	
	
	/*
	* Close ul || ol || div
	* @param array $childAttr
	*
	* return : string
	* example: <div id="ys" class="className" style="padding:373;">  </div>
	*/	
	protected function beginItem($childAttr){
		
		if($this->listType == 'ul' || $this->listType == 'ol'){
			$this->listChild = 'li';
		}
		else if($this->listType == 'div'){
			$this->listChild  = 'div';
		}
		$attributes = $this->attrToSrting($childAttr);
		return "<".$this->listChild." ".$attributes .">" . "\n";
	}
	
	
	/*
	* End List Item </li> || </div>
	* acess protected 
	* return : string
	* example: </li> || </div>
	*/	
	protected function endItem(){
		
		if($this->listType == 'ul' || $this->listType == 'ol'){
			return '</li>'."\n";
		}
		else if($this->listType == 'div'){
			return '</div>'."\n";
		}
	}
	
	/*
	* Set Badge:
	* return void
	*
	*/
	protected  function setBadge(){
	
		if($this->addBadge==false){
			return false;
		}
		$this->totalChilderen = (int) $this->totalChilderen;
		if(isset($this->totalChilderen) and $this->totalChilderen > 0){
			return "<span class=\"$this->badgeClass\">$this->totalCount</span>";
		}
	
	}
	
	
	/*
	* Create html title and link it if possible
	* acess public
	* @param array $linkAttr
	* @param string $indicator
	* return string
	*
	*/
	protected  function makeLabel($linkAttr, $indicator =''){
	
		$label="";
		if(!empty($this->prepend)){
			$label .= $this->prepend." ".$this->title;
		}
		else{
			$label .= $this->title;
		}
		if(!empty($this->append)){
			$label .= " " . $this->append;
		}
		$setBadge = $this->setBadge();
		
		if($setBadge !== false && !empty($setBadge)){
			$label .= $setBadge;
		}

		$label = (!empty($indicator))? $label ." ". $indicator : $label;
		
		if(!empty($this->url) && $this->isLink !== false){
			$linkAttr['href'] = $this->url;
			return $this->beginTag('a',$linkAttr).$label."</a>";
		}
		else{
			return $label;
		}
	}
	
	
	/* 
	* Get Level Menu:
	* acess protected 
	* @param array
	* @param int $parentId
	* return : array
	*/
	protected function getLevelMenu($data, $parentId){
	
		$levelMenu = array();
		$total = 0;
		if(empty($data)){
			return false;
		}
		foreach($data as $key=>$menu){
			if(isset($menu["parent_id"]) && $menu["parent_id"] == $parentId){
				$levelMenu[] = $menu;
				$total++;
			}
			else if(isset($menu["parent"]) && $menu["parent"] == $parentId){
				$levelMenu[]  = $menu;
				$total++;
			}
		}
		$this->totalChilderen = $total;
		return $levelMenu;
	
	}
	
	
	/* 
	* Has current menu item has any child
	* acess protected 
	* @param array
	* @param int $parentId
	* return : int
	*/
	protected function hasChild($data, $id){
														
		$total = false;
		if(empty($data)){
			return false;
		}
		foreach($data as $key => $item){
		    $parentId = null;
			if(isset($item["parent_id"])){
				$parentId = (int) $item["parent_id"];
			}
			else if((isset($item["parent"]))){
				$parentId = (int) $item["parent"];
			}
			//var_dump($parentId); 
			//var_dump($this->parentId); exit;
			if( $parentId == $id){
				$total = true;
				break;
			}
		}
		return (bool) $total;
	}
	
	
	/* 
	* Has current menu item have childeren
	* acess protected 
	* @param array
	* @param int $parentId
	* return : int
	*/
	protected function hasChilderen($data, $id){
		$total = 0;
		if(empty($data)){
			return false;
		}
		foreach($data as $key => $item){
			$this->setItemProperties($item);
			if( $id === $this->parentId){
			$total++;
			$this->childeren[$key] = $item;
			}
		}
		return $this->totalChilderen = (int) $total;
	}
	
	
	/*
	* Set Attirbutes
	* @param array $v
	*
	* return void
	*
	*/
	protected  function setAttr($v){
	    
		$this->before = (isset($v["before"])) ? $v["before"] : '';
		$this->after = (isset($v["after"])) ? $v["after"] : '';
		$this->liAttr = (isset($v["liAttr"])) ? $v["liAttr"] : [];
		$this->LinkAttr = (isset($v["LinkAttr"]))? $v["LinkAttr"]: [];
		$this->dropdownLi = (isset($v["dropdownLi"]))? $v["dropdownLi"]: [];
		$this->dropdownLink = (isset($v["dropdownLink"]))? $v["dropdownLink"] : [];
		$this->dropdownU = (isset($v["dropdownU"]))? $v["dropdownU"]: [];
	    $this->dropdownIndicator = (isset($v["dropdownIndicator"]))? $v["dropdownIndicator"]: "<b class=\"caret\"></b> ";
		$this->isLink = (isset($v["isLink"]))?$v["isLink"]:true;
		$this->addBadge = (isset($v["addBadge"]) && is_bool($v["addBadge"]))?$v["addBadge"]:false;
		$this->badgeClass = (isset($v["badge_class"]))?$v["badge_class"]:'badge';
		
	}
	
	
	/* 
	* Make Flat Menu: That is menu without dropdown
	* 
	* @param array $data
	* @param array $attr $attr["before"] = 	"<ul class=\"possible-class\">";
						$attr["after"] =     "</ul>";
						$attr["liAttr"] = ["class"=>"li-class"];
						$attr["LinkAttr"] = ["class"=>"Link Class"];
	*@return string
	*/
	public function makeNav($data, $attr = array()){
		
		if(empty($data) || !is_array($data)){
			return false;
		}
		$this->setAttr($attr);
		$s = !empty($this->before)? $this->before."\n" : '';
		foreach($data as $key => $param){
			$this->setItemProperties($param);
			$s .= $this->beginItem($this->liAttr)."\n";
			$s .= $this->makeLabel($this->LinkAttr);
			$s .= $this->endItem()."\n";//li	
		}
	 $s .= $this->after;
	return  $s;
	}
	

	/* 
	* Make Dropdown Menu::
	* 
	* @param array $data
	* @param array $attr $attr["before"] = 	"<div class=\"navbar yamm navbar-default navbar-fixed-top\">
											<div class=\"container\">
											<ul class=\"nav navbar-nav\">";
						$attr["after"] =     "</ul> </div> </div>";
						$attr["dropdownLi"] = ["class"=>"dropdown"];
						$attr["dropdownLink"] = ["class"=>"dropdown-toggle", "data-toggle"=>"dropdown"];
						$attr["dropdownU"] =   ["class"=>"dropdown-menu"];
	*@return string
	*/
	public function makeDropdownNav($data, $attr = array())
	{
		if(empty($data) || !is_array($data)){
			return false;
		}
		$this->setAttr($attr);
		$topMenu = $this->getLevelMenu($data, 0);
		$s = $this->before."\n";
		
		foreach($topMenu as $key => $param){
			$this->setItemProperties($param);
			$hasChild = $this->hasChild($data, $this->id);
			$subLevelMenu = array();
			
			$arrow = "";
			$LinkAttr = [];
			$liAttr = [];
			if($hasChild == true){
				$liAttr = $this->liAttr + $this->dropdownLi;
				$LinkAttr = $this->LinkAttr + $this->dropdownLink;
				$subLevelMenu = $this->getLevelMenu($data, $this->id);
				$arrow = $this->dropdownIndicator;
			}
			$s .= $this->beginItem($liAttr)."\n";
			$s .= $this->makeLabel($LinkAttr, $arrow);
			
			$arrow = '';
			//Print sub Menu here:
			if(!empty($subLevelMenu)){
				$s .= $this->makeLevel_1($subLevelMenu, $data);
			}
			$s .= $this->endItem()."\n";//li
		}
	 $s .= $this->after;
	return  $s;
	}

  
   /* 
	* Make first level Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	protected function makeLevel($levelData, $data, $callBack =''){
	
		if(empty($levelData)){
			return false;
		}
		$s = "";
		$s .= $this->beginList($this->listType, $this->dropdownU);
		
		foreach( $levelData as $key => $subMenu){
		
			$this->setItemProperties($subMenu);
			$hasChild = $this->hasChild($data, $this->id);
			$arrow = "";
			$LinkAttr = [];
			$liAttr = [];
			
			if($hasChild == true){
				$liAttr = $this->liAttr + $this->dropdownLi;
				$LinkAttr = $this->LinkAttr + $this->dropdownLink;
				$arrow = $this->dropdownIndicator;
			}
			$s .= $this->beginItem($liAttr);
			$s .= $this->makeLabel($LinkAttr, $arrow);
			 $arrow = '';
			
			//Print sub Menu here:
			$subLevelMenu = $this->getLevelMenu($data, $this->id);
			
			if(!empty($subLevelMenu) && !empty($callBack)){
				$s .= call_user_func_array(array(__CLASS__, $callBack), [$subLevelMenu, $data]);
			}
			$s .= $this->endItem();//li
		}
		$s .= $this->endList();//ul
		return $s;
	}

  
   /* 
	* Make  level 1 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_1($levelData, $data){
		return $this->makeLevel($levelData, $data, "makeLevel_2");
	}
	
	/* 
	* Make  level 2 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_2($levelData, $data){
	
		return $this->makeLevel($levelData, $data, "makeLevel_3");
	}
	
	/* 
	* Make level 3 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_3($levelData, $data){
		return $this->makeLevel($levelData, $data, "makeLevel_4");
	}

	/* 
	* Make level 4 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_4($levelData, $data){
		return $this->makeLevel($levelData, $data, "makeLevel_5");
	}
	
	/* 
	* Make level 5 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_5($levelData, $data){
		return $this->makeLevel($levelData, $data, "makeLevel_6");
	}
	
	/* 
	* Make level 5 Menu MarkUp:
	* acess public 
	* @param array $levelData
	* @param array $data
	* return : string
	*/
	public function makeLevel_6($levelData, $data){
		return $this->makeLevel($levelData, $data);
	}
	
	
	
	/* 
	* Make Nav
	* acess public 
	* @param array
	* @param array $param = ["before"=>"", "after"=>"", "col_class"=>"", "col_no"=>3"]
	*
	* return : string
	* 
	*/
	public function makeMegaNav($data, $param = []){
	
		//Get before tags:	
		if(isset($param["before"])){
			$before = $param["before"];
		}
		else{
			$before = "<div class=\"navbar yamm navbar-default navbar-fixed-top\">
						<div class=\"container\">
							<ul class=\"nav navbar-nav\">\n";
		}
	
		//Get after tags:	
		if(isset($param["after"])){
			$after = $param["after"];
		}
		else{
			$after = "</ul>     
							</div>
								</div>\n";
		}
		$col_class = (!empty($param["col_class"]))? $param["col_class"] :  "col-sm-4  dnav-v1";
		$col_no = (!empty($param["col_no"]))? $param["col_no"] :  3;
		
		$topNav = $this->getLevelMenu($data, 0);
		
		//var_dump($topNav);
		$s = $before;
		
		foreach($topNav as $key => $nav){
			
			$this->setItemProperties($nav);
			$parentId = $this->parentId;
			$id = $this->id;
			//$totalCount = $this->totalCount;
			$url = $this->url;
			$title = $this->title;
			$hasChilderen = $this->hasChilderen($data, $id);

			if(empty($this->childeren)){
				$s .= "<li> <a href=\"$url\" > $title </a> </li>\n";
			}
			else if(!empty($this->childeren)){
			
			$cData = $this->partition( $this->childeren, $col_no);
			$s .= "
			 <li class=\"dropdown yamm-fw\">
            	<a href=\"$url\" data-toggle=\"dropdown\" class=\"dropdown-toggle\">$title<b class=\"caret\"></b></a> 
                 <ul class=\"dropdown-menu\">
               		 <li>
                		<div class=\"yamm-content\">
                     		<div class=\"row\">\n";
						
						for($x = 0; $x < $col_no; $x++){
							$col_data = (isset($cData [$x]))? $cData[$x] : array();
							$s .= $this->makeUlCol($col_data, $col_class);
						}

			         $s .= "</div>
                 		</div>
                	</li>
                </ul>
            </li>\n";
			}
			$this->childeren = [];
		}
		
		$s .= $after;
		return $s;
	}
	
	
	/* 
	* Make ul col
	* acess protected 
	* @param array
	* @param string
	* return : string
	*/
	protected function makeUlCol($data, $col_class = "col-sm-4")
	{
	 	if(empty($data)){
			return false;
		}
		$s = "<ul class=\"$col_class\">\n";
		foreach($data as $key => $nav){
			$this->setItemProperties($nav);
			$s .= "<li> <a href=\"$this->url\" > $this->title </a> </li>\n";
		}
		$s .= "</ul>\n";
		return $s;
		
	}


	/* 
	* Divide an array into a desired number of split lists 
	* 
	* @param array $list
	* @param int $p
	*
	* return : array
	*/
	public function partition( $list, $p ) 
	{
		if(empty( $list)){
			return false;
		}
		$listlen = count( $list );
		$partlen = floor( $listlen / $p );
		$partrem = $listlen % $p;
		$partition = array();
		$mark = 0;
		
		for ($px = 0; $px < $p; $px++) {
			$incr = ($px < $partrem) ? $partlen + 1 : $partlen;
			$partition[$px] = array_slice( $list, $mark, $incr );
			$mark += $incr;
		}
		return $partition;
	}
	
	
		
	/*
	* Generate Html stucture for breadcrum
	*
	* @param array $data
	* @param string $arrow
	*
	* return string
	*/	
	public function breadcrumb($data, $arrow = '&rarr;')
	{
		if(empty($data) || !is_array($data)){
			return "";
		}
		$s = (isset($attr["before"])) ? $attr["before"] : '';
		$s .= (isset($attr["after"])) ? $attr["after"] : '';
		
		foreach($data as $menu){
			
			$url =  (!empty($menu["url"])) ? $menu["url"] : '';
			$title =  (!empty($menu["title"])) ? $menu["title"] : '';
			$active =  (!empty($menu["current"])) ? $menu["current"] : '';
			
			if(!empty($url) and !empty($active)){
			  $s .= " <li class=\"active\"> $title </li>";
			}
			else if(!empty($url) and empty($active) and !empty($title)){
			  $s .= "<li><a href=\"$url\"> $title  $arrow</a></li>";
			}
		}
		return $s;
	
	}
	
	
	/*
	* Get Url 
	*
	* @param array $data
	*
	* return string
	*/	
	public function getUrl($data)
	{
		$url = '';
		if(!empty($data['url'])){
			$url = $data['url'];
		}
		else if(!empty($data['route'])){
			$url = route($data['route']);
		}
		return $url;
	}
	
		
	/*
	* Generate TabMenu
	*
	* @param array $data
	* @param array $param
	*
	* return string
	*/	
	public function tabMenu($data, $attributes = [])
	{
		  $attr = $this->attrToSrting( $attributes);
		  $s = "<ul $attr >";
		  
		  foreach($data as $key => $row){
			$c = (array) $row["childeren"];
			$title = $row['title'];
			$url = $this->getUrl($row);
			
			if(!empty($c) || $url !== '#'){
				$s  .= "<li><h3>  $title  </h3> <div>";	
			}else{
				$s  .= "<li><h3> <a href=\"$url\"> $title </a>  </h3> <div>";
			}
			
			if(!empty($c)){
			
				$s .= " <ul>";	
				foreach($c as $k => $r){
					$title = $r['title'];
					$url = $this->getUrl($r);
					$s .= "<li><a href=\"$url\" title=\"$title\"> $title </a> </li>";
				}
				$s .= "</ul>";	
			}
			$s  .= "</div></li>";
		  }
		  $s .= "</ul>";
		  return  $s;
	}
	
	
	/*
	* Make Menu
	*
	* @param array $data
	* @param array $attributes
	*
	* return string
	*/	
	public function makeMenu($data, $attributes = [])
	{
		$data = (array) $data;
		$attr = $this->attrToSrting( $attributes);
		$s = "<ul $attr >";
		
		foreach($data as $key => $row){
			$c = (array) @$row["childeren"];
			$title = $row['title'];
			$url = $this->getUrl($row);
			
			$s  .= "<li> <a href=\"$url\"> $title </a>";
			
			if(!empty($c)){
				$s .= " <ul>";	
				foreach($c as $k => $r){
					$title = $r['title'];
					$url = $this->getUrl($r);
					$s .= "<li><a href=\"$url\" title=\"$title\"> $title </a> </li>";
				}
				$s .= "</ul>";	
			}
			$s .= "</li>";
		}
		$s .= "</ul>";
		return  $s;
	}  
	
	
}