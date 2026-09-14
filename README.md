# php-pairs-data

[![github action status](https://github.com/hexlet-components/php-pairs-data/workflows/PHP%20CI/badge.svg)](../../actions)

Functions for working with Lists.

## Examples

```php
<?php

use function Php\Pairs\Data\Lists\l;
use function Php\Pairs\Data\Lists\length;
use function Php\Pairs\Data\Lists\filter;
use function Php\Pairs\Data\Lists\toString;

$list = l(1, 2, 3, 4, 5, 6);
$length = length($list); // $length = 6;
$filter = filter($list, fn($x) => $x % 2 == 0);
$result = toString($filter); // $result = "(2, 4, 6)";
```

---

[![Hexlet Ltd. logo](https://raw.githubusercontent.com/Hexlet/assets/master/images/hexlet_logo128.png)](https://hexlet.io?utm_source=github&utm_medium=link&utm_campaign=php-pairs-data)

This repository is created and maintained by the team and the community of Hexlet, an educational project. [Read more about Hexlet](https://hexlet.io?utm_source=github&utm_medium=link&utm_campaign=php-pairs-data).
