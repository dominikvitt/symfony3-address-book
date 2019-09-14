<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AddressBook
 *
 * @ORM\Table(name="address_book")
 * @ORM\Entity
 */
class AddressBook
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=true)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="text", nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="text", nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="text", nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="house_number", type="text", nullable=false)
     */
    private $houseNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="zip", type="text", nullable=false)
     */
    private $zip;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="text", nullable=false)
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="text", nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="text", nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="birthday", type="text", nullable=false)
     */
    private $birthday;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="text", nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="text", nullable=true)
     */
    private $picture;


}

