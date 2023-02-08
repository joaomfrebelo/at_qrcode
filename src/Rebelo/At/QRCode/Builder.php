<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
declare(strict_types=1);

namespace Rebelo\At\QRCode;

require_once dirname(__FILE__)."/../../../../external/phpqrcode/phpqrcode.php";

/**
 * The Cud class
 * @author João Rebelo>
 * @since 1.0.0
 */
class Builder
{
    /**
     * Code size
     * @var int
     */
    public static int $size = 2;

    /**
     * Code margin
     * @var int
     */
    public static int $margin = 2;

    /**
     * QRcode ECC level
     * @var int
     */
    public static int $level = QR_ECLEVEL_M;

    /**
     *
     * @var string[]
     */
    protected array $properties = array();

    /**
     *
     * @since 1.1.0
     */
    public function __construct()
    {
        \Logger::configure(
            dirname(__FILE__)."/../../../../log4php.xml"
        );
        \Logger::getLogger(\get_class($this))->debug(__METHOD__);
    }

    /**
     * Get all setted properties, all properties are returned as string
     * @return string[] All setted properties as string
     */
    public function getProperties() : array
    {
        return $this->properties;
    }

    /**
     * Format the float to string
     * @param float $float
     * @return string
     */
    public static function formatFloat(float $float) : string
    {
        return \number_format($float, 2, ".", "");
    }

    /**
     * Field: A (This field is mandatory)<br>
     * Issuer TIN (NIF)<br>
     * Fill in with the issuer's TIN (NIF) without Country prefix<br>
     * @param string $tin The company tax id (NIF)
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setIssuerTin(string $tin) : Builder
    {
        if (\preg_match("/^[0-9]{9}$/", $tin) !== 1) {
            throw new QRCodeException("issuer_tin_wrong_format");
        }

        $this->properties[Tokens::T_ISSUER_TIN] = $tin;
        return $this;
    }

    /**
     * Field: A (This field is mandatory)<br>
     * Issuer TIN (NIF)<br>
     * The issuer's TIN (NIF) without Country prefix<br>
     * @return string|null The company TIN (NIF)
     */
    public function getIssuerTin() : ?string
    {
        if (\array_key_exists(Tokens::T_ISSUER_TIN, $this->properties)) {
            return $this->properties[Tokens::T_ISSUER_TIN];
        }
        return null;
    }

    /**
     * Field: B (This field is mandatory)<br>
     * Buyer's TIN (NIF)<br>
     * Fill in with the buyer's TIN. When issuing a document,
     * the “Final Consumer” fill in with 999999990.<br>
     * @param string $tin The buyer's TIN (NIF)
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setBuyerTin(string $tin) : Builder
    {
        if (\strlen($tin) > 30 || $tin === "") {
            throw new QRCodeException("buyer_tin_wrong_format");
        }

        $this->properties[Tokens::T_BUYER_TIN] = $tin;
        return $this;
    }

    /**
     * Field: B (This field is mandatory)<br>
     * Buyer's TIN (NIF)<br>
     * The buyer's TIN (NIF)
     * @return string|null The buyer's TIN (NIF)
     */
    public function getBuyerTin(): ?string
    {
        if (\array_key_exists(Tokens::T_BUYER_TIN, $this->properties)) {
            return $this->properties[Tokens::T_BUYER_TIN];
        }
        return null;
    }

    /**
     * Field: C (This field is mandatory)<br>
     * Buyer's Country<br>
     * Fill in with the buyer's country code, as the Customers SAFT table.<br>
     * @param string $countryCode The country code
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setCountryCode(string $countryCode) : Builder
    {
        if (\strlen($countryCode) > 12 || $countryCode === "") {
            throw new QRCodeException("country_code_wrong_format");
        }

        $this->properties[Tokens::T_BUYER_COUNTRY] = $countryCode;
        return $this;
    }

    /**
     * Field: C (This field is mandatory)<br>
     * Buyer's Country<br>
     * @return string|null The buyer's country code
     */
    public function getCountryCode() : ?string
    {
        if (\array_key_exists(Tokens::T_BUYER_COUNTRY, $this->properties)) {
            return $this->properties[Tokens::T_BUYER_COUNTRY];
        }
        return null;
    }

    /**
     * Field: D (This field is mandatory)<br>
     * Document type<br>
     * Fill in according to the type of SAF-T (PT).<br>
     * @param string $type The document type
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setDocType(string $type) : Builder
    {
        if (\strlen($type) !== 2) {
            throw new QRCodeException("doc_type_wrong_format");
        }

        $this->properties[Tokens::T_DOC_TYPE] = $type;
        return $this;
    }

    /**
     * Field: D (This field is mandatory)<br>
     * Document type<br>
     * According to the type of SAF-T (PT).<br>
     * @return string|null The document type
     */
    public function getDocType() : ?string
    {
        if (\array_key_exists(Tokens::T_DOC_TYPE, $this->properties)) {
            return $this->properties[Tokens::T_DOC_TYPE];
        }
        return null;
    }

