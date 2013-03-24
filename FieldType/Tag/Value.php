<?php
/**
 * File containing the eZ Tags Value class
 */

namespace Masev\TagBundle\FieldType\Tag;

use eZ\Publish\Core\FieldType\Value as BaseValue;
use Masev\TagBundle\FieldType\Tag\Parts\Tag as Tag;

/**
 * Value for eZ Tags field type
 */
class Value extends BaseValue
{
    public $tags;

    /**
     * Construct a new Value object
     *
     * @param array $tags array of Tag objects
     * @internal param int $value
     */
    public function __construct( Array $tags )
    {
        $this->tags = $tags;
    }

    /**
     * @see \Masev\TagBundle\FieldType\Tag
     */
    public function __toString()
    {
        return '';
    }
}
