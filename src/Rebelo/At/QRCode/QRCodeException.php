<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
//declare(strict_types=1);

namespace Rebelo\At\QRCode;

/**
 * CudException
 *
 * @author João Rebelo
 */
class QRCodeException extends \Exception
{
    /**
     * 
     * @param string $message
     * @param int $code
     * @param \Throwable $previous
     * @return void
     */
    public function __construct($message = "", $code = 0, \Throwable $previous = NULL)
    {
        \Logger::getLogger(\get_class($this))->error($message);
        parent::__construct($message, $code, $previous);
    }

}
