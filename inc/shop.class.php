<?php

class Shop {
    private $_db;
    private $_tableItem = 'web_shop';
    private $_tableBag = 'playerbaggoodsinfo';
    // ShopType: 1= Webshop; 2= Kshop; 3= RandomShop
    private $_shopType = 1;
    private $_currTime = ''; 


    public function __construct() {
        $this->_db = NewADOConnection('mysql');
        $this->_db->Connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        $this->_db->Execute("SET NAMES 'utf8'");
        $this->_currTime = date("Y-m-d H:i:s");
    }

    public function setShopType($type) {
        $this->_shopType = $type;
    }

    public function getItemList($isSell = true) {
        if ($isSell) {
            $npctype = 2;
        } else {
            $npctype = 1;
        }
        $sql = "SELECT * FROM ".$this->_tableItem." 
                WHERE shoptype='".$this->_shopType."' 
                      AND starttime<'".$this->_currTime."' 
                      AND endtime>'".$this->_currTime."' 
                      AND npctype = '".$npctype."'    
                ORDER BY id ASC ";
        $r = $this->_db->Execute($sql);
        $rs = $r->GetRows();
        return $rs;
    }
    
    public function getItemListID($listopt = 'all') {
        switch ($listopt) {
            case 'sell': $npctype = " AND npctype='2' "; break;
            case 'buy':  $npctype = " AND npctype='1' "; break;
            case 'all':  $npctype = " AND npctype IN (1,2) "; break;
        }
        $sql = "SELECT goodsid FROM ".$this->_tableItem." 
                WHERE shoptype='".$this->_shopType."' 
                      AND starttime<'".$this->_currTime."' 
                      AND endtime>'".$this->_currTime."' ".$npctype."   
                GROUP BY goodsid           
                ORDER BY id ASC ";
        $r = $this->_db->Execute($sql);
        $rs = $r->GetRows();
        return $rs;
    }


    public function getItemName() {
        
    }

    public function getItemPrice() {
        
    }

    public function getItemQuantity() {
        
    }

    public function buyItem(){
        
    }

    public function sendItem(){
        
    }

}

?>
