<?php
/**
 * MIT License
 * @license https://github.com/joaomfrebelo/at_qrcode/blob/master/LICENSE
 * Copyright (c) 2020 João Rebelo
 */
declare(strict_types=1);

namespace Rebelo\At\QRCode;

use PHPUnit\Framework\TestCase;

class BuilderTest extends TestCase
{
    const MAIN_CLASS = '\Rebelo\At\QRCode\Builder';

    //phpcs:disable Generic.Files.LineLength.MaxExceeded

    /**
     * QRCode string example 1 from AT's technical information
     */
    const AT_EXAMPLE_1 = "A:123456789*B:999999990*C:PT*D:FT*E:N*F:20191231*G:FT AB2019/0035*H:CSDF7T5H-0035*I1:PT*I2:12000.00*I3:15000.00*I4:900.00*I5:50000.00*I6:6500.00*I7:80000.00*I8:18400.00*J1:PT-AC*J2:10000.00*J3:25000.56*J4:1000.02*J5:75000.00*J6:6750.00*J7:100000.00*J8:18000.00*K1:PT-MA*K2:5000.00*K3:12500.00*K4:625.00*K5:25000.00*K6:3000.00*K7:40000.00*K8:8800.00*L:100.00*M:25.00*N:64000.02*O:513600.58*P:100.00*Q:kLp0*R:9999*S:TB;PT00000000000000000000000;513500.58";

    /**
     * QRCode string example 2 from AT's technical information
     */
    const AT_EXAMPLE_2 = "A:123456789*B:999999990*C:PT*D:FS*E:N*F:20190812*G:FS CDVF/12345*H:CDF7T5HD-12345*I1:PT*I7:0.65*I8:0.15*N:0.15*O:0.80*Q:YhGV*R:9999*S:NU;0.80";

    /**
     * QRCode string example 3 from AT's technical information
     */
    const AT_EXAMPLE_3 = "A:500000000*B:123456789*C:PT*D:PF*E:N*F:20190123*G:PF G2019CB/145789*H:HB6FT7RV-145789*I1:PT*I2:12345.34*I3:12532.65*I4:751.96*I5:52789.00*I6:6862.57*I7:32425.69*I8:7457.91*N:15072.44*O:125165.12*Q:r/fY*R:9999";

    /**
     * QRCode string example 4 from AT's technical information
     */
    const AT_EXAMPLE_4 = "A:500000000*B:123456789*C:PT*D:GT*E:N*F:20190720*G:GT G234CB/50987*H:GTVX4Y8B-50987*I1:0*N:0.00*O:0.00*Q:5uIg*R:9999";

    /**
     * QRCode string example 4 from AT's technical information
     */
    const EXAMPLE_WRONG_END_1 = "A:500000000*B:123456789*C:PT*D:GT*E:N*F:20190720*G:GT G234CB/50987*H:GTVX4Y8B-50987*I1:0*N:0.00*O:0.00*Q:5uIg";

    /**
     * QRCode string example 4 from AT's technical information
     */
    const EXAMPLE_WRONG_END_2 = "A:500000000*B:123456789*C:PT*D:GT*E:N*F:20190720*G:GT G234CB/50987*H:GTVX4Y8B-50987*I1:0*N:0.00*O:0.00*Q:5uIg*R:9999*S:AAA*T:CCC";

    /**
     * QRCode string example 4 from AT's technical information
     */
    const EXAMPLE_WRONG = "A:500000000*C:PT*D:GT*E:N*F:20190720*G:GT G234CB/50987*H:GTVX4Y8B-50987*I1:0*N:0.00*O:0.00*Q:5uIg*R:9999*S:AAA*T:CCC";


    /**
     * QRCode string with ATCUD zero
     */
    const EXAMPLE_ATCUD_ZERO = "A:500000000*B:123456789*C:PT*D:GT*E:N*F:20190720*G:GT G234CB/50987*H:0*I1:0*N:0.00*O:0.00*Q:5uIg*R:9999";

    /**
     * QRCode string of a payment (RG), no hash but field q is 0, not tax
     */
    const PAYMENT_EXAMPLE_WITHOUT_TAX = "A:500000000*B:123456789*C:PT*D:RG*E:N*F:20190720*G:RG RG/1*H:GTVX4Y8B-50987*I1:0*L:99.00*N:99.00*O:99.00*Q:0*R:9999";

