<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119200355 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create products table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('products');

        $table->addColumn('id', 'integer');
        $table->addColumn('name', 'string');
        $table->addColumn('price', 'integer');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('products');
    }
}
