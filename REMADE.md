# conf
### 1 先引入 composer require superl/permission
### 2 建表
CREATE TABLE `conf` (
`conf_id` int NOT NULL AUTO_INCREMENT COMMENT '主键',
`conf_key` char(32) NOT NULL COMMENT 'key',
`content` json DEFAULT NULL COMMENT '内容',
`type` tinyint(1) DEFAULT NULL COMMENT '配置类型',
`user_key` int DEFAULT NULL COMMENT '用户id',
`comp_key` int DEFAULT NULL COMMENT '公司id',
`created_at` datetime DEFAULT NULL,
`updated_at` datetime DEFAULT NULL,
`deleted_at` datetime DEFAULT NULL,
PRIMARY KEY (`conf_id`)
) ENGINE=InnoDB AUTO_INCREMENT=298 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='配置'

### 如果需要自定义接口方法，先继承ConfController 或 ConfService
