
# Code Challenge - Yii

Yii is a high-performance modern PHP framework best for developing both web applications and APIs.

[https://www.yiiframework.com/](https://www.yiiframework.com/)



## Specifications

1. Implement a simple Supplier List Page (View/Update/Delete are **NOT** needed) by using Yii's super powerful **GridView** widget.
2. Supplier structure looks like the below and please mock some random data by yourself.

```SQL
CREATE TABLE `supplier` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `code` char(3) CHARACTER SET ascii COLLATE ascii_general_ci DEFAULT NULL,
  `t_status` enum('ok','hold') CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL DEFAULT 'ok',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
```
3. A user can **filter** suppliers ...
    1. id - support:
        1. >10 - match all id greater than 10
        2. also support: <10, >=10, <=10, ...
    1. name and code - support partial matching
    2. t_status - a dropdown including all and each status
1. A user can **multi-select** suppliers, and of course, will have a convenient way to **select all** suppliers on the current page.
2. If a user selects all rows, he will be prompted and have a way to select all filtered rows **across all pages** and cancel. The following UX is for your reference. You can do it in your own way.

![](https://secure2.wostatic.cn/static/dGmHT5XMrp5jH193WV6eJA/image.png)

![](https://secure2.wostatic.cn/static/qEZmxc21W9BAHRJqeAQJ6H/image.png)

1. After having rows selected, the user can click an "Export" button to download all selected rows as a CSV file.
    1. The user will be asked (could be a modal or a single page): Which column(s) to be included in the CSV and column "id" is mandatory.
    2. And of course, this should correctly handle the "select across all pages" situation.



## Requirements

1. Please understand a code challenge is for letting us know your skills. Do **NOT** submit your code if you are not taking it seriously. Please pay attention to details, boundary data, and exceptions.
2. Use Yii's built-in or official extensions. Do **NOT** use other 3rd party components, like kartik/gridview.
3. Submit your code to github (You can create a new account if you don't want to mix it with your primary account.) Do **NOT** use other non-github platforms, like gitee.
4. Better if you could provide the link to a live demo of your code and have some reasonable data populated.
