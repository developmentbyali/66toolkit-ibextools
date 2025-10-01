UPDATE `settings` SET `value` = '{\"version\":\"27.1.0\", \"code\":\"2710\"}' WHERE `key` = 'product_info';

-- SEPARATOR --

alter table users add next_cleanup_datetime datetime default CURRENT_TIMESTAMP null after datetime;
