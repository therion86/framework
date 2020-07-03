<?php

use Phinx\Migration\AbstractMigration;

class AddNewCompany extends AbstractMigration {

    /**
     * @return void
     * @author Therion86
     */
    public function change(): void {
        $table = $this->table('company');
        $table->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('street', 'string', ['limit' => 255])
            ->addColumn('postal_code', 'string', ['limit' => 255])
            ->addColumn('city', 'string', ['limit' => 255])
            ->addColumn('country_id', 'string', ['limit' => 255])
            ->addColumn('contact_mail', 'string', ['limit' => 255])
            ->addColumn('customer_number', 'string', ['limit' => 255])
            ->addColumn('tax_number', 'string', ['limit' => 255])
            ->addColumn('active', 'boolean', ['default' => 1])
            ->addColumn('created', 'datetime')
            ->create();
    }
}
