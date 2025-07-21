<template>
	<NcAppContent>
		<div id="deck_bridge_flow">
			<h1>Deck Bridge Flow</h1>
		</div>
	</NcAppContent>
</template>

<script>
import NcAppContent from '@nextcloud/vue/dist/Components/NcAppContent.js'

export default {
	name: 'App',
	components: {
		NcAppContent,
	},
}
</script>

<style scoped lang="scss">
#deck_bridge_flow {
	display: flex;
	justify-content: center;
	margin: 16px;
}
</style>
