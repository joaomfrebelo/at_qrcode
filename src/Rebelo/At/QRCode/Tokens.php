<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
declare(strict_types=1);

namespace Rebelo\At\QRCode;

/**
 * Tokens
 *
 * @author João Rebelo
 */
class Tokens
{
    /**
     * The delimiter char
     */
    const T_DELIMITER = "*";

    /**
     * Char that separetes the field name of the field value
     */
    const T_FIELD_SEP = ":";

    /**
     * Field A<br>
     * The issuer's TIN (NIF)
     */
    const T_ISSUER_TIN = 0;

    /**
     * Field B<br>
     * The buyer's TIN (NIF)
     */
    const T_BUYER_TIN = 1;

    /**
     * Field C<br>
     * The buyer's country
     */
    const T_BUYER_COUNTRY = 2;

    /**
     * Field D<br>
     * Document type (From SAFT-PT)
     */
    const T_DOC_TYPE = 3;

    /**
     * Field E<br>
     * Document status (From SAFT-PT)
     */
    const T_DOC_STATUS = 4;

    /**
     * Field F<br>
     * Document date (Format 'YYYYMMDD')
     */
    const T_DOC_DATE = 5;

    /**
     * Field G<br>
     * Document unique ID (Ex: FT A/999)
     */
    const T_DOC_NO = 6;

    /**
     * Field H<br>
     * AT_QRCODE
     */
    const T_ATCUD = 7;

    /**
     * Field I1<br>
     * Tax Country Region PT
     */
    const T_FISCAL_REGION_PT = 8;

    /**
     * Field I2<br>
     * Tax Country Region PT
     * VAT exempt tax base
     */
    const T_PT_EXEMPTED_BASE_IVA = 9;

    /**
     * Field I3<br>
     * Tax Country Region PT
     * VAT tax base at reduced rate
     */
    const T_PT_REDUCED_BASE_IVA = 10;

    /**
     * Field I4<br>
     * Tax Country Region PT
     * Total of tax base at reduced rate
     */
    const T_PT_REDUCED_TOTAL_IVA = 11;

    /**
     * Field I5<br>
     * Tax Country Region PT
     * VAT tax base at intermediate rate
     */
    const T_PT_INTERMEDIATE_BASE_IVA = 12;

    /**
     * Field I6<br>
     * Tax Country Region PT
     * Total of tax base at intermediate rate
     */
    const T_PT_INTERMEDIATE_TOTAL_IVA = 13;

    /**
     * Field I7<br>
     * Tax Country Region PT
     * VAT tax base at normal rate
     */
    const T_PT_NORMAL_BASE_IVA = 14;

    /**
     * Field I8<br>
     * Tax Country Region PT
     * Total of tax base at intermediate rate
     */
    const T_PT_NORMAL_TOTAL_IVA = 15;

    /**
     * Field J1<br>
     * Tax Country Region PTAC
     */
    const T_FISCAL_REGION_PTAC = 16;

    /**
     * Field J2<br>
     * Tax Country Region PTAC
     * VAT exempt tax base
     */
    const T_PTAC_EXEMPTED_BASE_IVA = 17;

    /**
     * Field J3<br>
     * Tax Country Region PTAC
     * VAT tax base at reduced rate
     */
    const T_PTAC_REDUCED_BASE_IVA = 18;

    /**
     * Field J4<br>
     * Tax Country Region PTAC
     * Total of tax base at reduced rate
     */
    const T_PTAC_REDUCED_TOTAL_IVA = 19;

    /**
     * Field J5<br>
     * Tax Country Region PTAC
     * VAT tax base at intermediate rate
     */
    const T_PTAC_INTERMEDIATE_BASE_IVA = 20;

    /**
     * Field J6<br>
     * Tax Country Region PTAC
     * Total of tax base at intermediate rate
     */
    const T_PTAC_INTERMEDIATE_TOTAL_IVA = 21;

    /**
     * Field J7<br>
     * Tax Country Region PTAC
     * VAT tax base at normal rate
     */
    const T_PTAC_NORMAL_BASE_IVA = 22;

    /**
     * Field J8<br>
     * Tax Country Region PTAC
     * Total of tax base at intermediate rate
     */
    const T_PTAC_NORMAL_TOTAL_IVA = 23;

    /**
     * Field K1<br>
     * Tax Country Region PTMA
     */
    const T_FISCAL_REGION_PTMA = 24;

    /**
     * Field K2<br>
     * Tax Country Region PTMA
     * VAT exempt tax base
     */
    const T_PTMA_EXEMPTED_BASE_IVA = 25;

    /**
     * Field K3<br>
     * Tax Country Region PTMA
     * VAT tax base at reduced rate
     */
    const T_PTMA_REDUCED_BASE_IVA = 26;

    /**
     * Field K4<br>
     * Tax Country Region PTMA
     * Total of tax base at reduced rate
     */
    const T_PTMA_REDUCED_TOTAL_IVA = 27;

    /**
     * Field K5<br>
     * Tax Country Region PTMA
     * VAT tax base at intermediate rate
     */
    const T_PTMA_INTERMEDIATE_BASE_IVA = 28;

