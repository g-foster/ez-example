<?php
namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Login
{
    /**
     * @Assert\Length( min = 6, max = 20 )
     */
    public $username;
}
