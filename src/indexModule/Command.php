<?php

declare(strict_types=1);

namespace framework\src\indexModule;

use framework\lib\request\Request;
use framework\lib\response\Response;
use framework\lib\routing\CommandInterface;
use framework\lib\response\ResponseInterface;
use framework\src\dbPlugin\DbHandler;

class Command implements CommandInterface
{
    private Request $request;
    private DbHandler $dbHandler;

    public function __construct(
        Request $request,
        DbHandler $dbHandler
    )
    {
        $this->request = $request;
        $this->dbHandler = $dbHandler;
    }

    public function execute(): ResponseInterface
    {
        $stmt  = $this->dbHandler->getConnection()->prepare('SELECT * FROM user_group;');
        $data = $stmt->fetchAllColumn(1);
        return new Response('Hello world ' . implode(',', $data));
    }
}