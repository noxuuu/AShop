<?php
/**
 * Created by PhpStorm.
 * User: n.o.x
 * Date: 11/01/2019
 * Time: 17:42
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class Task
{
    protected $name;
    protected $settings;

    public function __construct()
    {
        $this->settings = new ArrayCollection();
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($description)
    {
        $this->name = $description;
    }

    public function getSettings()
    {
        return $this->settings;
    }
}