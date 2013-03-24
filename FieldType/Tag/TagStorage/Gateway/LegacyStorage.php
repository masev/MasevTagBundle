<?php

namespace Masev\TagBundle\FieldType\Tag\TagStorage\Gateway;

use Doctrine\Tests\Common\Annotations\Null;
use Masev\TagBundle\FieldType\Tag\TagStorage\Gateway;
use Masev\TagBundle\FieldType\Tag\Parts\Tag as Tag;
use eZ\Publish\SPI\Persistence\Content\VersionInfo;
use eZ\Publish\SPI\Persistence\Content\Field;

/**
 *
 */
class LegacyStorage extends Gateway
{
    /**
     * Connection
     *
     * @var mixed
     */
    protected $dbHandler;

    /**
     * Set database handler for this gateway
     *
     * @param mixed $dbHandler
     *
     * @return void
     * @throws \RuntimeException if $dbHandler is not an instance of
     *         {@link \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler}
     */
    public function setConnection( $dbHandler )
    {
        // This obviously violates the Liskov substitution Principle, but with
        // the given class design there is no sane other option. Actually the
        // dbHandler *should* be passed to the constructor, and there should
        // not be the need to post-inject it.
        if ( ! ( $dbHandler instanceof \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler ) )
        {
            throw new \RuntimeException( "Invalid dbHandler passed" );
        }

        $this->dbHandler = $dbHandler;
    }

    /**
     * Returns the active connection
     *
     * @throws \RuntimeException if no connection has been set, yet.
     *
     * @return \eZ\Publish\Core\Persistence\Legacy\EzcDbHandler
     */
    protected function getConnection()
    {
        if ( $this->dbHandler === null )
        {
            throw new \RuntimeException( "Missing database connection." );
        }
        return $this->dbHandler;
    }

    /**
     * @see \eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway
     */
    public function storeFieldData( VersionInfo $versionInfo, Field $field )
    {
        // @TODO : this version is read-only

        // Signals that the Value has been modified and that an update is to be performed
        return true;
    }

    /**
     * @see \eZ\Publish\Core\FieldType\Url\UrlStorage\Gateway
     */
    public function getFieldData( Field $field )
    {
        $field->value->externalData = $this->fetchByFieldId( $field->id, $field->versionNo );
    }

    /**
     * Fetch Tags by Field Id
     * @param int $id Field Id
     * @param int $version
     * @return array of Tag objects
     */
    public function fetchByFieldId( $id, $version = 1 )
    {
        $dbHandler = $this->getConnection();

        $rows = $dbHandler->query(
            "SELECT eztags.id, eztags.keyword, eztags.parent_id FROM eztags_attribute_link, eztags
                                    WHERE eztags_attribute_link.keyword_id = eztags.id AND
                                    eztags_attribute_link.objectattribute_id = " . $id . " AND
                                    eztags_attribute_link.objectattribute_version = " . $version
        );

        $results = array();
        foreach( $rows as $row )
        {
            $results[] = new Tag( $row['id'], $row['keyword'], $row['parent_id'] );
        }

        if ( count( $results ) )
        {
            return $results;
        }

        return null;
    }
}
