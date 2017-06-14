CheckMeOut Woo Ecommerce Plugin
------
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
------

`BREAD = browse, read, edit, add delete`

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