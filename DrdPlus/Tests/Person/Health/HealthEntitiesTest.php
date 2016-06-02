<?php
namespace DrdPlus\Tests\Person\Health;

use Doctrineum\Tests\Entity\AbstractDoctrineEntitiesTest;
use DrdPlus\Codes\RaceCodes;
use DrdPlus\Person\Health\EnumTypes\PersonHealthEnumsRegistrar;
use DrdPlus\Person\Health\Health;
use DrdPlus\Person\Health\OrdinaryWound;
use DrdPlus\Person\Health\PointOfWound;
use DrdPlus\Person\Health\SeriousWound;
use DrdPlus\Person\Health\SpecificWoundOrigin;
use DrdPlus\Person\Health\WoundSize;
use DrdPlus\Properties\Base\Strength;
use DrdPlus\Properties\Derived\Toughness;
use DrdPlus\Properties\Derived\WoundBoundary;
use DrdPlus\Tables\Measurements\Wounds\WoundsTable;
use DrdPlus\Tables\Races\RacesTable;

class HealthEntitiesTest extends AbstractDoctrineEntitiesTest
{
    protected function setUp()
    {
        parent::setUp();
        PersonHealthEnumsRegistrar::registerAll();
    }

    protected function getDirsWithEntities()
    {
        return [
            str_replace(DIRECTORY_SEPARATOR . 'Tests', '', __DIR__)
        ];
    }

    protected function createEntitiesToPersist()
    {
        $ordinaryWound = new OrdinaryWound(
            $health = new Health(
                new WoundBoundary(
                    new Toughness(new Strength(3), RaceCodes::ORC, RaceCodes::GOBLIN, new RacesTable()),
                    new WoundsTable()
                )
            ),
            new WoundSize(1)
        );
        $seriousWound = new SeriousWound(
            $health,
            new WoundSize(5),
            SpecificWoundOrigin::getMechanicalCrushWoundOrigin()
        );

        return [
            $health,
            $ordinaryWound,
            $seriousWound,
            new PointOfWound($ordinaryWound)
        ];
    }

}