<?php
//items4.php

$myItem = new Item(1,"Sunda Bowl", "Our bowl comes with 1 ice cream scoop",4.99);
$myItem->addExtra("Caramel Sauce");
$myItem->addExtra("Hot Fudge");
$myItem->addExtra("Cherry");
$config->items[] = $myItem;

$myItem = new Item(2,"Sugar Cone", "Our sugar cone come with 1 ice cream scoop",5.99);
$myItem->addExtra("Sprinkles");
$myItem->addExtra("Chocolate Sauce");
$myItem->addExtra("Nuts");
$config->items[] = $myItem;

$myItem = new Item(3,"Ice Cream Sandwich", "On our ice cream sandwich are awsome!",6.99);
$myItem->addExtra("Peanut Crumbs");
$myItem->addExtra("Almond Crumbs");
$myItem->addExtra("Sprinkles");
$myItem->addExtra("Oreo Crumbs");
$config->items[] = $myItem;


//create a counter to load the ids...
//$items[] = new Item(1,"Taco","Our Tacos are awesome!",4.95);
//$items[] = new Item(2,"Sundae","Our Sundaes are awesome!",3.95);
//$items[] = new Item(3,"Salad","Our Salads are awesome!",5.95);

/*
echo '<pre>';
var_dump($items);
echo '</pre>';
die;
*/


class Item
{
    public $ID = 0;
    public $Name = '';
    public $Description = '';
    public $Price = 0;
    public $Extras = array();
    
    public function __construct($ID,$Name,$Description,$Price)
    {
        $this->ID = $ID;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Price = $Price;
        
    }#end Item constructor
    
    public function addExtra($extra)
    {
        $this->Extras[] = $extra;
        
    }#end addExtra()

}#end Item class











