<?php

/**
 * LabelTest.php
 *
 * @copyright   OEMUS MEDIA AG (https://oemus.com)
 * @author      Frank Heider <f.heider@oemus-media.de>
 * @since       08.10.2018
 */

declare(strict_types=1);


use Tests\TestCase;

/**
 * Class LabelTest
 *
 * @package Brnbio
 */
class LabelTest extends TestCase
{
    public function testElementValid()
    {
        $element = new \Brnbio\LaravelForm\Form\Element\Label('Test');
        $this->assertEquals('<label>Test</label>', $element->render());
    }
}
