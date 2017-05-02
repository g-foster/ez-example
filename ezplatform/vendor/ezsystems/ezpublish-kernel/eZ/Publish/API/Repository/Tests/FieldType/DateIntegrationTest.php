<?php

/**
 * File contains: eZ\Publish\API\Repository\Tests\FieldType\DateAndTimeIntegrationTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
namespace eZ\Publish\API\Repository\Tests\FieldType;

use eZ\Publish\Core\FieldType\Date\Value as DateValue;
use eZ\Publish\API\Repository\Values\Content\Field;
use eZ\Publish\Core\FieldType\Date\Type;
use DateTime;

/**
 * Integration test for use field type.
 *
 * @group integration
 * @group field-type
 */
class DateIntegrationTest extends SearchBaseIntegrationTest
{
    /**
     * Get name of tested field type.
     *
     * @return string
     */
    public function getTypeName()
    {
        return 'ezdate';
    }

    /**
     * Get expected settings schema.
     *
     * @return array
     */
    public function getSettingsSchema()
    {
        return array(
            'defaultType' => array(
                'type' => 'choice',
                'default' => Type::DEFAULT_EMPTY,
            ),
        );
    }

    /**
     * Get a valid $fieldSettings value.
     *
     * @return mixed
     */
    public function getValidFieldSettings()
    {
        return array(
            'defaultType' => Type::DEFAULT_EMPTY,
        );
    }

    /**
     * Get $fieldSettings value not accepted by the field type.
     *
     * @return mixed
     */
    public function getInvalidFieldSettings()
    {
        return array(
            'somethingUnknown' => 0,
        );
    }

    /**
     * Get expected validator schema.
     *
     * @return array
     */
    public function getValidatorSchema()
    {
        return array();
    }

    /**
     * Get a valid $validatorConfiguration.
     *
     * @return mixed
     */
    public function getValidValidatorConfiguration()
    {
        return array();
    }

    /**
     * Get $validatorConfiguration not accepted by the field type.
     *
     * @return mixed
     */
    public function getInvalidValidatorConfiguration()
    {
        return array(
            'unknown' => array('value' => 42),
        );
    }

    /**
     * Get initial field data for valid object creation.
     *
     * @return mixed
     */
    public function getValidCreationFieldData()
    {
        // We may only create times from timestamps here, since storing will
        // loose information about the timezone.
        return DateValue::fromTimestamp(86400);
    }

    /**
     * Get name generated by the given field type (either via Nameable or fieldType->getName()).
     *
     * @return string
     */
    public function getFieldName()
    {
        return 'Friday 02 January 1970';
    }

    /**
     * Asserts that the field data was loaded correctly.
     *
     * Asserts that the data provided by {@link getValidCreationFieldData()}
     * was stored and loaded correctly.
     *
     * @param Field $field
     */
    public function assertFieldDataLoadedCorrect(Field $field)
    {
        $this->assertInstanceOf(
            'eZ\\Publish\\Core\\FieldType\\Date\\Value',
            $field->value
        );

        $expectedData = array(
            'date' => new DateTime('@86400'),
        );

        $this->assertPropertiesCorrect(
            $expectedData,
            $field->value
        );
    }

    /**
     * Get field data which will result in errors during creation.
     *
     * This is a PHPUnit data provider.
     *
     * The returned records must contain of an error producing data value and
     * the expected exception class (from the API or SPI, not implementation
     * specific!) as the second element. For example:
     *
     * <code>
     * array(
     *      array(
     *          new DoomedValue( true ),
     *          'eZ\\Publish\\API\\Repository\\Exceptions\\ContentValidationException'
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array[]
     */
    public function provideInvalidCreationFieldData()
    {
        return array(
            array(
                'Some unknown date format',
                'eZ\\Publish\\API\\Repository\\Exceptions\\InvalidArgumentException',
            ),
        );
    }

    /**
     * Get valid field data for updating content.
     *
     * @return mixed
     */
    public function getValidUpdateFieldData()
    {
        return DateValue::fromTimestamp(86400);
    }

