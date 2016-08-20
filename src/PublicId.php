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
        $hashids = new Hashids(self::getSalt(), self::getMinLength(), self::getAlphabet());

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
        $hashids = new Hashids(self::getSalt(), self::getMinLength(), self::getAlphabet());

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
        $hashids = new Hashids(self::getSalt(), self::getMinLength(), self::getAlphabet());

        return $hashids->get_max_int_value();
    }

    /**
     * Get the alphabet property, if it's set by the user.
     *
     * @access private
     * @return string
     */
    static private function getAlphabet(){
        if(property_exists(self::class, 'public_id_alphabet')){
            switch(self::$public_id_alphabet){
                case 'upper_alphanumeric':
                    return "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                case 'upper_alpha':
                    return "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
                case 'lower_alphanumeric':
                    return "abcdefghijklmnopqrstuvwxyz0123456789";
                case 'lower_alpha':
                    return "abcdefghijklmnopqrstuvwxyz";
                default:
                    return self::$public_id_alphabet;
            }
        }

        return '';
    }

    /**
     * Get the salt property, if the user has set it.
     *
     * @access private
     * @return string
     */
    static private function getSalt(){
        if(property_exists(self::class, 'public_id_salt')){
            return self::$public_id_salt;
        }

        return '';
    }

    /**
     * Get the min length property, if the user has set it.
     *
     * @access private
     * @return integer
     */
    static private function getMinLength(){
        if(property_exists(self::class, 'public_id_min_length')){
            return self::$public_id_min_length;
        }

        return 0;
    }
}
