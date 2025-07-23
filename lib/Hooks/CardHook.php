<?php

declare(strict_types=1);

namespace OCA\DeckBridgeFlow\Hooks;

use OCA\Deck\Service\CardManagerEvent;
use OCA\Deck\Db\StackMapper;
use OCA\Deck\Db\BoardMapper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use OCP\WorkflowEngine\IManager as FlowManager;

class CardHook implements EventSubscriberInterface {
	private FlowManager $flowManager;
	private StackMapper $stackMapper;
	private BoardMapper $boardMapper;

	public function __construct(
		FlowManager $flowManager,
		StackMapper $stackMapper,
		BoardMapper $boardMapper
	) {
		$this->flowManager = $flowManager;
		$this->stackMapper = $stackMapper;
		$this->boardMapper = $boardMapper;
	}

	public static function getSubscribedEvents(): array {
		return [
			CardManagerEvent::class => 'onCardChanged',
		];
	}

	public function onCardChanged(CardManagerEvent $event): void {
		$card = $event->getCard();

		try {
			$stack = $this->stackMapper->find($card->getStackId());
			$board = $this->boardMapper->find($card->getBoardId());
		} catch (\Throwable $e) {
			\OC::$server->getLogger()->error('DeckBridgeFlow: Failed to resolve board or stack', ['exception' => $e]);
			return;
		}

		$params = [
			'cardId'     => $card->getId(),
			'cardTitle'  => $card->getTitle(),
			'stackId'    => $card->getStackId(),
			'stackName'  => $stack->getTitle(),
			'boardId'    => $card->getBoardId(),
			'boardName'  => $board->getTitle(),
		];

		$this->flowManager->triggerFlow('deck_flow_bridge_card_event', $params, 'card_moved');
	}
}
