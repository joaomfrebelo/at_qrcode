<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
declare(strict_types=1);

namespace Rebelo\At\QRCode;

use Rebelo\At\QRCode\Builder;
/**
 * BuilderPublic<br>
 * Get the protected and private methods of builder as public for test
 * @author João Rebelo
 */
class BuilderPublic extends Builder
{
    function __construct()
    {
        parent::__construct();
    }

    public function iterateCode($code, $setvalue)
    {
        parent::iterateCode($code, $setvalue);
    }
}
