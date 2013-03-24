<?php
/**
 * File containing the eZ Tags field type
 */

namespace Masev\TagBundle\FieldType\Tag;

use eZ\Publish\Core\FieldType\FieldType;
use eZ\Publish\SPI\Persistence\Content\FieldValue;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;

class Type extends FieldType
{
    /**
     * Identifier for the field type this stuff is mocking
     *
     * @var string
     */
    protected $fieldTypeIdentifier = 'eztags';

    /**
     * Build a Value object of current FieldType
     *
     * Build a FiledType\Value object with the provided $value as value.
     *
     * @param array $value
     *
     * @throws \eZ\Publish\API\Repository\Exceptions\InvalidArgumentException
     *
     * @return \Masev\TagBundle\FieldType\Tag\Value
     */
    public function buildValue( $value )
    {
        return new Value( $value );
    }

    /**
     * Returns the field type identifier for this field type
     *
     * @return string
     */
    public function getFieldTypeIdentifier()
    {
        return $this->fieldTypeIdentifier;
    }

    /**
     * Returns the name of the given field value.
     *
     * It will be used to generate content name and url alias if current field is designated
     * to be used in the content name/urlAlias pattern.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public function getName( $value )
    {
        $value = $this->acceptValue( $value );

        return (string)$value->tags[0]->keyword;
    }

    /**
     * Returns the fallback default value of field type when no such default
     * value is provided in the field definition in content types.
     *
     * @return \Masev\TagBundle\FieldType\Tag\Value
     */
    public function getEmptyValue()
    {
        return new Value( null );
    }

    /**
     * Implements the core of {@see acceptValue()}.
     *
     * @param mixed $inputValue
     *
     * @return \Masev\TagBundle\FieldType\Tag\Value The potentially converted and structurally plausible value.
     */
    protected function internalAcceptValue( $inputValue )
    {
        return $inputValue;
    }

    /**
     * Returns information for FieldValue->$sortKey relevant to the field type.
     *
     * @param mixed $value
     * @return array
     */
    protected function getSortInfo( $value )
    {
        if ( isset( $value->value ) )
        {
            return $value->value;
        }

        return null;
    }

    /**
     * Converts an $hash to the Value defined by the field type
     *
     * @param mixed $hash
     *
     * @return Masev\TagBundle\FieldType\Tag\Value $value
     */
    public function fromHash( $hash )
    {
        if ( $hash === null )
        {
            return null;
        }
        return new Value( unserialize( $hash ) );
    }

    /**
     * Converts a $Value to a hash
     *
     * @param \Masev\TagBundle\FieldType\Tag\Value $value
     *
     * @return mixed
     */
    public function toHash( $value )
    {
        if ( $this->isEmptyValue( $value ) )
        {
            return null;
        }
        return serialize( $value->tags );
    }

    /**
     * Returns whether the field type is searchable
     *
     * @return boolean
     */
    public function isSearchable()
    {
        return true;
    }

    /**
     * Converts a persistence $fieldValue to a Value
     *
     * This method builds a field type value from the $data and $externalData properties.
     *
     * @param \eZ\Publish\SPI\Persistence\Content\FieldValue $fieldValue
     *
     * @return mixed
     */
    public function fromPersistenceValue( FieldValue $fieldValue )
    {
        if ( $fieldValue->externalData === null )
        {
            return null;
        }

        return new Value(
            $fieldValue->externalData
        );
    }
}
