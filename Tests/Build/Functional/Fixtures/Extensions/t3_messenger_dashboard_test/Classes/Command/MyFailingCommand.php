<?php

declare(strict_types=1);

namespace Ssch\T3MessengerDashboard\Tests\Functional\Fixtures\Extensions\t3_messenger_dashboard_test\Classes\Command;

final class MyFailingCommand
{
    private string $note;

    public function __construct(string $note)
    {
        $this->note = $note;
    }

    public function getNote(): string
    {
        return $this->note;
    }
}
