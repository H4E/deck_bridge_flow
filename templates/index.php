<?php

declare(strict_types=1);

use OCP\Util;

Util::addScript(OCA\DeckBridgeFlow\Application::APP_ID, OCA\DeckBridgeFlow\Application::APP_ID . '-main');
Util::addStyle(OCA\DeckBridgeFlow\Application::APP_ID, OCA\DeckBridgeFlow\Application::APP_ID . '-main');

?>

<div id="deck_bridge_flow"></div>
