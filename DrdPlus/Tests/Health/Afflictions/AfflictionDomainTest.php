<?php
namespace DrdPlus\Tests\Health\Afflictions;

use DrdPlus\Codes\AfflictionByWoundDomainCode;
use DrdPlus\Health\Afflictions\AfflictionDomain;
use Granam\String\StringTools;

class AfflictionDomainTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider provideDomain
     * @param string $domainCode
     */
    public function I_can_use_it($domainCode)
    {
        $afflictionDomain = AfflictionDomain::getIt($domainCode);
        self::assertInstanceOf(AfflictionDomain::class, $afflictionDomain);
        $getAfflictionDomain = StringTools::assembleGetterForName($domainCode) . 'Affliction';
        self::assertSame($afflictionDomain, AfflictionDomain::$getAfflictionDomain());
        self::assertSame($domainCode, $afflictionDomain->getValue());
    }

    public function provideDomain()
    {
        return [
            [AfflictionByWoundDomainCode::PHYSICAL],
            [AfflictionByWoundDomainCode::PSYCHICAL],
        ];
    }

    /**
     * @test
     * @expectedException \DrdPlus\Health\Afflictions\Exceptions\UnknownAfflictionDomain
     */
    public function I_can_not_create_custom_domain()
    {
        AfflictionDomain::getIt('ethereal');
    }
}