    /**
     * Field: E (This field is mandatory)<br>
     * Document status<br>
     * Fill in according to the type of SAF-T (PT).<br>
     * @param string $status The document status
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setDocStatus(string $status) : Builder
    {
        if (\strlen($status) !== 1) {
            throw new QRCodeException("doc_status_wrong_format");
        }

        $this->properties[Tokens::T_DOC_STATUS] = $status;
        return $this;
    }

    /**
     * Field: E (This field is mandatory)<br>
     * Document status<br>
     * According to the type of SAF-T (PT).<br>
     * @return string|null The document status
     */
    public function getDocStatus() : ?string
    {
        if (\array_key_exists(Tokens::T_DOC_STATUS, $this->properties)) {
            return $this->properties[Tokens::T_DOC_STATUS];
        }
        return null;
    }

    /**
     * Field: F (This field is mandatory)<br>
     * Document date<br>
     * Use the format 'YYYYMMDD'<br>
     * @param string $date The document date
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setDocDate(string $date) : Builder
    {
        if (\preg_match("/^20([0-9]){6}$/", $date) !== 1) {
            throw new QRCodeException("doc_date_wrong_format");
        }

        $this->properties[Tokens::T_DOC_DATE] = $date;
        return $this;
    }

    /**
     * Field: F (This field is mandatory)<br>
     * Document date<br>
     * Format 'YYYYMMDD'<br>
     * @return string|null The document status
     */
    public function getDocDate() : ?string
    {
        if (\array_key_exists(Tokens::T_DOC_DATE, $this->properties)) {
            return $this->properties[Tokens::T_DOC_DATE];
        }
        return null;
    }

    /**
     * Field: G (This field is mandatory)<br>
     * Unique identification of the document<br>
     * Fill in according to the type of SAF-T (PT).<br>
     * Ex: 'FT A/999'<br>
     * @param string $docNo The document identifier
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setDocNo(string $docNo) : Builder
    {
        if (\strlen($docNo) > 60 || $docNo === "") {
            throw new QRCodeException("doc_no_wrong_format");
        }

        $this->properties[Tokens::T_DOC_NO] = $docNo;
        return $this;
    }

    /**
     * Field: G (This field is mandatory)<br>
     * Unique identification of the document<br>
     * According to the type of SAF-T (PT).<br>
     * Ex: 'FT A/999'<br>
     * @return string|null The document status
     */
    public function getDocNo() : ?string
    {
        if (\array_key_exists(Tokens::T_DOC_NO, $this->properties)) {
            return $this->properties[Tokens::T_DOC_NO];
        }
        return null;
    }

    /**
     * Field: H (This field is mandatory)<br>
     * ATCUD<br>
     * Ex: 'CSDF7T5H-35'<br>
     * @param string $atcud The ATCUD
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setAtcud(string $atcud) : Builder
    {
        if ($atcud !== "0") {
            if (\strlen($atcud) > 70 || \preg_match("/^[A-Z0-9]+-[0-9]+$/", $atcud) !== 1) {
                throw new QRCodeException("atcud_wrong_format");
            }
        }

        $this->properties[Tokens::T_ATCUD] = $atcud;
        return $this;
    }

    /**
     * Field: H (This field is mandatory)<br>
     * ATCUD<br>
     * Ex: 'CSDF7T5H-35'<br>
     * @return string|null The ATCUD
     */
    public function getAtcud() : ?string
    {
        if (\array_key_exists(Tokens::T_ATCUD, $this->properties)) {
            return $this->properties[Tokens::T_ATCUD];
        }
        return null;
    }

    /**
     * Field: I1<br>
     * Invoke only this method if the case of a document
     * without an indication of the VAT rate,
     * which should appear in table 4.2, 4.3 or 4.4 of the SAF-T (PT)
     * @return \Rebelo\At\QRCode\Builder
     */
    public function setDocWithoutVat() : Builder
    {
        $this->properties[Tokens::T_FISCAL_REGION_PT] = "0";
        return $this;
    }

    /**
     * Field: I1<br>
     * Verify if is a document
     * without an indication of the VAT rate,
     * which should appear in table 4.2, 4.3 or 4.4 of the SAF-T (PT)
     * @return bool|null null if is not setted
     */
    public function isDocWithoutVat() :?bool
    {
        if (\array_key_exists(Tokens::T_FISCAL_REGION_PT, $this->properties)) {
            return $this->properties[Tokens::T_FISCAL_REGION_PT] === "0";
        }

        if (\array_key_exists(Tokens::T_FISCAL_REGION_PTAC, $this->properties) ||
            \array_key_exists(Tokens::T_FISCAL_REGION_PTMA, $this->properties)) {
            return false;
        }
        return null;
    }

