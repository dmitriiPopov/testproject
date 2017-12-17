<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnPage(\Yii::$app->homeUrl);
        $I->see('Frontend');
        $I->seeLink('Home');
        $I->seeLink('About');
        $I->seeLink('Contact');
        $I->seeLink('Login');
        $I->see('News');
        $I->see('Categories');

        $I->click('About');
        $I->see('This is the About page.');
    }
}