    /**
     * Field K6<br>
     * Tax Country Region PTMA
     * Total of tax base at intermediate rate
     */
    const T_PTMA_INTERMEDIATE_TOTAL_IVA = 29;

    /**
     * Field K7<br>
     * Tax Country Region PTMA
     * VAT tax base at normal rate
     */
    const T_PTMA_NORMAL_BASE_IVA = 30;

    /**
     * Field K8<br>
     * Tax Country Region PTMA
     * Total of tax base at intermediate rate
     */
    const T_PTMA_NORMAL_TOTAL_IVA = 31;

    /**
     * Field L<br>
     * Total value related to non-subject / non-taxable transactions in VAT (IVA).
     */
    const T_TOTAL_NON_IVA = 32;

    /**
     * Field M<br>
     * Total of stamp tax.
     */
    const T_TOTAL_STAMP_TAX = 33;

    /**
     * Field N<br>
     * Total value of Taxs (VAT (IVA) plus Stamp tax).
     */
    const T_TAX_PAYABLE = 34;

    /**
     * Field O<br>
     * Document gross total.
     */
    const T_GROSS_TOTAL = 35;

    /**
     * Field P<br>
     * Document gross total.
     */
    const T_WITHHOLDING_TAX_AMOUNT = 36;

    /**
     * Field Q<br>
     * Sign hash (4 carateres of Hash).
     */
    const T_HASH = 37;

    /**
     * Field R<br>
     * Software certification number.
     */
    const T_CERTIFICATE = 38;

    /**
     * Field R<br>
     * Other information
     */
    const T_OTHER_INFO = 39;

    /**
     * The fields name
     * @var array<int, string> Name of the fields in the QRCode string
     */
    protected static ?array $fields = null;

    /**
     * Instanciate the tokenizer
     */
    protected function __construct()
    {
        \Logger::getLogger(\get_class($this))->debug(__METHOD__);
    }

    /**
     * Get the tokens
     * @return string[]
     */
    public static function getTokens() : array
    {
        $stack                                    = array();
        $stack[self::T_ISSUER_TIN]                  = "A";
        $stack[self::T_BUYER_TIN]                   = "B";
        $stack[self::T_BUYER_COUNTRY]               = "C";
        $stack[self::T_DOC_TYPE]                    = "D";
        $stack[self::T_DOC_STATUS]                  = "E";
        $stack[self::T_DOC_DATE]                    = "F";
        $stack[self::T_DOC_NO]                      = "G";
        $stack[self::T_ATCUD]                       = "H";
        $stack[self::T_FISCAL_REGION_PT]            = "I1";
        $stack[self::T_PT_EXEMPTED_BASE_IVA]        = "I2";
        $stack[self::T_PT_REDUCED_BASE_IVA]         = "I3";
        $stack[self::T_PT_REDUCED_TOTAL_IVA]        = "I4";
        $stack[self::T_PT_INTERMEDIATE_BASE_IVA]    = "I5";
        $stack[self::T_PT_INTERMEDIATE_TOTAL_IVA]   = "I6";
        $stack[self::T_PT_NORMAL_BASE_IVA]          = "I7";
        $stack[self::T_PT_NORMAL_TOTAL_IVA]         = "I8";
        $stack[self::T_FISCAL_REGION_PTAC]          = "J1";
        $stack[self::T_PTAC_EXEMPTED_BASE_IVA]      = "J2";
        $stack[self::T_PTAC_REDUCED_BASE_IVA]       = "J3";
        $stack[self::T_PTAC_REDUCED_TOTAL_IVA]      = "J4";
        $stack[self::T_PTAC_INTERMEDIATE_BASE_IVA]  = "J5";
        $stack[self::T_PTAC_INTERMEDIATE_TOTAL_IVA] = "J6";
        $stack[self::T_PTAC_NORMAL_BASE_IVA]        = "J7";
        $stack[self::T_PTAC_NORMAL_TOTAL_IVA]       = "J8";
        $stack[self::T_FISCAL_REGION_PTMA]          = "K1";
        $stack[self::T_PTMA_EXEMPTED_BASE_IVA]      = "K2";
        $stack[self::T_PTMA_REDUCED_BASE_IVA]       = "K3";
        $stack[self::T_PTMA_REDUCED_TOTAL_IVA]      = "K4";
        $stack[self::T_PTMA_INTERMEDIATE_BASE_IVA]  = "K5";
        $stack[self::T_PTMA_INTERMEDIATE_TOTAL_IVA] = "K6";
        $stack[self::T_PTMA_NORMAL_BASE_IVA]        = "K7";
        $stack[self::T_PTMA_NORMAL_TOTAL_IVA]       = "K8";
        $stack[self::T_TOTAL_NON_IVA]               = "L";
        $stack[self::T_TOTAL_STAMP_TAX]             = "M";
        $stack[self::T_TAX_PAYABLE]                 = "N";
        $stack[self::T_GROSS_TOTAL]                 = "O";
        $stack[self::T_WITHHOLDING_TAX_AMOUNT]      = "P";
        $stack[self::T_HASH]                        = "Q";
        $stack[self::T_CERTIFICATE]                 = "R";
        $stack[self::T_OTHER_INFO]                  = "S";
        return $stack;
    }
}
