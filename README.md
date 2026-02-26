# Animals API

The Animals API is built using vanilla PHP. I created this project as a personal learning exercise, but you're welcome to use it or learn from it as well.

## Database Setup SQL

The database setup for this project uses **MySQL**.

There is a file named `database_setup.sql` that you can use to set up the database used in this project. This script contains all the necessary SQL statements to create the required tables, define relationships, and apply the initial configuration.

## Git Ignore

The real database connection file is excluded from the repository for security reasons. Below is an example you can use as a template for your own setup.

## Example Connection Code

```php
try {
    $dbh = new PDO(
        "mysql:host=localhost;dbname=example",
        "root",
        "root"
    );
} catch (PDOException $e) {
    http_response_code(503);
    exit("Database connection failed: $e");
}
