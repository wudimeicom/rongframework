<?php
/**
 * array( "provider" => "Microsoft.Jet.OLEDB.4.0" , "filename" => "d:/www/test.mdb")
 */
require_once "Rong/Logger.php";
require_once 'Rong/Db/Abstract.php';
 

class Rong_Db_Driver_ADO extends Rong_DB_Abstract{
	
	public $conn;
	public $logger;
	public $errorMessage;
	public function __construct($config)
    {
    	$this->logger = Rong_Logger::getLogger();
    	$this->setConfig($config);
		
	    $this->conn = new COM("ADODB.Connection");
			
		$connection_string = $this->getConfigItem("connection_string") ;
		try{
			$this->conn->Open($connection_string);
		}
		catch(Exception $ex )
		{
			
			$this->logger->warn( $this->getErrorMessage( $ex ) );
			try{
				$this->conn =$this->createDatabase();
			}catch(Exception $ex )
			{
				$this->logger->warn( $this->getErrorMessage( $ex ) );
			}
		}
		
	}
	
	private function getErrorMessage( $ex )
	{
		$msg = $ex->getMessage();
		$msg = mb_convert_encoding($msg, "UTF-8","GBK");
		$this->errorMessage = $msg;
		return $msg;
	}
	
    public function createDatabase( $connection_string ='' )
    {
    	if( $connection_string == "" )
		{
			$connection_string = $this->getConfigItem("connection_string") ;
		}
        $catalog       = new COM("ADOX.Catalog");
		try{
        	$catalog->create($connection_string);
		}catch(Exception $ex )
		{
			$this->logger->warn( $this->getErrorMessage( $ex ) );
		}
        $conn = $catalog->activeconnection();
        return $conn;
    }
	
	public function query( $sql )
	{
		$rs = null;
		try{
			$rs = $this->conn->Execute( $sql );
		}catch(Exception $ex )
		{
			$this->logger->warn( $this->getErrorMessage( $ex ) );
		}
		return $rs;
	}
	
	public function fetchAll( $sql )
	{
		$rs = $this->query($sql);
		if( $rs == false ) return null;
		$data = array();
		while( !$rs->EOF )
		{
			$row = array();
			$colCount = $rs->Fields->Count();
			for( $i=0; $i< $colCount; $i++ )
			{
				$k = $rs->Fields($i)->name;
				$v = $rs->Fields($i)->value;
				$row[$k] = $v ; 
			}
			 
			$data[] = $row;
			$rs->MoveNext();
		}
		$rs->Close();
		return $data;
	}
	
	public function fetchRow($sql)
	{
		$rows = $this->fetchAll($sql);
		return $rows[0];
	}
	
	public function call( $sql )
	{
		$rows = array();
        $sqlArr = explode(";", $sql);
        for ($i = 0; $i < count($sqlArr); $i++)
        {
            if (strlen(trim($sqlArr[$i])) > 3)
            {
                $rows[] = $this->fetchAll($sqlArr[$i]);
            }
        }
        return $rows;
	}
	
	public function insertId()
    {
    	
    }
	
    public function affectedRows()
    {
    	
	}
	
	public function numFields()
    {
    	
    }
    
	public function numRows()
    {
    }
	
    public function error()
    {
    	return $this->errorMessage;
	}	
	
	public function beginTransaction(){
		$this->conn->BeginTrans();
	}
	
	public function commit(){
		$this->conn->CommitTrans();
	}
	
	public function rollback(){
		$this->conn->rollbackTrans();
	}
	
	public function __destruct(){
		try{
			$this->conn->Close();
		}catch(Exception $ex)
		{
			$this->logger->warn( $this->getErrorMessage( $ex ) );
		}
	}
	 
}
?>
