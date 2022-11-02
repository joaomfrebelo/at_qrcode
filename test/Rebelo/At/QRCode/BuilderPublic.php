<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
declare(strict_types=1);

namespace Rebelo\At\QRCode;

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

	/**
	 *
	 * @param string $qrQrCodeStr
	 * @param bool   $setValue
	 *
	 * @throws \Rebelo\At\QRCode\QRCodeException
	 */
    public function iterateCode(string $qrQrCodeStr, bool $setValue) : void
    {
        parent::iterateCode($qrQrCodeStr, $setValue);
    }
}
