<?php

namespace OCA\DeckBridgeFlow\Flow\Trigger;

use OCP\WorkflowEngine\ICheckableTrigger;
use OCP\WorkflowEngine\ITriggerConsumer;
use OCP\WorkflowEngine\IEntity;
use OCP\WorkflowEngine\IEvent;
use OCP\WorkflowEngine\IConstraint;
use OCP\WorkflowEngine\Entity\GenericEntity;
use OCP\WorkflowEngine\GenericCheck;

class CardMovedTrigger implements ICheckableTrigger {
    public function getId(): string {
        return 'deck_flow_bridge_card_moved';
    }

    public function getName(): string {
        return 'Deck: Card Event';
    }

    public function getDescription(): string {
        return 'Triggered when a card is moved to another column (stack). or created';
    }

    public function getGroup(): string {
        return 'deck'; // Logical group shown in Flow UI
    }

    public function getEntity(): IEntity {
        return new GenericEntity('deck_card');
    }

    public function getAvailableEvents(): array {
        return ['card_moved', 'card_created'];
    }
    public function getDefaultEvents(): array {
        return ['card_moved'];
    }

    public function getConstraints(): array {
        return [
          new GenericCheck('boardName', 'Board Name', GenericCheck::TYPE_TEXT),
          new GenericCheck('stackName', 'List Name (Column)', GenericCheck::TYPE_TEXT),m        ];
    }

    public function matches(IEvent $event, array $checks): bool {
        // `$event->getParameters()` contains keys: stackId, boardId, cardTitle, etc.
        return GenericCheck::matchEvents($checks, $event->getParameters());
    }

    public function getDefaultEvents(): array {
        return ['card_moved'];
    }
}