    /**
     * QRCode string of a payment (RC), no hash but field q is 0, with tax
     */
    const PAYMENT_EXAMPLE_WITH_TAX = "A:500000000*B:123456789*C:PT*D:RC*E:N*F:20190123*G:RC RC/145789*H:HB6FT7RV-145789*I1:PT*I2:12345.34*I3:12532.65*I4:751.96*I5:52789.00*I6:6862.57*I7:32425.69*I8:7457.91*N:15072.44*O:125165.12*Q:0*R:9999";

    // phpcs:enable

    /**
     * @author João Rebelo
     * @return void
     * @test
     */
    public function testInstance(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertEmpty($builder->getProperties());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testIssuerTin(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getIssuerTin());

        try {
            $builder->setIssuerTin("12924729");
            $this->fail(
                "Set issuer tin with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setIssuerTin("1292472994");
            $this->fail(
                "Set issuer tin with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $tin = "295158530";
        $builder->setIssuerTin($tin);
        $this->assertSame($tin, $builder->getIssuerTin());

        $properties = $builder->getProperties();
        $token      = Tokens::T_ISSUER_TIN;

        $this->assertSame(
            $tin, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testBuyerTin(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getBuyerTin());

        try {
            $builder->setBuyerTin(
                \str_pad("1292472994", 31, "5", STR_PAD_BOTH)
            );
            $this->fail(
                "Set buyer tin with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setBuyerTin("");
            $this->fail(
                "Set buyer tin with empty string should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $tin = "295158530";
        $builder->setBuyerTin($tin);
        $this->assertSame($tin, $builder->getBuyerTin());

        $properties = $builder->getProperties();
        $token      = Tokens::T_BUYER_TIN;

        $this->assertSame(
            $tin, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testCountryCode(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getCountryCode());

        try {
            $builder->setCountryCode(\str_pad("AA", 13, "A", STR_PAD_BOTH));
            $this->fail(
                "Set country code with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setCountryCode("");
            $this->fail(
                "Set country code with empty string should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $countryCode = "PT";
        $builder->setCountryCode($countryCode);
        $this->assertSame($countryCode, $builder->getCountryCode());

        $properties = $builder->getProperties();
        $token      = Tokens::T_BUYER_COUNTRY;

        $this->assertSame(
            $countryCode, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocType(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getDocType());

        try {
            $builder->setDocType("AAA");
            $this->fail(
                "Set doc type with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setDocType("A");
            $this->fail(
                "Set doc type with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $docType = "FT";
        $builder->setDocType($docType);
        $this->assertSame($docType, $builder->getDocType());

        $properties = $builder->getProperties();
        $token      = Tokens::T_DOC_TYPE;

        $this->assertSame(
            $docType, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocStatus(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getDocStatus());

        try {
            $builder->setDocStatus("AA");
            $this->fail(
                "Set doc status tin with wrong format should"
                ." throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setDocStatus("");
            $this->fail(
                "Set doc status with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $status = "N";
        $builder->setDocStatus($status);
        $this->assertSame($status, $builder->getDocStatus());

        $properties = $builder->getProperties();
        $token      = Tokens::T_DOC_STATUS;

        $this->assertSame(
            $status, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocDate(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getDocDate());

        try {
            $builder->setDocDate("19991005");
            $this->fail(
                "Set doc date with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setDocDate("");
            $this->fail(
                "Set doc date with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $date = "20201005";
        $builder->setDocDate($date);
        $this->assertSame($date, $builder->getDocDate());

        $properties = $builder->getProperties();
        $token      = Tokens::T_DOC_DATE;

        $this->assertSame(
            $date, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocNo(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getDocNo());

        try {
            $builder->setDocNo(\str_pad("FT FT/9", 61, "9"));
            $this->fail(
                "Set DocNo with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setDocNo("");
            $this->fail(
                "Set DocNo with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $no = "FT FT/9";
        $builder->setDocNo($no);
        $this->assertSame($no, $builder->getDocNo());

        $properties = $builder->getProperties();
        $token      = Tokens::T_DOC_NO;

        $this->assertSame(
            $no, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testAtcud(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getAtcud());

        try {
            $builder->setAtcud(\str_pad("AAAA-999", 71, "A", STR_PAD_LEFT));
            $this->fail(
                "Set Atcud with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setAtcud("AA99");
            $this->fail(
                "Set Atcud with wrong format should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $atcude = "ABVFC9DGF-999";
        $builder->setAtcud($atcude);
        $this->assertSame($atcude, $builder->getAtcud());

        $properties = $builder->getProperties();
        $token      = Tokens::T_ATCUD;

        $this->assertSame(
            $atcude, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @author João Rebelo
     * @return void
     * @test
     */
    public function testDocWithoutVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->isDocWithoutVat());

        $builder->setDocWithoutVat();
        $this->assertTrue($builder->isDocWithoutVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            "0", $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocWithoutVatSettingPT(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->isDocWithoutVat());

        $builder->setPTExemptedBaseVat(999.09);
        $this->assertFalse($builder->isDocWithoutVat());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocWithoutVatSettingPTAC(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->isDocWithoutVat());

        $builder->setPTACExemptedBaseVat(999.09);
        $this->assertFalse($builder->isDocWithoutVat());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testDocWithoutVatSettingPTAM(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->isDocWithoutVat());

        $builder->setPTMAExemptedBaseVat(999.09);
        $this->assertFalse($builder->isDocWithoutVat());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTExemptedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTExemptedBaseVat());

        try {
            $builder->setPTExemptedBaseVat(-0.01);
            $this->fail(
                "Set PTExemptedBaseVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTExemptedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTExemptedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_EXEMPTED_BASE_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMAExemptedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMAExemptedBaseVat());

        try {
            $builder->setPTMAExemptedBaseVat(-0.01);
            $this->fail(
                "Set PTMAExemptedBaseVat with a negative "
                ."float should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMAExemptedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTMAExemptedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_EXEMPTED_BASE_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACExemptedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACExemptedBaseVat());

        try {
            $builder->setPTACExemptedBaseVat(-0.01);
            $this->fail(
                "Set PTACExemptedBaseVat with a negative float should"
                ." throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACExemptedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTACExemptedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_EXEMPTED_BASE_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTReducedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTReducedBaseVat());

        try {
            $builder->setPTReducedBaseVat(-0.01);
            $this->fail(
                "Set PTReducedBaseVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTReducedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTReducedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_REDUCED_BASE_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMAReducedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMAReducedBaseVat());

        try {
            $builder->setPTMAReducedBaseVat(-0.01);
            $this->fail(
                "Set PTMAReducedBaseVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMAReducedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTMAReducedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_REDUCED_BASE_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACReducedBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACReducedBaseVat());

        try {
            $builder->setPTACReducedBaseVat(-0.01);
            $this->fail(
                "Set PTACReducedBaseVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACReducedBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTACReducedBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_REDUCED_BASE_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTReducedTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTReducedTotalVat());

        try {
            $builder->setPTReducedTotalVat(-0.01);
            $this->fail(
                "Set PTReducedTotalVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTReducedTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTReducedTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_REDUCED_TOTAL_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMAReducedTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMAReducedTotalVat());

        try {
            $builder->setPTMAReducedTotalVat(-0.01);
            $this->fail(
                "Set PTMAReducedTotalVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMAReducedTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTMAReducedTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_REDUCED_TOTAL_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACReducedTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACReducedTotalVat());

        try {
            $builder->setPTACReducedTotalVat(-0.01);
            $this->fail(
                "Set PTACReducedTotalVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACReducedTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTACReducedTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_REDUCED_TOTAL_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTIntermediateBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTIntermediateBaseVat());

        try {
            $builder->setPTIntermediateBaseVat(-0.01);
            $this->fail(
                "Set PTIntermediateBaseVat with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTIntermediateBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTIntermediateBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_INTERMEDIATE_BASE_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMAIntermediateBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMAIntermediateBaseVat());

        try {
            $builder->setPTMAIntermediateBaseVat(-0.01);
            $this->fail(
                "Set PTMAIntermediateBaseVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMAIntermediateBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTMAIntermediateBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_INTERMEDIATE_BASE_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACIntermediateBaseVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACIntermediateBaseVat());

        try {
            $builder->setPTACIntermediateBaseVat(-0.01);
            $this->fail(
                "Set PTACIntermediateBaseVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACIntermediateBaseVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTACIntermediateBaseVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_INTERMEDIATE_BASE_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTIntermediateTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTIntermediateTotalVat());

        try {
            $builder->setPTIntermediateTotalVat(-0.01);
            $this->fail(
                "Set PTIntermediateTotalVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTIntermediateTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTIntermediateTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_INTERMEDIATE_TOTAL_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMAIntermediateTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMAIntermediateTotalVat());

        try {
            $builder->setPTMAIntermediateTotalVat(-0.01);
            $this->fail(
                "Set PTMAIntermediateTotalVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMAIntermediateTotalVat((float) $value);
        $this->assertSame(
            (float) $value, $builder->getPTMAIntermediateTotalVat()
        );

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_INTERMEDIATE_TOTAL_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACIntermediateTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACIntermediateTotalVat());

        try {
            $builder->setPTACIntermediateTotalVat(-0.01);
            $this->fail(
                "Set PTACIntermediateTotalVat with a negative float "
                ."should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACIntermediateTotalVat((float) $value);
        $this->assertSame(
            (float) $value, $builder->getPTACIntermediateTotalVat()
        );

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_INTERMEDIATE_TOTAL_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTNormalTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTNormalTotalVat());

        try {
            $builder->setPTNormalTotalVat(-0.01);
            $this->fail(
                "Set PTNormalTotalVat with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTNormalTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTNormalTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PT_NORMAL_TOTAL_IVA;
        $tokenPT    = Tokens::T_FISCAL_REGION_PT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT", $properties[$tokenPT], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTMANormalTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTMANormalTotalVat());

        try {
            $builder->setPTMANormalTotalVat(-0.01);
            $this->fail(
                "Set PTMANormalTotalVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTMANormalTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTMANormalTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTMA_NORMAL_TOTAL_IVA;
        $tokenPTMA  = Tokens::T_FISCAL_REGION_PTMA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-MA", $properties[$tokenPTMA], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testPTACNormalTotalVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getPTACNormalTotalVat());

        try {
            $builder->setPTACNormalTotalVat(-0.01);
            $this->fail(
                "Set PTACNormalTotalVat with a negative float should "
                ."throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setPTACNormalTotalVat((float) $value);
        $this->assertSame((float) $value, $builder->getPTACNormalTotalVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_PTAC_NORMAL_TOTAL_IVA;
        $tokenPTAC  = Tokens::T_FISCAL_REGION_PTAC;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );

        $this->assertSame(
            "PT-AC", $properties[$tokenPTAC], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testTotalNonVat(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getTotalNonVat());

        try {
            $builder->setTotalNonVat(-0.01);
            $this->fail(
                "Set TotalNonVat with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setTotalNonVat((float) $value);
        $this->assertSame((float) $value, $builder->getTotalNonVat());

        $properties = $builder->getProperties();
        $token      = Tokens::T_TOTAL_NON_IVA;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testTotalStampTax(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getTotalStampTax());

        try {
            $builder->setTotalStampTax(-0.01);
            $this->fail(
                "Set TotalStampTax with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setTotalStampTax((float) $value);
        $this->assertSame((float) $value, $builder->getTotalStampTax());

        $properties = $builder->getProperties();
        $token      = Tokens::T_TOTAL_STAMP_TAX;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testTaxPayable(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getTaxPayable());

        try {
            $builder->setTaxPayable(-0.01);
            $this->fail(
                "Set TaxPayable with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setTaxPayable((float) $value);
        $this->assertSame((float) $value, $builder->getTaxPayable());

        $properties = $builder->getProperties();
        $token      = Tokens::T_TAX_PAYABLE;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testGrossTotal(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getGrossTotal());

        try {
            $builder->setGrossTotal(-0.01);
            $this->fail(
                "Set GrossTotal with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setGrossTotal((float) $value);
        $this->assertSame((float) $value, $builder->getGrossTotal());

        $properties = $builder->getProperties();
        $token      = Tokens::T_GROSS_TOTAL;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testWithholdingTaxAmount(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getWithholdingTaxAmount());

        try {
            $builder->setWithholdingTaxAmount(-0.01);
            $this->fail(
                "Set WithholdingTaxAmount with a negative float should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $value = "999.00";
        $builder->setWithholdingTaxAmount((float) $value);
        $this->assertSame((float) $value, $builder->getWithholdingTaxAmount());

        $properties = $builder->getProperties();
        $token      = Tokens::T_WITHHOLDING_TAX_AMOUNT;

        $this->assertSame(
            $value, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testHash(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getHash());

        try {
            $builder->setHash("AAA");
            $this->fail(
                "Set hash with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setHash("AAAAA");
            $this->fail(
                "Set hash with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setHash("");
            $this->fail(
                "Set hash empty should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $hash = "ABCD";
        $builder->setHash($hash);
        $this->assertSame($hash, $builder->getHash());

        $properties = $builder->getProperties();
        $token      = Tokens::T_HASH;

        $this->assertSame(
            $hash, $properties[$token], "The settled token is incorrect"
        );

        $builder->setHash("0");
        $this->assertSame("0", $builder->getHash());

        $propEmpty = $builder->getProperties();
        $this->assertSame(
            "0", $propEmpty[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testCertificateNo(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getCertificateNo());

        try {
            $builder->setCertificateNo(0);
            $this->fail(
                "Set CertificateNo to a lower than 1 should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setCertificateNo(10000);
            $this->fail(
                "Set CertificateNo higher tan 9999 should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        $no = 9999;
        $builder->setCertificateNo($no);
        $this->assertSame($no, $builder->getCertificateNo());

        $properties = $builder->getProperties();
        $token      = Tokens::T_CERTIFICATE;

        $this->assertSame(
            (string) $no, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testOtherInfo(): void
    {
        $builder = new Builder();
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);

        $this->assertNull($builder->getOtherInfo());

        try {
            $builder->setOtherInfo(\str_pad("AAA", 70, "A"));
            $this->fail(
                "Set hash with wrong format should throw \Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            $builder->setOtherInfo("");
            $this->fail(
                "Set country code with wrong format should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }


        $info = "ABCD";
        $builder->setOtherInfo($info);
        $this->assertSame($info, $builder->getOtherInfo());

        $properties = $builder->getProperties();
        $token      = Tokens::T_OTHER_INFO;

        $this->assertSame(
            $info, $properties[$token], "The settled token is incorrect"
        );
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testIterateCode(): void
    {
        $builder = new BuilderPublic();
        $builder->iterateCode(self::AT_EXAMPLE_1, false);
        $this->assertTrue(true);
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringAtExample1(): void
    {
        $builder = Builder::parseString(self::AT_EXAMPLE_1);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::AT_EXAMPLE_1, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringAtExample2(): void
    {
        $builder = Builder::parseString(self::AT_EXAMPLE_2);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::AT_EXAMPLE_2, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringAtExample3(): void
    {
        $builder = Builder::parseString(self::AT_EXAMPLE_3);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::AT_EXAMPLE_3, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringAtExample4(): void
    {
        $builder = Builder::parseString(self::AT_EXAMPLE_4);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::AT_EXAMPLE_4, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testGenerateImage(): void
    {
        $builder = Builder::parseString(self::AT_EXAMPLE_1);
        $path    = sys_get_temp_dir().DIRECTORY_SEPARATOR.uniqid("QRCode").".png";
        $builder->buildImage($path);
        $this->assertTrue(\is_file($path));
        unlink($path);
    }

    /**
     * @author João Rebelo
     * @return void
     * @test
     */
    public function testWrongString(): void
    {
        try {
            Builder::parseString(self::EXAMPLE_WRONG_END_1);
            $this->fail(
                "Wrong end should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            Builder::parseString(self::EXAMPLE_WRONG_END_2);
            $this->fail(
                "Wrong end should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }

        try {
            Builder::parseString(self::EXAMPLE_WRONG);
            $this->fail(
                "Wrong end should throw "
                ."\Rebelo\At\QRCode\QRCodeException"
            );
        } catch (\Exception $ex) {
            $this->assertInstanceOf(
                '\Rebelo\At\QRCode\QRCodeException', $ex
            );
        }
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringAtExampleAtcudZero(): void
    {
        $builder = Builder::parseString(self::EXAMPLE_ATCUD_ZERO);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::EXAMPLE_ATCUD_ZERO, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringPaymentExampleWithoutTax(): void
    {
        $builder = Builder::parseString(self::PAYMENT_EXAMPLE_WITHOUT_TAX);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::PAYMENT_EXAMPLE_WITHOUT_TAX, $builder->getQrCodeString());
    }

    /**
     * @return void
     * @test
     * @throws \Rebelo\At\QRCode\QRCodeException
     * @author João Rebelo
     */
    public function testParseStringPaymentExampleWithTax(): void
    {
        $builder = Builder::parseString(self::PAYMENT_EXAMPLE_WITH_TAX);
        $this->assertInstanceOf(self::MAIN_CLASS, $builder);
        $this->assertSame(self::PAYMENT_EXAMPLE_WITH_TAX, $builder->getQrCodeString());
    }
}
