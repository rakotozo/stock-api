
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# Vérification des entités
php bin/console doctrine:mapping:info


# Création de Produit

php bin/console make:entity Product

php bin/console make:migration
php bin/console doctrine:migrations:migrate


Product
   |
   | 1
   |
   | N
ProductSupplier
   |
   | N
   |
   | 1
Supplier

php bin/console doctrine:migrations:status

php bin/console doctrine:schema:validate

php bin/console doctrine:query:sql "SELECT indexname, indexdef FROM pg_indexes WHERE tablename = 'product_supplier'"

`
    C:\Serveur8\htdocs\stock-api>php bin/console doctrine:query:sql "SELECT indexname, indexdef FROM pg_indexes WHERE tablename = 'product_supplier'"
    ----------------------- ----------------------------------------------------------------------------------------
    indexname               indexdef
    ----------------------- ----------------------------------------------------------------------------------------
    product_supplier_pkey   CREATE UNIQUE INDEX product_supplier_pkey ON public.product_supplier USING btree (id)
    idx_509a06e94584665a    CREATE INDEX idx_509a06e94584665a ON public.product_supplier USING btree (product_id)
    idx_509a06e92add6d8c    CREATE INDEX idx_509a06e92add6d8c ON public.product_supplier USING btree (supplier_id)
    ----------------------- ----------------------------------------------------------------------------------------
 `


php bin/console doctrine:mapping:describe "App\Entity\ProductSupplier"

# Vérification de version de Doctrine
composer show doctrine/orm


# Vérifier qu'il n'existe pas déjà de doublons

php bin/console doctrine:query:sql "SELECT product_id, supplier_id, COUNT(*) AS total FROM product_supplier GROUP BY product_id, supplier_id HAVING COUNT(*) > 1"

# Générer une migration vide
php bin/console doctrine:migrations:generate

`
    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE UNIQUE INDEX unique_product_supplier
            ON product_supplier (product_id, supplier_id)'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql(
            'DROP INDEX unique_product_supplier'
        );
    }
`

# Appliquer la migration

php bin/console doctrine:migrations:migrate

# Puis vérifie :
php bin/console doctrine:query:sql "SELECT indexname, indexdef FROM pg_indexes WHERE tablename = 'product_supplier'"

` 
    ------------------------- --------------------------------------------------------------------------------------------------------------
    indexname                 indexdef
    ------------------------- --------------------------------------------------------------------------------------------------------------
    product_supplier_pkey     CREATE UNIQUE INDEX product_supplier_pkey ON public.product_supplier USING btree (id)
    idx_509a06e94584665a      CREATE INDEX idx_509a06e94584665a ON public.product_supplier USING btree (product_id)
    idx_509a06e92add6d8c      CREATE INDEX idx_509a06e92add6d8c ON public.product_supplier USING btree (supplier_id)
    unique_product_supplier   CREATE UNIQUE INDEX unique_product_supplier ON public.product_supplier USING btree (product_id, supplier_id)
    --------------
 `

# Vérification
php bin/console doctrine:schema:validate


C:\Serveur8\htdocs\stock-api>php bin/console doctrine:schema:validate

Mapping
-------


 [OK] The mapping files are correct.


Database
--------


 [ERROR] The database schema is not in sync with the current mapping file.



C:\Serveur8\htdocs\stock-api>php bin/console doctrine:schema:update --dump-sql
DROP INDEX unique_product_supplier;

php bin/console doctrine:schema:update --dump-sql
DROP INDEX unique_product_supplier;

C:\Serveur8\htdocs\stock-api>php bin/console doctrine:schema:update --dump-sql


 [OK] Nothing to update - your database is already in sync with the current entity metadata.



C:\Serveur8\htdocs\stock-api>php bin/console doctrine:schema:validate

Mapping
-------


 [OK] The mapping files are correct.


Database
--------


 [OK] The database schema is in sync with the mapping files.


 # Vérification du service

 php bin/console lint:container
 

 php bin/console debug:router
 php -S localhost:8000 -t public

 php bin/console debug:router | findstr categories | OK
 php bin/console debug:router | findstr product

////////////////////////////////////////////////////////////////////////

ceci mérite d'être lu par les développeurs

https://code.claude.com/docs/en/overview

# Overview
"""
Claude Code is an agentic coding tool that reads your codebase, edits files, runs commands, and integrates with your development tools. Available in your terminal, IDE, desktop app, and browser.

"""
