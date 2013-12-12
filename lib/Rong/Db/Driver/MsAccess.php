<?php

class Rong_Db_Driver_MsAccess{
    public function createDatabase( $filename, $provider = "Microsoft.Jet.OLEDB.4.0" )
    {
        $catalog       = new COM("ADOX.Catalog");
        $catalog->create('Provider = '. $provider.'; Data Source=' . $filename );
        $conn = $catalog->activeconnection();
        return $conn;
    }
}
?>
