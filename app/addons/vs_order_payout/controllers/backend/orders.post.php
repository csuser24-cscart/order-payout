<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $suffix = '';

    if ($mode == 'update_details') {
        fn_trusted_vars('update_order');
      
       if(isset($_REQUEST['update_payout']))
       {
          $update_payout = $_REQUEST['update_payout'];

          $date = $update_payout['timestamp'];
          $date = str_replace('/', '-', $date);
          $update_payout['payout_date'] = strtotime($date);
          if(!is_numeric($update_payout['payout_amount']))
          {
            $update_payout['payout_amount'] = 0;
            fn_set_notification('E',__('error'),__('please_enter_intiger_value_in_payout_amount'));
          } 
             
          $check_exist = db_get_field('SELECT order_id FROM ?:vs_order_payout WHERE order_id = ?i',$_REQUEST['order_id']);
          if($check_exist)
          {
            if(!isset($update_payout['payout_done']))
            {
              $update_payout['payout_done'] = 'N';
            }
            
            db_query('UPDATE ?:vs_order_payout SET ?u WHERE order_id = ?i',$update_payout,$_REQUEST['order_id']);
          } else {
              $update_payout['order_id'] = $_REQUEST['order_id'];
              if($update_payout['order_id'])
              {
                db_query('INSERT INTO ?:vs_order_payout ?e', $update_payout);
              }
          }
          
       }

        $suffix = ".details?order_id=$_REQUEST[order_id]&selected_section=payouts";
    }

    return array(CONTROLLER_STATUS_OK, 'orders' . $suffix);
}


if ($mode == 'details') {
      Registry::set('navigation.tabs.payouts', array (
            'title' => __('payouts'),
            'js' => true
        ));
      $update_payout = db_get_array('SELECT payout_done,payout_amount,payout_date,transaction_id FROM ?:vs_order_payout WHERE order_id = ?i',$_REQUEST['order_id']);
    
      if(isset($update_payout[0]) && !empty($update_payout[0])) 
      Registry::get('view')->assign('update_payout',$update_payout[0]);
}