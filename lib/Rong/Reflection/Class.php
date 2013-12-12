<?php
class Rong_Reflection_Class{
	
	private $className;
	private $ref;
	private $methods;
	
	public function __construct( $className )
	{
		$this->className = $className;
		$this->parseMethods();
	}
	
	protected function parseMethods(){
		$this->ref = new ReflectionClass( $this->className );
		$methods = $this->ref->getMethods();
				
		/**
		 * @var ReflectionMethod
		 */
		$m = null;
		foreach( $methods as $m )
		{
			$comment = $m->getDocComment();
			preg_match_all("/@([a-zA-Z0-9]+)\s+([a-zA-Z0-9\_]+)(\s+([\$a-zA-Z0-9_]+)\s+([^\r\n\*]+))*[\r\n\*]+/i", $comment, $m2 );
			$comments = array();
			for( $i=0; $i< count( $m2[1]); $i++ )
			{
				$tag = $m2[1][$i]; //@param
				if( !isset( $arr[$tag] ) )  $arr[$tag] = array();
				$comments[$tag][] = $cmt =array(
					"line" => $m2[0][$i],
					"at" => $m2[1][$i],
					"type" => $m2[2][$i],
					"var" => $m2[4][$i],
					"comment" => $m2[5][$i]
				);
			}
			//print_r( $comments );
			$ps =   $m->getParameters();
			$parameters = array();
			for( $j=0; $j< count( $ps ); $j++ ){
				$paramName2 = $ps[$j]->name;
				$param = array("name" => '$'. $paramName2 );
				for( $k=0; $k < @count($comments["param"]); $k++ )
				{
					$cp = $comments["param"][$k];
					if( $cp["var"] == $paramName2 || $cp["var"] =='$' . $paramName2 ){
						  $param["name"] = $cp["var"];
						  $param["type"] = $cp["type"];
						  $param["comment"] = $cp["comment"];
					}
				}
				$parameters[] = $param;
			}
			
			$modifierNames =implode(' ', Reflection::getModifierNames($m->getModifiers())) . "\r\n";
			$this->methods[$m->name] = array(
				"parameters" => $parameters ,
				"modifierNames" => trim( $modifierNames ),
				"return_type" => @$comments["return"][0]["type"],
				"return_comment" => @$comments["return"][0]["var"], //the var is comment
				"declaring_class" => @$m->getDeclaringClass()->name
			); 
		}
		
		
	}
	
	public function getMethods()
	{
		return $this->methods;
	}
	
}
