DROP TABLE IF EXISTS `ac_collections_to_stores`;
CREATE TABLE `ac_collections_to_stores` (
     `collection_id` int(11) NOT NULL,
     `store_id` int(11) NOT NULL,
     PRIMARY KEY (`collection_id`,`store_id`)
) ENGINE=InnoDb DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `ac_collections_to_stores` (collection_id, store_id)
SELECT id, store_id
FROM `ac_collections`;

ALTER TABLE `ac_collections`
    DROP COLUMN `store_id`,
    ADD COLUMN `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    modify name varchar(255) null,
    modify description text null,
    modify conditions text null
;
ALTER TABLE `ac_collection_descriptions`
    ADD COLUMN `content` longtext NOT NULL COMMENT 'translatable',
    ADD COLUMN `date_added` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    ADD COLUMN `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    modify title varchar(255) null,
    modify meta_keywords text null,
    modify meta_description text null
;
