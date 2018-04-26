CREATE TABLE `m_gp_list_163` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code_sina` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `code_163` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `code_download_163` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT '分级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='163';

insert into m_gp_list_163 (code_sina, code_163, name) select from_code as code_sina, code as code_163, name from m_all group by code;

