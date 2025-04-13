import { MessengerMenu, MenuItem, MenuItemIcon, CreateChatPromo } from 'im.v2.component.elements';
import { Layout, PromoId, ChatType } from 'im.v2.const';
import { Analytics } from 'im.v2.lib.analytics';
import { PromoManager } from 'im.v2.lib.promo';
import { CreateChatManager } from 'im.v2.lib.create-chat';

import { CreateChatHelp } from './create-chat-help';

import type { JsonObject } from 'main.core';
import type { MenuOptions } from 'main.popup';

const PromoByChatType = {
	[ChatType.chat]: PromoId.createGroupChat,
	[ChatType.videoconf]: PromoId.createConference,
	[ChatType.channel]: PromoId.createChannel,
};

// @vue/component
export const CreateChatMenu = {
	components: { MessengerMenu, MenuItem, CreateChatHelp, CreateChatPromo },
	data(): JsonObject
	{
		return {
			showPopup: false,
			chatTypeToCreate: '',
			showPromo: false,
		};
	},
	computed:
	{
		ChatType: () => ChatType,
		MenuItemIcon: () => MenuItemIcon,
		menuConfig(): MenuOptions
		{
			return {
				id: 'im-create-chat-menu',
				width: 275,
				bindElement: this.$refs.icon || {},
				offsetTop: 4,
				padding: 0,
			};
		},
	},
	methods:
	{
		onChatCreateClick(type: $Values<typeof ChatType>)
		{
			Analytics.getInstance().onStartCreateNewChat(type);
			this.chatTypeToCreate = type;

			const promoBannerIsNeeded = PromoManager.getInstance().needToShow(this.getPromoType());
			if (promoBannerIsNeeded)
			{
				this.showPromo = true;
				this.showPopup = false;

				return;
			}

			this.startChatCreation();
			this.showPopup = false;
		},
		onPromoContinueClick()
		{
			PromoManager.getInstance().markAsWatched(this.getPromoType());
			this.startChatCreation();
			this.showPromo = false;
			this.showPopup = false;
			this.chatTypeToCreate = '';
		},
		startChatCreation()
		{
			const { name: currentLayoutName, entityId: currentLayoutChatType } = this.$store.getters['application/getLayout'];
			if (currentLayoutName === Layout.createChat.name && currentLayoutChatType === this.chatTypeToCreate)
			{
				return;
			}
			CreateChatManager.getInstance().startChatCreation(this.chatTypeToCreate);
		},
		getPromoType(): string
		{
			return PromoByChatType[this.chatTypeToCreate] ?? '';
		},
		loc(phraseCode: string): string
		{
			return this.$Bitrix.Loc.getMessage(phraseCode);
		},
	},
	template: `
		<div
			class="bx-im-list-container-recent__create-chat_icon"
			:class="{'--active': showPopup}"
			@click="showPopup = true"
			ref="icon"
		></div>
		<MessengerMenu v-if="showPopup" :config="menuConfig" @close="showPopup = false">
			<MenuItem
				:icon="MenuItemIcon.chat"
				:title="loc('IM_RECENT_CREATE_GROUP_CHAT_TITLE_V2')"
				:subtitle="loc('IM_RECENT_CREATE_GROUP_CHAT_SUBTITLE_V2')"
				@click="onChatCreateClick(ChatType.chat)"
			/>
			<MenuItem
				:icon="MenuItemIcon.channel"
				:title="loc('IM_RECENT_CREATE_CHANNEL_TITLE_V2')"
				:subtitle="loc('IM_RECENT_CREATE_CHANNEL_SUBTITLE_V3')"
				@click="onChatCreateClick(ChatType.channel)"
			/>
			<MenuItem
				:icon="MenuItemIcon.conference"
				:title="loc('IM_RECENT_CREATE_CONFERENCE_TITLE')"
				:subtitle="loc('IM_RECENT_CREATE_CONFERENCE_SUBTITLE_V2')"
				@click="onChatCreateClick(ChatType.videoconf)"
			/>
			<template #footer>
				<CreateChatHelp @articleOpen="showPopup = false" />
			</template>
		</MessengerMenu>
		<CreateChatPromo
			v-if="showPromo"
			:chatType="chatTypeToCreate"
			@continue="onPromoContinueClick"
			@close="showPromo = false"
		/>
	`,
};