    /**
     * Asserts the field data was loaded correctly.
     *
     * Asserts that the data provided by {@link getValidUpdateFieldData()}
     * was stored and loaded correctly.
     *
     * @param Field $field
     */
    public function assertUpdatedFieldDataLoadedCorrect(Field $field)
    {
        $this->assertInstanceOf(
            'eZ\\Publish\\Core\\FieldType\\Date\\Value',
            $field->value
        );

        $expectedData = array(
            'date' => new DateTime('@86400'),
        );
        $this->assertPropertiesCorrect(
            $expectedData,
            $field->value
        );
    }

    /**
     * Get field data which will result in errors during update.
     *
     * This is a PHPUnit data provider.
     *
     * The returned records must contain of an error producing data value and
     * the expected exception class (from the API or SPI, not implementation
     * specific!) as the second element. For example:
     *
     * <code>
     * array(
     *      array(
     *          new DoomedValue( true ),
     *          'eZ\\Publish\\API\\Repository\\Exceptions\\ContentValidationException'
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array[]
     */
    public function provideInvalidUpdateFieldData()
    {
        return $this->provideInvalidCreationFieldData();
    }

    /**
     * Asserts the the field data was loaded correctly.
     *
     * Asserts that the data provided by {@link getValidCreationFieldData()}
     * was copied and loaded correctly.
     *
     * @param Field $field
     */
    public function assertCopiedFieldDataLoadedCorrectly(Field $field)
    {
        $this->assertFieldDataLoadedCorrect($field);
    }

    /**
     * Get data to test to hash method.
     *
     * This is a PHPUnit data provider
     *
     * The returned records must have the the original value assigned to the
     * first index and the expected hash result to the second. For example:
     *
     * <code>
     * array(
     *      array(
     *          new MyValue( true ),
     *          array( 'myValue' => true ),
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array
     */
    public function provideToHashData()
    {
        $timestamp = 186401;
        $dateTime = new DateTime("@{$timestamp}");

        return array(
            array(
                DateValue::fromTimestamp($timestamp),
                array(
                    'timestamp' => $dateTime->setTime(0, 0, 0)->getTimestamp(),
                    'rfc850' => $dateTime->format(DateTime::RFC850),
                ),
            ),
        );
    }

    /**
     * Get hashes and their respective converted values.
     *
     * This is a PHPUnit data provider
     *
     * The returned records must have the the input hash assigned to the
     * first index and the expected value result to the second. For example:
     *
     * <code>
     * array(
     *      array(
     *          array( 'myValue' => true ),
     *          new MyValue( true ),
     *      ),
     *      // ...
     * );
     * </code>
     *
     * @return array
     */
    public function provideFromHashData()
    {
        $timestamp = 123456;

        $dateTime = new DateTime();
        $dateTime->setTimestamp($timestamp)->setTime(0, 0, 0);

        return array(
            array(
                array(
                    'timestamp' => $timestamp,
                    'rfc850' => ($rfc850 = $dateTime->format(DateTime::RFC850)),
                ),
                DateValue::fromString($rfc850),
            ),
            array(
                array(
                    'timestamp' => $timestamp,
                    'rfc850' => null,
                ),
                DateValue::fromTimestamp($timestamp),
            ),
        );
    }

    public function providerForTestIsEmptyValue()
    {
        return array(
            array(new DateValue()),
        );
    }

    public function providerForTestIsNotEmptyValue()
    {
        return array(
            array(
                $this->getValidCreationFieldData(),
            ),
        );
    }

    protected function getValidSearchValueOne()
    {
        return 86400;
    }

    protected function getValidSearchValueTwo()
    {
        return 172800;
    }

    protected function getSearchTargetValueOne()
    {
        // Handling Legacy Search Engine, which stores Date value as timestamp
        if (ltrim(get_class($this->getSetupFactory()), '\\') === 'eZ\Publish\API\Repository\Tests\SetupFactory\Legacy') {
            return $this->getValidSearchValueOne();
        }

        return '1970-01-02T00:00:00Z';
    }

    protected function getSearchTargetValueTwo()
    {
        // Handling Legacy Search Engine, which stores Date value as timestamp
        if (ltrim(get_class($this->getSetupFactory()), '\\') === 'eZ\Publish\API\Repository\Tests\SetupFactory\Legacy') {
            return $this->getValidSearchValueTwo();
        }

        return '1970-01-03T00:00:00Z';
    }
}