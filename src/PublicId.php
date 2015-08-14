<?php
namespace Malahierba\PublicId;

use Hashids\Hashids;

trait PublicId {

    /**
     * Decode public id to real id
     *
     * @access      public
     *
     * @param       string      $public_id
     * @return      integer|null
     */
    static public function publicIdDecode($public_id)
    {
        $hashids = new Hashids(self::$public_id_salt, self::$public_id_min_length);

        $id = $hashids->decode($public_id);

        if (is_array($id) && isset($id[0]))
            return $id[0];

        return null;
    }

    /**
     * Accessor for get the public id from a real id as attribute.
     * Simply use: $model->public_id to get the public id value.
     *
     * @access      public
     *
     * @param       integer     $id
     * @return      string
     */
    public function getPublicIdAttribute()
    {
        $hashids = new Hashids(self::$public_id_salt, self::$public_id_min_length);

        $primaryKey = $this->primaryKey;

        return $hashids->encode($this->$primaryKey);
    }

    /**
     * Find a Model by its public ID
     *
     * @access      public
     *
     * @param       string
     * @return      model|null
     */
    static public function findByPublicId($public_id)
    {
        $id = self::publicIdDecode($public_id);

        return self::find($id);
    }

    /**
     * Return the max integer that is supported by PublicId in your environment
     *
     * @access      public
     *
     * @param       string
     * @return      model|null
     */
    static public function testPublicIdMaxInt()
    {
        $hashids = new Hashids(self::$public_id_salt, self::$public_id_min_length);

        return $hashids->get_max_int_value();
    }
}