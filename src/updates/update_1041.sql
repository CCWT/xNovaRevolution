ALTER TABLE `prefix_users`
ADD `rights` TEXT NOT NULL DEFAULT ''
AFTER `authlevel`;
UPDATE `prefix_users`
SET `rights` = 'a:24:{s:19:"ShowAccountDataPage";i:1;s:21:"ShowAccountEditorPage";i:1;s:14:"ShowActivePage";i:1;s:11:"ShowBanPage";i:1;s:14:"ShowConfigPage";i:1;s:15:"ShowCreatorPage";i:1;s:16:"ShowFacebookPage";i:1;s:19:"ShowFlyingFleetPage";i:1;s:19:"ShowInformationPage";i:1;s:19:"ShowMessageListPage";i:1;s:18:"ShowModVersionPage";i:1;s:14:"ShowModulePage";i:1;s:12:"ShowNewsPage";i:1;s:21:"ShowPassEncripterPage";i:1;s:19:"ShowQuickEditorPage";i:1;s:13:"ShowResetPage";i:1;s:14:"ShowRightsPage";i:1;s:14:"ShowSearchPage";i:1;s:20:"ShowSendMessagesPage";i:1;s:18:"ShowStatUpdatePage";i:1;s:13:"ShowStatsPage";i:1;s:15:"ShowSupportPage";i:1;s:17:"ShowTeamspeakPage";i:1;s:14:"ShowUpdatePage";i:1;}'
WHERE `id` = 1;
