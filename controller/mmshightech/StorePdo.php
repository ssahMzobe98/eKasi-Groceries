<?php
class StorePdo{
    private mmshightech $mmshightech;
    public function __construct(mmshightech $mmshightech)
    {
        $this->mmshightech=$mmshightech;
    }
    public function getStoreMenuCategoryIds(int $store_id=null):array
    {
        $sql = "select mci.id as menu_category_id,
                    mci.menu as menu,
                    mci.description as description
                    from store_menu_category_ids as smci 
                left join menu_category_ids as mci on mci.id = smci.menu_category_id
                    where smci.store_id =?
                ";
        return $this->mmshightech->getAllDataSafely($sql,'s',[$store_id])??[];
    }
    public function backStoreNavigation(int $user_id=null):array
    {
        $sql = "select prev_id,obj_class, url from  user_history where user_id=? order by id desc limit 1";
        $data = $this->mmshightech->getAllDataSafely($sql,'s',[$user_id])[0];
        $prev = $data['prev_id']??1;
        $sql = "select obj_class,url from  user_history where id=? order by id desc limit 1";
        $data = $this->mmshightech->getAllDataSafely($sql,'s',[$prev])[0];
        $data['prev_id']=$prev;
        return $data??[];
    }
    public function getCartPayload(int $id=null, int $store_id=null):array
    {
        $sql = "SELECT
                    CONCAT(u.name, ' ', u.surname) AS user_name,
                    u.usermail AS email,
                    u.phone_number AS phone,
                    u.user_type AS user_type,
                    u.app_version AS app_version,
                    concat(u.name,' ',u.surname) AS username,
                    u.delivery_type AS delivery_type,
                    u.id AS user_id,
                    u.driver_tip AS driver_tip,
                    u.card_number AS card_number,
                    u.card_expiry_date AS card_expiry_date,
                    u.card_name AS card_name,
                    u.card_type AS card_type,
                    u.card_cvv AS card_cvv,
                    u.card_token AS card_token,
                    (
                    select 
                        if(NOW()>spc.start_date and NOW()<spc.end_date,aupc.promo_code,'')
                        
                    from app_user_promo_code as aupc 
                    left join store_promo_code as spc 
                        on aupc.promo_code = spc.promo_code 
                               and spc.store_id = ?
                               and (
                                   NOW()>spc.start_date 
                                       and 
                                   NOW()<spc.end_date
                                   )
                        where aupc.user_id=u.id 
                        and aupc.status = 'A' 
                        order by aupc.id 
                        desc limit 1
                    ) as promo_code,
                    (
                        SELECT 
                             sum( p.price_usd * c.quantity)
                        FROM cart AS c 
                            LEFT JOIN products AS p ON p.id = c.product_id
                        WHERE c.store_id = u.store_id AND c.user_id = u.id
                    ) AS sub_total_price,
                    cb.credit_balance as credit_balance,
                    cb.use_credit as use_credit,
                    (SELECT GROUP_CONCAT(
                        JSON_OBJECT(
                            'store_id', p.store_id,
                            'product_id', p.id,
                            'menu_id', p.menu_catalogue_id,
                            'product_handle', p.product_handle,
                            'product_description', p.product_description,
                            'product_thumbnail', p.product_thumbnail,
                            'product_weight', p.product_weight,
                            'product_length', p.product_length,
                            'product_width', p.product_width,
                            'product_height', p.product_height,
                            'product_hs_code', p.product_hs_code,
                            'product_discountable', p.product_discountable,
                            'product_profile_name', p.product_profile_name,
                            'product_profile_type', p.product_profile_type,
                            'variant_barcode', p.variant_barcode,
                            'price', p.price_usd,
                            'is_instock', p.is_instock,
                            'instock', p.instock,
                            'quantity', c.quantity
                        )
                    ) 
                    FROM cart AS c 
                        LEFT JOIN products AS p ON p.id = c.product_id
                    WHERE c.store_id = u.store_id AND c.user_id = u.id
                    ) AS order_details,
                    da.address AS delivery_address,
                    da.extra AS extra
                FROM users AS u
                    LEFT JOIN delivery_addresses AS da ON da.user_id = u.id AND da.status = 'A'
                    LEFT JOIN app_user_promo_code AS aupc ON aupc.user_id = u.id AND aupc.status = 'A'
                    LEFT JOIN credit_balance AS cb ON cb.user_id = u.id                             
                WHERE u.store_id = ? AND u.id = ?";
        return $this->mmshightech->getAllDataSafely($sql,'sss',[$store_id,$store_id,$id])[0]??[];
    }
    public function getPromoPrice(string $promo_code=null, int $store_id=null):string
    {
        $sql = "select if(
                            NOW()>start_date 
                                and 
                            NOW()<end_date,off_price,'0.00'
                        ) as promo_price 
                from store_promo_code 
                    where promo_code = ? 
                      and store_id = ? 
                      and (
                          NOW()>start_date 
                              and 
                          NOW()<end_date
                          )";
        $response=$this->mmshightech->getAllDataSafely($sql,'ss',[$promo_code,$store_id])[0]??[];
        return $response['promo_price']??'0.00';
    }
}

?>