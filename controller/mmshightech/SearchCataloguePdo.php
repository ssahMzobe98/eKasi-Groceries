<?php
class SearchCataloguePdo
{
    private mmshightech $mmshightech;
    public function __construct(mmshightech $mmshightech)
    {
        $this->mmshightech = $mmshightech;
    }
    public function SearchCatalogue(string $search = null):array{
        $sql="select * from products where product_description like ?";
        return $this->mmshightech->getAllDataSafely($sql,'s',["%".$search."%"])??[];
    }
}
?>