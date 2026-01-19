<?php

declare(strict_types=1);

/*
 * This file is part of the "t3_messenger_dashboard" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Ssch\T3MessengerDashboard\Dashboard\Widgets\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ssch\T3MessengerDashboard\Dashboard\Widgets\Serializer\JsonSerializer;
use Ssch\T3MessengerDashboard\Repository\FailedMessageRepository;
use TYPO3\CMS\Core\Http\JsonResponse;
use TYPO3\CMS\Core\SingletonInterface;

final readonly class FailedMessageController implements SingletonInterface
{
    public function __construct(
        private FailedMessageRepository $failedMessageRepository,
        private JsonSerializer $jsonSerializer
    ) {
    }

    public function deleteMessageAction(ServerRequestInterface $request): ResponseInterface
    {
        $messageSpecification = $this->jsonSerializer->decode($request->getBody()->__toString());
        $this->failedMessageRepository->removeMessage($messageSpecification);
        return new JsonResponse([
            'result' => 1,
        ]);
    }
}
