<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2022-01-08 23:23:16 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ')' /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/models/Cupones.php 13
ERROR - 2022-01-08 23:30:08 --> Query error: Unknown column 'td.id_descuento' in 'on clause' - Invalid query: SELECT `c`.`id_cupon`, `c`.`codigo`, `c`.`descuento`, `c`.`activo`, `td`.`id_tipo_descuento`, `td`.`descripcion`
FROM `cupones` as `c`
LEFT JOIN `tipos_descuento` as `td` ON `td`.`id_descuento` = `c`.`id_descuento`
WHERE `eliminado` = 0
ERROR - 2022-01-08 23:30:30 --> Query error: Unknown column 'c.id_descuento' in 'on clause' - Invalid query: SELECT `c`.`id_cupon`, `c`.`codigo`, `c`.`descuento`, `c`.`activo`, `td`.`id_tipo_descuento`, `td`.`descripcion`
FROM `cupones` as `c`
LEFT JOIN `tipos_descuento` as `td` ON `td`.`id_tipo_descuento` = `c`.`id_descuento`
WHERE `eliminado` = 0
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 14
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'name' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 14
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 17
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'price' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 17
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 18
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'orden' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 18
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 21
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'stock_disponible' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 21
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'stock_ilimitado' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'visible_sucursal' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'visible_domicilio' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'active' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 40
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'orden_listados' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 40
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 43
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 43
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 44
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 44
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 14
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'name' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 14
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 17
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'price' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 17
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 18
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'orden' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 18
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 21
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'stock_disponible' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 21
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'stock_ilimitado' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 24
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'visible_sucursal' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 30
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'visible_domicilio' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 34
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'active' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 38
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 40
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'orden_listados' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 40
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 43
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 43
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Undefined variable: extra /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 44
ERROR - 2022-01-08 23:30:42 --> Severity: Notice --> Trying to get property 'id' of non-object /Applications/XAMPP/xamppfiles/htdocs/ebo/backoffice/application/views/dashboard/cupones.php 44
