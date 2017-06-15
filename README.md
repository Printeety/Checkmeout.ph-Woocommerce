CheckMeOut Woo Ecommerce Plugin
------
<<<<<<< HEAD
Woo Commerce plugin to allow payments using [CheckMeOut](http://vincit.github.io/objection.js/) - uses mysql as the default client/dialect

Includes the following projects/tools:
* Express 4
* Helmet
* jsonwebtoken
* [objection.js](http://vincit.github.io/objection.js/) - uses mysql as the default client/dialect
* babel (with ex2015 preset)
* knex (for migration and seeding, see their official documentation)

Simple Resources validation
------
* A user can have multiple roles
* A role can access several urls as defined in a config file (+option to define strategy, just like passport)

Default Routes
=======
Woo Commerce plugin to allow payments using [CheckMeOut](http://vincit.github.io/objection.js/) - Payment and shipping app from lbcx.


Settings
------
* CMO plugin settings will be save in the database using the WC_Gateway_CMO_Checkmeout class ID assignment
* Settings would be loaded from the database using the class WC_Gateway_CMO_Settings and accessed by the woocommerce_checkmeout_settings option marker.

Callback and Routes
>>>>>>> b551a333f50cb3e8bbc9eddc7fce39fcae3e44ed
------

`BREAD = browse, read, edit, add delete`

<<<<<<< HEAD
* `/` 
* `/auth`
* `/user/[BREAD]` - requires jwt token on Authorization header
* `/role/[BREAD]` - requires jwt token on Authorization header

Some Scripts Included
------

Dev operations
* `npm run dev` - start the dev server
* `npm run build` - build the server (in dev env)

Generators
* `npm run generate [snake_case_table_name]` - to generate the:
  * model - placeholder file for sequelize schema on the `src/models` directory
  * controller - with sample crud operations on the `src/controllers` directory

Migration

Before you can execute the migration, install knex globally first `npm install -g knex`
* `knex migrate:latest` 
* `knex migrate:rollback`
* `knex migrate:make [migration_name]`

Seeding

Simply create a csv file on the `seeds/csv` directory then reference it on the `seeds` var of `seeds/populate_db.js` file.
Just copy the pattern listed in there and you're good.

Execute seeding by: `knex seed:run`

TODO
------
* ~~Simple Fixture/Migration script that imports csv files and auto-'sync' feature~~
* Write tests
* Logging system
* role-resource checking (can a user with a specific role access a resouce/url?)
* prod/staging deployment strategies or scripts

LICENSE
------
WTFPL - Do What the Fuck You Want to Public License
=======
* `/wc-api/wc_gateway_cmo`  - Callback url to contact the woo server regarding payments
* `/?woo-cmo-return=true&order-id=[{order-id}]` - return URL to be passed to CMO. [ partially implemented - add the page ] 
* `/?woo-cmo-failed` -[ not yet implemented ]
* `/?woo-cmo-cancel` - [ not yet implemented ]

TODO 
------

capture payment
* return page implementation
* ORDER ID creation : should be on woo? On the call that gets the URL from cmo
* SHIPPING DATA : Sync to woo from return route callback ?
>>>>>>> b551a333f50cb3e8bbc9eddc7fce39fcae3e44ed
