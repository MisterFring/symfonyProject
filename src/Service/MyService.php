<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MyService
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * MyService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param int $nb1
     * @param int $nb2
     * @return int
     */
    public function addition(int $nb1, int $nb2) {
        $res = $nb1 + $nb2;
        $this->logger->info('Addition '.$nb1.' + '.$nb2.' = '.$res);
        return $res;
    }
}