<?php

declare(strict_types=1);

namespace OCA\AppTemplate\AppInfo;

use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;

use OCA\DeckBridgeFlow\Hooks\CardHook;
use OCA\DeckBridgeFlow\Flow\Trigger\CardMovedTrigger;
use OCP\WorkflowEngine\IManager;
use OCP\EventDispatcher\IEventDispatcher;

class Application extends App implements IBootstrap {
	public const APP_ID = 'deck_bridge_flow';

	/** @psalm-suppress PossiblyUnusedMethod */
	public function __construct() {
		parent::__construct(self::APP_ID);
	}

	public function register(IRegistrationContext $context): void {
  $context->registerService(CardHook::class, function ($c) {
  return new CardHook(
		$c->get(\OCP\WorkflowEngine\IManager::class),
		$c->get(\OCA\Deck\Db\StackMapper::class),
		$c->get(\OCA\Deck\Db\BoardMapper::class)
	);  
  });
  
  }

	public function boot(IBootContext $context): void {
  // Register Flow Trigger
		/** @var Manager $flowManager */
		$flowManager = $context->getAppContainer()->get(IManager::class);
		$flowManager->registerTrigger(CardMovedTrigger::class);

		// Register Deck card event listener
		/** @var IEventDispatcher $eventDispatcher */
		$eventDispatcher = $context->getAppContainer()->get(IEventDispatcher::class);
		$eventDispatcher->addServiceListener(CardHook::class, CardHook::class);
	}
}
