CREATE TABLE `m_gp_list_163` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `code_sina` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `name_sina` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `code_163` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `code_download_163` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `name_163` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',
  `category` int(11) NOT NULL DEFAULT '0' COMMENT '分级',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='163';

insert into m_gp_list_163 (code_sina, code_163, name_163) select from_code as code_sina, code as code_163, name as name_163 from m_all group by code;

UPDATE m_gp_list_163 LEFT JOIN m_gp_list ON m_gp_list.code = m_gp_list_163.code_sina set m_gp_list_163.name_sina = m_gp_list.name;


-- where orders.id in(1,2,3)


CREATE TABLE `m_all` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `from_code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'from_code',
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'code',
  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT 'name',
  `timer` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '字符串时间',
  `timer_int` int(11) NOT NULL DEFAULT '0' COMMENT '时间截',
  `open_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日开盘价',
  `yesterday_close_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '昨日收盘价',
  `close_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '当前价格',
  `today_top_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日最高价',
  `today_bottom_price` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '今日最低价',
  `rise_and_fall_num` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '涨跌额',
  `rise_and_fall_percent` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '涨跌幅',
  `turnover_rate` float(10,4) NOT NULL DEFAULT '0.0000' COMMENT '换手率',
  `volume` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '成交量',
  `transaction_amount` float(10,3) NOT NULL DEFAULT '0.000' COMMENT '成交金额',
  PRIMARY KEY (`id`),
  UNIQUE KEY `code_time` (`from_code`,`timer`)
) ENGINE=InnoDB AUTO_INCREMENT=7388022 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='m_all';

-- 日期,股票代码,名称,
-- 2018-05-07,'600000,浦发银行,

-- 收盘价,最高价,最低价,开盘价,前收盘,
-- 10.84,10.89,10.76,10.82,10.83,

-- 涨跌额,涨跌幅,换手率,成交量,成交金额,
-- 0.01,0.0923,0.0976,27425378,297162770.0,

-- 总市值,流通市值,成交笔数
-- 3.18176551503e+11,3.04644800665e+11,None






