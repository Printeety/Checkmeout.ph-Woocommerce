CheckMeOut Woo Ecommerce Plugin
------
 Woo Commerce plugin to allow payments using [CheckMeOut]
 
 
Settings
------
 * CMO plugin settings will be save in the database using the WC_Gateway_CMO_Checkmeout class ID assignment
 * Settings would be loaded from the database using the class WC_Gateway_CMO_Settings and accessed by the woocommerce_checkmeout_settings option marker.
 
Routes
------
 * `/wc-api/wc_gateway_cmo`  - Callback url to contact the woo server regarding payments
 * `/?woo-cmo-return=true&order-id=[{order-id}]` - return URL to be passed to CMO. [ partially implemented - add the page ] 
 * `/?woo-cmo-failed` -[ not yet implemented ]
 * `/?woo-cmo-cancel` - [ not yet implemented ]
 
 
TODO
------
 * capture payment from cmo callback and mark the order status to processing ( OrderIDWoo, Status )
 * Security : create a whitelist(URL) for validation
 * <strike>return page implementation </strike>
 * <strike>ORDER ID creation : should be on woo? On the call that gets the URL from cmo</strike>
 * SHIPPING DATA : shipping cost must be on the order that was created. viewable from details and success page
 * Failed Payment implementation. Add a page to display a failed transcation
 * Cancelled Payment implementation. Add a page to display a cancelled transcation
 * Environment varible for the cmo url and other dev related settings
 * Image for the cmo button must be on cmo / on woo assets
 * cancel function from woo to cmo
 * Settings page changes based on cmo's screens Jira Ticket CB-451 

EPIC
------
 * COUPON implementation and discounts
 * VERSIONING support
 * Delivery update from CMO to change order status to complete

 