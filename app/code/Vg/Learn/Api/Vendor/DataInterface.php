<?php
namespace Vg\Learn\Api\Vendor;

interface DataInterface
{
    const ID           = 'vendor_id';
    const LOGO         = 'logo';
    const NAME         = 'name';
    const DESCRIPTION  = 'description';
    const CREATED_AT   = 'created_at';
    const UPDATED_AT   = 'updated_at';


    /**
     * @return int|null
     */
    public function getId();

    /**
     * @return string
     */
    public function getName();

    /**
     * @param $title
     * @return mixed
     */
    public function setName($title);

    /**
     * @return mixed
     */
    public function getDescription();

    /**
     * @param $description
     * @return mixed
     */
    public function setDescription($description);
    
    /**
     * @return mixed
     */
    public function getLogo();

    /**
     * @param $path
     * @return mixed
     */
    public function setLogo($path);

    /**
     * @return string
     */
    public function getCreatedAt();
    
}
