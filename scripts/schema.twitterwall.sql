-- scripts/schema.twitterwall.sql

--
-- Table `tweet` 
--
CREATE TABLE
	`tweet`
(
    `id` BIGINT NOT NULL PRIMARY KEY,
	-- `idStr` VARCHAR(255) NOT NULL,
	-- `fromUser` VARCHAR(255) NOT NULL,
	-- `fromUserIdStr` VARCHAR(255) NOT NULL,
	-- `fromUserName` VARCHAR(255) NOT NULL,
	-- `isoLanguageCode` VARCHAR(2) NOT NULL,
	-- `profileImageUrl` TEXT NOT NULL,
	-- `profileImageUrlHttps` TEXT NOT NULL,
	-- `source` TEXT NOT NULL,
	-- `text`TEXT NOT NULL,
	-- `toUser` VARCHAR(255) NULL,
	-- `toUserIdStr` VARCHAR(255) NULL,
	-- `toUserName` VARCHAR(255) NULL,
	-- `inReplyToStatusId` BIGINT NULL,
	`createdAt` VARCHAR(255) NOT NULL
)
;

--
-- Index `id`
-- 
CREATE INDEX
	`id`
ON
	`tweet` (`id`)
;
