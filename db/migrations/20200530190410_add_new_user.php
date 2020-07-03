<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

class AddNewUser extends AbstractMigration
{

    /**
     * @return void
     * @author Therion86
     */
    public function change(): void {
        $table = $this->table('user');
        $table->addColumn('login', 'string', ['limit' => 255])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('password_salt', 'string', ['limit' => 255])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('first_name', 'string', ['limit' => 255])
            ->addColumn('last_name', 'string', ['limit' => 255])
            ->addColumn('created', 'datetime')
            ->addColumn('updated', 'datetime', ['null' => true])
            ->addIndex(['login', 'email'], ['unique' => true])
            ->create();

    }
}
