<?php
class ProductsPdo
{
    private mmshightech $mmshightech;
    public function __construct(mmshightech $mmshightech)
    {
        $this->mmshightech = $mmshightech;
    }
    public function getProductCatalogueSpecialsDetailes(int $store_id=null):array
    {
        $sql = "select id as product_id,
                       store_id as store_id,
                       menu_catalogue_id as menu_catalogue_id,
                       product_description as product_description,
                       product_thumbnail as img,
                       price_usd as price,
                       product_discountable as discount
                from products where store_id=? and product_status ='A' and product_discountable = 'Y'";
        return $this->mmshightech->getAllDataSafely($sql,'s',[$store_id])??[];
    }
    public function getTotalOnCart($product_id,$store_id,$id):int
    {
        $sql = "select quantity from cart where product_id = ? and user_id = ? and store_id = ?";
        $response = $this->mmshightech->getAllDataSafely($sql,'sss',[$product_id,$id,$store_id])[0]??[];
        return $response['quantity']??0;
    }
    public function getProductCatalogueDetailes(int $store_id=null):array
    {
        $sql = "select id as product_id,
                       store_id as store_id,
                       menu_catalogue_id as menu_catalogue_id,
                       product_description as product_description,
                       product_thumbnail as img,
                       price_usd as price,
                       product_discountable as discount
                from products where store_id=? and product_status ='A'";
        return $this->mmshightech->getAllDataSafely($sql,'s',[$store_id])??[];
    }
}
?>