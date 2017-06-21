CheckMeOut Woo Ecommerce Plugin
------
 Woo Commerce plugin to allow payments using [CheckMeOut](http://vincit.github.io/objection.js/) - uses mysql as the default client/dialect
 
 
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
 * capture payment
 * return page implementation
 * ORDER ID creation : should be on woo? On the call that gets the URL from cmo
 * SHIPPING DATA : Sync to woo from return route callback ?
 