<?php
/**
 * Manipulate eZ Tags object
 */
namespace Masev\TagBundle\FieldType\Tag\Parts;

class Tag
{
    protected $id;

    protected $keyword;

    protected $parentId;

    /**
     * Initialize object
     * @param $id
     * @param $keyword
     * @param $parentId
     */
    public function __construct( $id, $keyword, $parentId )
    {
        $this->id = $id;
        $this->keyword = $keyword;
        $this->parentId = $parentId;
    }

    /**
     * Return the keyword for string use
     * @return string
     */
    public function __toString()
    {
        return $this->keyword;
    }
}
