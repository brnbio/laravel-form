<?php

/**
 * LabelTest.php
 *
 * @copyright   OEMUS MEDIA AG (https://oemus.com)
 * @author      Frank Heider <f.heider@oemus-media.de>
 * @since       08.10.2018
 */

declare(strict_types=1);

use Brnbio\LaravelForm\Form\Helper;
use Brnbio\LaravelForm\Form\Element\Label;
use Tests\TestCase;

/**
 * Class LabelTest
 *
 * @package Brnbio
 */
class LabelTest extends TestCase
{
    /**
     * Simple class without any attributes
     *
     * @return void
     */
    public function testSimpleElement()
    {
        $element = new Label('Test');
        $this->assertEquals('<label>Test</label>', (string)$element->render());
    }

    /**
     * "for" is an valid attribute > should be parsed
     *
     * @return void
     */
    public function testElementWithValidAttributes()
    {
        $element = new Label('Test', ['for' => 'test']);
        $this->assertEquals('<label for="test">Test</label>', (string)$element->render());
    }

    /**
     * "name" is an invalid attribute for a label element > should be deleted
     *
     * @return void
     */
    public function testElementWithInvalidAttributes()
    {
        $element = new Label('Test', ['name' => 'test']);
        $this->assertEquals('<label>Test</label>', (string)$element->render());
    }

    /**
     * Test helper method with a simple call without attributes
     *
     * @return void
     */
    public function testHelper()
    {
        $this->assertEquals('<label>Test</label>', (string)Helper::getInstance()->label('Test'));
    }
}