    /**
     * Field: I2<br>
     * VAT-exempt tax base of PT fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @param float $value Total value of the tax base exempt from VAT
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTExemptedBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptexcemptedbasevat_wrong_format");
        }

        $this->properties[Tokens::T_PT_EXEMPTED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]     = "PT";
        return $this;
    }

    /**
     * Field: I2<br>
     * VAT-exempt tax base of PT fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @return float|null Total value of the tax base exempt from VAT
     */
    public function getPTExemptedBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PT_EXEMPTED_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PT_EXEMPTED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: I3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTReducedBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_REDUCED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]    = "PT";
        return $this;
    }

    /**
     * Field: I3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTReducedBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PT_REDUCED_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PT_REDUCED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: I4<br>
     * Total VAT at reduced rate<br>
     * @param float $value Total VAT at reduced rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTReducedTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_REDUCED_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]     = "PT";
        return $this;
    }

    /**
     * Field: I4<br>
     * Total VAT at reduced rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTReducedTotalVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PT_REDUCED_TOTAL_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PT_REDUCED_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: I5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTIntermediateBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_INTERMEDIATE_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]         = "PT";
        return $this;
    }

    /**
     * Field: I5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTIntermediateBaseVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PT_INTERMEDIATE_BASE_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PT_INTERMEDIATE_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: I6<br>
     * Total VAT at intermediate rate<br>
     * @param float $value Total VAT at intermediate rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTIntermediateTotalVat(float $value) : Builder
    {

        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_INTERMEDIATE_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]          = "PT";
        return $this;
    }

    /**
     * Field: I6<br>
     * Total VAT at intermediate rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTIntermediateTotalVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PT_INTERMEDIATE_TOTAL_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PT_INTERMEDIATE_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: I7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTNormalBaseVat(float $value) : Builder
    {

        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_NORMAL_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]   = "PT";
        return $this;
    }

    /**
     * Field: I7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTNormalBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PT_NORMAL_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PT_NORMAL_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: I8<br>
     * Total VAT at normal rate<br>
     * @param float $value Total VAT at normal rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTNormalTotalVat(float $value) : Builder
    {

        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PT_NORMAL_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PT]    = "PT";
        return $this;
    }

    /**
     * Field: I8<br>
     * Total VAT at normal rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTNormalTotalVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PT_NORMAL_TOTAL_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PT_NORMAL_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: J2<br>
     * VAT-exempt tax base of PTAC fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @param float $value Total value of the tax base exempt from VAT
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACExemptedBaseVat(float $value) : Builder
    {

        if ($value <= 0) {
            throw new QRCodeException("ptexcemptedbasevat_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_EXEMPTED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]     = "PT-AC";
        return $this;
    }

    /**
     * Field: J2<br>
     * VAT-exempt tax base of PTAC fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @return float|null Total value of the tax base exempt from VAT
     */
    public function getPTACExemptedBaseVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTAC_EXEMPTED_BASE_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTAC_EXEMPTED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: J3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACReducedBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_REDUCED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]    = "PT-AC";
        return $this;
    }

    /**
     * Field: J3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTACReducedBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTAC_REDUCED_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTAC_REDUCED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: J4<br>
     * Total VAT at reduced rate<br>
     * @param float $value Total VAT at reduced rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACReducedTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_REDUCED_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]     = "PT-AC";
        return $this;
    }

    /**
     * Field: J4<br>
     * Total VAT at reduced rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTACReducedTotalVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTAC_REDUCED_TOTAL_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTAC_REDUCED_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: J5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACIntermediateBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_INTERMEDIATE_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]         = "PT-AC";
        return $this;
    }

    /**
     * Field: J5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTACIntermediateBaseVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTAC_INTERMEDIATE_BASE_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTAC_INTERMEDIATE_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: J6<br>
     * Total VAT at intermediate rate<br>
     * @param float $value Total VAT at intermediate rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACIntermediateTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]          = "PT-AC";
        return $this;
    }

    /**
     * Field: J6<br>
     * Total VAT at intermediate rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTACIntermediateTotalVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: J7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACNormalBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_NORMAL_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]   = "PT-AC";
        return $this;
    }

    /**
     * Field: J7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTACNormalBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTAC_NORMAL_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTAC_NORMAL_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: J8<br>
     * Total VAT at normal rate<br>
     * @param float $value Total VAT at normal rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTACNormalTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTAC_NORMAL_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTAC]    = "PT-AC";
        return $this;
    }

    /**
     * Field: J8<br>
     * Total VAT at normal rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTACNormalTotalVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTAC_NORMAL_TOTAL_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTAC_NORMAL_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: K2<br>
     * VAT-exempt tax base of PTMA fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @param float $value Total value of the tax base exempt from VAT
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMAExemptedBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptexcemptedbasevat_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_EXEMPTED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]     = "PT-MA";
        return $this;
    }

    /**
     * Field: K2<br>
     * VAT-exempt tax base of PTMA fiscal region<br>
     * Total value of the tax base exempt from VAT
     * (including taxable transactions under Stamp Duty,
     * whether they are exempt from Stamp Duty).
     * @return float|null Total value of the tax base exempt from VAT
     */
    public function getPTMAExemptedBaseVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTMA_EXEMPTED_BASE_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTMA_EXEMPTED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: K3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMAReducedBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_REDUCED_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]    = "PT-MA";
        return $this;
    }

    /**
     * Field: K3<br>
     * VAT tax base at reduced rate<br>
     * Total value of the tax base subject to the reduced VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTMAReducedBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTMA_REDUCED_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTMA_REDUCED_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: K4<br>
     * Total VAT at reduced rate<br>
     * @param float $value Total VAT at reduced rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMAReducedTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptreducedbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_REDUCED_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]     = "PT-MA";
        return $this;
    }

    /**
     * Field: K4<br>
     * Total VAT at reduced rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTMAReducedTotalVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTMA_REDUCED_TOTAL_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTMA_REDUCED_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: K5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMAIntermediateBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_INTERMEDIATE_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]         = "PT-MA";
        return $this;
    }

    /**
     * Field: K5<br>
     * VAT tax base at intermediate rate<br>
     * Total value of the tax base subject to the intermediate VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTMAIntermediateBaseVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTMA_INTERMEDIATE_BASE_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTMA_INTERMEDIATE_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: K6<br>
     * Total VAT at intermediate rate<br>
     * @param float $value Total VAT at intermediate rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMAIntermediateTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptintermediatebaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]          = "PT-MA";
        return $this;
    }

    /**
     * Field: K6<br>
     * Total VAT at intermediate rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTMAIntermediateTotalVat() : ?float
    {
        if (\array_key_exists(
            Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: K7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @param float $value Total value of the tax base
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMANormalBaseVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_NORMAL_BASE_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]   = "PT-MA";
        return $this;
    }

    /**
     * Field: K7<br>
     * VAT tax base at normal rate<br>
     * Total value of the tax base subject to the normal VAT rate.
     * @return float|null Total value of the tax base
     */
    public function getPTMANormalBaseVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTMA_NORMAL_BASE_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTMA_NORMAL_BASE_IVA];
        }
        return null;
    }

    /**
     * Field: K8<br>
     * Total VAT at normal rate<br>
     * @param float $value Total VAT at normal rate
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setPTMANormalTotalVat(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("ptnormalbaseiva_wrong_format");
        }

        $this->properties[Tokens::T_PTMA_NORMAL_TOTAL_IVA] = self::formatFloat($value);
        $this->properties[Tokens::T_FISCAL_REGION_PTMA]    = "PT-MA";
        return $this;
    }

    /**
     * Field: K8<br>
     * Total VAT at normal rate<br>
     * @return float|null Total VAT at reduced rate
     */
    public function getPTMANormalTotalVat() : ?float
    {
        if (\array_key_exists(Tokens::T_PTMA_NORMAL_TOTAL_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_PTMA_NORMAL_TOTAL_IVA];
        }
        return null;
    }

    /**
     * Field: L<br>
     * Not subject / non-taxable in VAT (IVA)<br>
     * Total value related to non-subject / non-taxable transactions in VAT.
     * @param float $value Total value non-subject / non-taxable
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setTotalNonVat(float $value) : Builder
    {
        if ($value <= 0.0) {
            throw new QRCodeException("noniva_wrong_format");
        }

        $this->properties[Tokens::T_TOTAL_NON_IVA] = self::formatFloat($value);
        return $this;
    }

    /**
     * Field: L<br>
     * Not subject / non-taxable in VAT (IVA)<br>
     * Total value related to non-subject / non-taxable transactions in VAT.
     * @return float|null Total value of non-subject / non-taxable
     */
    public function getTotalNonVat() : ?float
    {
        if (\array_key_exists(Tokens::T_TOTAL_NON_IVA, $this->properties)) {
            return (float) $this->properties[Tokens::T_TOTAL_NON_IVA];
        }
        return null;
    }

    /**
     * Field: M<br>
     * Stamp tax<br>
     * Total value of stamp tax.
     * @param float $value Total value of stamp tax
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setTotalStampTax(float $value) : Builder
    {
        if ($value <= 0.0) {
            throw new QRCodeException("stamptax_wrong_format");
        }

        $this->properties[Tokens::T_TOTAL_STAMP_TAX] = self::formatFloat($value);
        return $this;
    }

    /**
     * Field: M<br>
     * Stamp tax<br>
     * Total value of stamp tax.
     * @return float|null Total value of stamp tax
     */
    public function getTotalStampTax() : ?float
    {
        if (\array_key_exists(Tokens::T_TOTAL_STAMP_TAX, $this->properties)) {
            return (float) $this->properties[Tokens::T_TOTAL_STAMP_TAX];
        }
        return null;
    }

    /**
     * Field: N<br>
     * TaxPayable<br>
     * Total value of VAT and Stamp Tax - TaxPayable field of SAF-T (PT)
     * @param float $value Total value of tax payable
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setTaxPayable(float $value) : Builder
    {
        if ($value < 0.0) {
            throw new QRCodeException("taxpayable_wrong_format");
        }

        $this->properties[Tokens::T_TAX_PAYABLE] = self::formatFloat($value);
        return $this;
    }

    /**
     * Field: N<br>
     * TaxPayable<br>
     * Total value of VAT and Stamp Tax - TaxPayable field of SAF-T (PT)
     * @return float|null Total tax payable
     */
    public function getTaxPayable() : ?float
    {
        if (\array_key_exists(Tokens::T_TAX_PAYABLE, $this->properties)) {
            return (float) $this->properties[Tokens::T_TAX_PAYABLE];
        }
        return null;
    }

    /**
     * Field: O<br>
     * Gross total<br>
     * Total document value - GrossTotal field of SAF-T (PT).
     * @param float $value Total gross
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setGrossTotal(float $value) : Builder
    {
        if ($value < 0.0) {
            throw new QRCodeException("grosstotal_wrong_format");
        }

        $this->properties[Tokens::T_GROSS_TOTAL] = self::formatFloat($value);
        return $this;
    }

    /**
     * Field: O<br>
     * Gross total<br>
     * Total document value - GrossTotal field of SAF-T (PT).
     * @return float|null Total gross
     */
    public function getGrossTotal() :?float
    {
        if (\array_key_exists(Tokens::T_GROSS_TOTAL, $this->properties)) {
            return (float) $this->properties[Tokens::T_GROSS_TOTAL];
        }
        return null;
    }

    /**
     * Field: P<br>
     * Withholding Tax Amount<br>
     * @param float $value Withholding Tax Amount
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setWithholdingTaxAmount(float $value) : Builder
    {
        if ($value <= 0) {
            throw new QRCodeException("withholdingtaxamount_wrong_format");
        }

        $this->properties[Tokens::T_WITHHOLDING_TAX_AMOUNT] = self::formatFloat($value);
        return $this;
    }

    /**
     * Field: P<br>
     * Withholding Tax Amount
     * @return float|null Withholding Tax Amount
     */
    public function getWithholdingTaxAmount() :?float
    {
        if (\array_key_exists(
            Tokens::T_WITHHOLDING_TAX_AMOUNT, $this->properties
        )) {
            return (float) $this->properties[Tokens::T_WITHHOLDING_TAX_AMOUNT];
        }
        return null;
    }

    /**
     * Field: Q<br>
     * 4 Hash characters<br>
     * In case of documents with no digital signature hash the field is filled with 0 (zero)
     * @param string $hash The 4 Hash characters or 0 if no hash
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setHash(string $hash) : Builder
    {
        if (\strlen($hash) !== 4 && $hash !== "0") {
            throw new QRCodeException("hash_wrong_format");
        }

        $this->properties[Tokens::T_HASH] = $hash;
        return $this;
    }

    /**
     * Field: Q<br>
     * 4 Hash characters
     * @return string|null The 4 Hash characters
     */
    public function getHash() : ?string
    {
        if (\array_key_exists(Tokens::T_HASH, $this->properties)) {
            return $this->properties[Tokens::T_HASH];
        }
        return null;
    }

    /**
     * Field: R<br>
     * Program certificate number<br>
     * @param int $number The Certificate number
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setCertificateNo(int $number) : Builder
    {
        if ($number < 1 || $number > 9999) {
            throw new QRCodeException("certificate_wrong_format");
        }

        $this->properties[Tokens::T_CERTIFICATE] = (string) $number;
        return $this;
    }

    /**
     * Field: R<br>
     * Program certificate number
     * @return int|null Program certificate number
     */
    public function getCertificateNo() : ?int
    {
        if (\array_key_exists(Tokens::T_CERTIFICATE, $this->properties)) {
            return (int) $this->properties[Tokens::T_CERTIFICATE];
        }
        return null;
    }

    /**
     * Field: S<br>
     * Other info<br>
     * Field of free filling, in which, for example,
     * information for payment can be indicated
     * (ex: from IBAN or Ref MB, with the tab «;»).
     * This field cannot contain the asterisk character (*).
     * @param string $info Other info
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function setOtherInfo(string $info) : Builder
    {
        if (\strlen($info) > 65 || $info === "") {
            throw new QRCodeException("otherinfo_wrong_format");
        }

        if (\preg_match("/\*/", $info) === 1) {
            throw new QRCodeException("otherinfo_wrong_format");
        }

        $this->properties[Tokens::T_OTHER_INFO] = $info;
        return $this;
    }

    /**
     * Field: S<br>
     * Other info<br>
     * Field of free filling, in which, for example,
     * information for payment can be indicated
     * (ex: from IBAN or Ref MB, with the tab «;»).
     * This field cannot contain the asterisk character (*).
     * @return string|null Info
     */
    public function getOtherInfo() : ?string
    {
        if (\array_key_exists(Tokens::T_OTHER_INFO, $this->properties)) {
            return $this->properties[Tokens::T_OTHER_INFO];
        }
        return null;
    }

    /**
     * Get QrCode string
     * @param bool $check Check fields
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @return string
     */
    public function getQrCodeString(bool $check = true) : string
    {
        $tokens = Tokens::getTokens();
        $qr     = "";
        if (ksort($this->properties, SORT_NUMERIC) === false) {
            $msg = "Error sorting field array";
            \Logger::getLogger(\get_class($this))->error(
                \sprintf("%s in '%s'", $msg, __METHOD__)
            );
            throw new QRCodeException($msg);
        }
        foreach ($this->properties as $k => $v) {
            $qr .= $tokens[$k].Tokens::T_FIELD_SEP.$v.Tokens::T_DELIMITER;
        }

        $qrCode = \substr($qr, 0, -1);

        if ($check === true) {
            $this->iterateCode($qrCode, false);
        }
        return $qrCode;
    }

    /**
     * Iterate over the string tokens to check if are correct.
     *
     * @param string $qrQrQrCodeStr The QrCode string
     * @param bool   $setValue      If true properties of Builder wil be setted, used for parse a string
     *
     * @return void
     *@throws QRCodeException
     */
    protected function iterateCode(string $qrQrQrCodeStr, bool $setValue) : void
    {
        \Logger::getLogger(\get_class($this))->debug(__METHOD__);
        $msgParsed = "Field '%s' parsed with value '%s'";
        $errorStop = "QRcode string wrong stop at '%s'";
        $error     = "Next filed should be '%s' but is '%s'";
        $tokens    = Tokens::getTokens();
        $spl       = \explode("*", $qrQrQrCodeStr);

        // Field A, Index 0
        /* @phpstan-ignore-next-line */
        if (\reset($spl) === false) {
            $msg = "Wrong format or empty QRCode string";
            \Logger::getLogger(\get_class($this))->error(
                \sprintf("%s in '%s'", $msg, __METHOD__)
            );
            throw new QRCodeException($msg);
        }

        $field = "";
        $value = "";
        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_ISSUER_TIN]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setIssuerTin($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_ISSUER_TIN], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field B, Index 1
        if (\next($spl) === false) {
            $msg = \sprintf($error, $tokens[Tokens::T_BUYER_TIN], "");
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_BUYER_TIN]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setBuyerTin($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_BUYER_TIN], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field C, Index 2
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_BUYER_COUNTRY]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setCountryCode($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_BUYER_COUNTRY], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field D, Index 3
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_DOC_TYPE]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setDocType($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_DOC_TYPE], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field E, Index 4
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $tokens[Tokens::T_DOC_STATUS]);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_DOC_STATUS]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setDocStatus($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_DOC_STATUS], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field F, Index 5
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $tokens[Tokens::T_DOC_DATE]);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_DOC_DATE]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setDocDate($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_DOC_DATE], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field G, Index 6
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_DOC_NO]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setDocNo($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_DOC_NO], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field H, Index 7
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_ATCUD]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                $this->setAtcud($value);
            }
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_ATCUD], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        // Field I, Index 8
        /** @phpstan-ignore-next-line */
        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_FISCAL_REGION_PT]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            if ($setValue) {
                if ($value === "0") {
                    $this->setDocWithoutVat();
                }
            }

            if ($value !== "0") {
                $this->setIterateRegionPT(
                    $spl, $tokens, $error, $errorStop, $msgParsed, $setValue,
                    $field, $value
                );
            } else {

                /** @phpstan-ignore-next-line */
                if (\next($spl) === false) {
                    $msg = \sprintf($errorStop, $field);
                    \Logger::getLogger(\get_class($this))->error($msg);
                    throw new QRCodeException($msg);
                }
                $this->splitFieldValue(\current($spl), $field, $value);
            }
        }

        if ($field === $tokens[Tokens::T_FISCAL_REGION_PTAC]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            $this->setIterateRegionPTAC(
                $spl, $tokens, $error, $errorStop, $msgParsed, $setValue,
                $field, $value
            );
        }

        if ($field === $tokens[Tokens::T_FISCAL_REGION_PTMA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );
            $this->setIterateRegionPTMA(
                $spl, $tokens, $error, $errorStop, $msgParsed, $setValue,
                $field, $value
            );
        }

        if ($field === $tokens[Tokens::T_TOTAL_NON_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setTotalNonVat((float) $value);
            }

            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        }

        if ($field === $tokens[Tokens::T_TOTAL_STAMP_TAX]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setTotalStampTax((float) $value);
            }

            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        }

        if ($field === $tokens[Tokens::T_TAX_PAYABLE]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setTaxPayable((float) $value);
            }

            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_TAX_PAYABLE], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_GROSS_TOTAL]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setGrossTotal((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_GROSS_TOTAL], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_WITHHOLDING_TAX_AMOUNT]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setWithholdingTaxAmount((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        }

        if ($field === $tokens[Tokens::T_HASH]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setHash($value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_HASH], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_CERTIFICATE]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setCertificateNo((int) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                return;
            }
            $this->splitFieldValue(\current($spl), $field, $value);
        } else {
            $msg = \sprintf($error, $tokens[Tokens::T_HASH], $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_OTHER_INFO]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setOtherInfo($value);
            }

            if (\next($spl) !== false) {
                $msg = \sprintf(
                    "Last field should be '%s' or '%s'",
                    $tokens[Tokens::T_CERTIFICATE],
                    $tokens[Tokens::T_OTHER_INFO]
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
        }
    }

    /**
     * Iterate over the Country Region fiscal zone PT -> fields I2-I8
     *
     * @param string[] $spl the array to iterat over the field I2-I8
     * @param string[] $tokens the tokens
     * @param string $error Error message template
     * @param string $errorStop Stop error message template
     * @param string $msgParsed Parsed message template
     * @param boolean $setValue Set the properties values (parse)
     * @param string $field Variable that handle the last field name
     * @param string $value Variable that handle the last field value
     * @throws QRCodeException
     * @return void
     */
    protected function setIterateRegionPT(
        array &$spl,
        array &$tokens,
        string $error,
        string $errorStop,
        string $msgParsed,
        bool $setValue,
        string &$field,
        string &$value
    ) : void
    {
        $noField = true;

        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_PT_EXEMPTED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTExemptedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        }

        if ($field === $tokens[Tokens::T_PT_REDUCED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTReducedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PT_REDUCED_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PT_REDUCED_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTReducedTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PT_REDUCED_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PT_REDUCED_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_PT_INTERMEDIATE_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTIntermediateBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PT_INTERMEDIATE_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PT_INTERMEDIATE_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }


            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTIntermediateTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PT_INTERMEDIATE_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PT_INTERMEDIATE_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_PT_NORMAL_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTNormalBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PT_NORMAL_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PT_NORMAL_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }


            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTNormalTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PT_NORMAL_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PT_NORMAL_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($noField) {
            $msg = "No tax field setted in PT fiscal zone";
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }
    }

    /**
     * Iterate over the Country Region fiscal zone PT-AC -> fields J2-J8
     *
     * @param string[] $spl the array to iterat over the field J2-J8
     * @param string[] $tokens the tokens
     * @param string $error Error message template
     * @param string $errorStop Stop error message template
     * @param string $msgParsed Parsed message template
     * @param boolean $setValue Set the properties values (parse)
     * @param string $field Variable that handle the last field name
     * @param string $value Variable that handle the last field value
     * @throws QRCodeException
     * @return void
     */
    protected function setIterateRegionPTAC(array &$spl, array &$tokens,
                                            string $error, string $errorStop,
                                            string $msgParsed, bool $setValue,
                                            string &$field, string &$value) : void
    {
        $noField = true;

        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_PTAC_EXEMPTED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACExemptedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        }

        if ($field === $tokens[Tokens::T_PTAC_REDUCED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACReducedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTAC_REDUCED_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTAC_REDUCED_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }


            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACReducedTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTAC_REDUCED_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTAC_REDUCED_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }


        if ($field === $tokens[Tokens::T_PTAC_INTERMEDIATE_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACIntermediateBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA],
                    $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACIntermediateTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTAC_INTERMEDIATE_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_PTAC_NORMAL_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACNormalBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTAC_NORMAL_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTAC_NORMAL_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTACNormalTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTAC_NORMAL_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTAC_NORMAL_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($noField) {
            $msg = "No tax field setted in PT-AC fiscal zone";
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }
    }

    /**
     * Iterate over the Country Region fiscal zone PT-MA -> fields K2-K8
     *
     * @param string[] $spl the array to iterat over the field J2-J8
     * @param string[] $tokens the tokens
     * @param string $error Error message template
     * @param string $errorStop Stop error message template
     * @param string $msgParsed Parsed message template
     * @param boolean $setValue Set the properties values (parse)
     * @param string $field Variable that handle the last field name
     * @param string $value Variable that handle the last field value
     * @throws QRCodeException
     * @return void
     */
    protected function setIterateRegionPTMA(array &$spl, array &$tokens, string$error,
                                            string $errorStop, string $msgParsed,
                                            bool $setValue, string &$field, string &$value): void
    {
        $noField = true;

        if (\next($spl) === false) {
            $msg = \sprintf($errorStop, $field);
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        $this->splitFieldValue(\current($spl), $field, $value);

        if ($field === $tokens[Tokens::T_PTMA_EXEMPTED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMAExemptedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        }

        if ($field === $tokens[Tokens::T_PTMA_REDUCED_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMAReducedBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTMA_REDUCED_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTMA_REDUCED_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMAReducedTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTMA_REDUCED_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTMA_REDUCED_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }


        if ($field === $tokens[Tokens::T_PTMA_INTERMEDIATE_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMAIntermediateBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA],
                    $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMAIntermediateTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTMA_INTERMEDIATE_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($field === $tokens[Tokens::T_PTMA_NORMAL_BASE_IVA]) {
            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMANormalBaseVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);

            if ($field !== $tokens[Tokens::T_PTMA_NORMAL_TOTAL_IVA]) {
                $msg = \sprintf(
                    $error, $tokens[Tokens::T_PTMA_NORMAL_TOTAL_IVA], $field
                );
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }

            \Logger::getLogger(\get_class($this))->info(
                \sprintf($msgParsed, $field, $value)
            );

            if ($setValue) {
                $this->setPTMANormalTotalVat((float) $value);
            }

            /** @phpstan-ignore-next-line */
            if (\next($spl) === false) {
                $msg = \sprintf($errorStop, $field);
                \Logger::getLogger(\get_class($this))->error($msg);
                throw new QRCodeException($msg);
            }
            $this->splitFieldValue(\current($spl), $field, $value);
            $noField = false;
        } elseif ($field === $tokens[Tokens::T_PTMA_NORMAL_TOTAL_IVA]) {
            $msg = \sprintf(
                $error, $tokens[Tokens::T_PTMA_NORMAL_BASE_IVA], $field
            );
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }

        if ($noField) {
            $msg = "No tax field setted in PT-AC fiscal zone";
            \Logger::getLogger(\get_class($this))->error($msg);
            throw new QRCodeException($msg);
        }
    }

    /**
     * Split the field name and value
     * @param string $string
     * @param string $field The returned field name (passed as refernce)
     * @param string $value The returned field value (passed as refernce)
     * @throws QRCodeException
     * @return void
     */
    protected function splitFieldValue(string $string, string &$field, string &$value) : void
    {
        $pos = \strpos($string, Tokens::T_FIELD_SEP);
        if ($pos === false) {
            throw new QRCodeException("Split field value error");
        }
        $field = \substr($string, 0, $pos);
        $value = \substr($string, $pos + 1);

        if ($value === "" || $field === "") {
            // Payments has no  hash but field is mandatory
            if($field === "Q" && !empty($value) && \in_array($this->getDocType(), array("RG", "RC"))){
                $value = "";
                return;
            }
            throw new QRCodeException("Split field value error");
        }
    }

    /**
     * Parse a QRCode string
     *
     * @param string $string
     *
     * @return \Rebelo\At\QRCode\Builder
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public static function parseString(string $string) : Builder
    {
        \Logger::getLogger(__CLASS__)->debug(__METHOD__);
        $builder = new Builder();
        $builder->iterateCode($string, true);
        return $builder;
    }

    /**
     * Build the QRcode image as png
     *
     * @param string $path
     *
     * @return void
     * @throws \Rebelo\At\QRCode\QRCodeException
     */
    public function buildImage(string $path) : void
    {
        \QRcode::png(
            $this->getQrCodeString(false), $path, self::$level, self::$size,
            self::$margin
        );
    }
}
