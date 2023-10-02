<?php
class MenuCategoryPdo
{
    private $mmshightech;

    public function __construct(mmshightech $mmshightech)
    {
        $this->mmshightech = $mmshightech;
    }
    public function verifymenuId(int $menuId = 0){
        $sql="select id from menu_category_ids where id =?";
        return $this->mmshightech->numRows($sql,'s',[$menuId])==1;
    }
}
?>