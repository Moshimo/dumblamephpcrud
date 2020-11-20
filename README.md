# Dumb Lame PHP CRUD
This is a (forever WIP) dead simple, lightweight and extensible PHP CRUD system for relational databases (MySQL provided, through PDO). You are only required to set the DB connection string and to provide the tables definitions that you want to enable CRUD operations on.

The project is flawed and wrong on so many levels... but it actually does the job. If you need something well designed and to be used in production, turn around and walk away... Should you need this to quickly prototype and/or to have a web interface for your tables (again, not in production!) you are in the right place.

Example DB (example.sql) and DB entities definition (MyEntities.php) provided.

# How To (quick start)
Clone the repo.

Update your MySQL connection string in core/config.php .

Write your DB definitions in MyEntities.php and add them to the $items array at its very bottom and that's it: browse index.php .
Choose in index.php which renderer to use (simple renderer and Bootstrap 4 renderer) by comments or implement your own.

# Database Entity (table)
For each table you want to interact with with DumbLamePHPCRUD, you must create a class that extends Entity in MyEntities.php .


**$table** is the name of the table to which the entity is linked

**$title** is the label displayed for such Entity

**$data** is an associative array where the key is a column of the table and the value is an inner associative array so defined:

--> **$type** of the DataType enum (KEY (integer primary key), STRING, DATETIME, TEXT, BOOL, FK (foreign key), KEYFK (integer primary key which also happens to be foreign key))

--> **$label** (string) display label for the column

--> **$showInList** (bool) whether the column is shown in the list view of the table

--> **$showInDetail** (bool) whether the column is shown in the detail view of a single row

--> **$nullable** (bool) whether the column can be NULL

**$fk** an array (assigned in the construtor of the entity class) where each item is a ForeignKey object. ForeignKey objects constructor takes 

--> **$name** internal name of the foreign key

--> **$displayName** the displayed label

--> **$keyGroup** an array used to define which columns of the current entity makes up the current foreign key (e.g. composed foreign key)

--> **$theirIds** an array used to specify to which keys of the referred table each of the key in $keyGroup are linked to (by same order of definition)

--> **$objResolve** an instance of the entity object representing the table referred by the foreign key

--> **$label** the column of the referred table to be used as the label (e.g. the "option" in an HTML select input)

In order to appear into the system, every one of the defined entity objects must then be added to the **$items** array at the end of MyEntities.php
