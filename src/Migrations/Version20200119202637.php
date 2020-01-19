<?php

declare(strict_types=1);

namespace App\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200119202637 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Create orders table';
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('orders');

        $table->addColumn('id', 'integer');
        $table->addColumn('status', 'integer');

        $table->setPrimaryKey(['id']);

        $table = $schema->createTable('orders_products');

        $table->addColumn('id', 'integer');
        $table->addColumn('order_id', 'integer');
        $table->addColumn('product_id', 'integer');

        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('orders_products');
        $schema->dropTable('orders');
    }
}
