<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Client
 *
 * @ORM\Table(name="client")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClientRepository")
 */
class Client
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=70)
     * @Assert\NotBlank()
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="patronymic", type="string", length=130)
     */
    private $patronymic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="birthDate", type="date")
     * @Assert\Date
     */
    private $birthDate;

    /**
     * @var bool
     *
     * @ORM\Column(name="gender", type="boolean")
     * @Assert\NotBlank()
     */
    private $gender;

    /**
     * @var string
     *
     * @ORM\Column(name="pasport", type="string", length=2)
     * @Assert\NotBlank()
     */
    private $pasport;

    /**
     * @var int
     *
     * @ORM\Column(name="pasportNum", type="integer")
     * @Assert\NotBlank()
     */
    private $pasportNum;

    /**
     * @var string
     *
     * @ORM\Column(name="pasportID", type="string", length=14, nullable=true)
     */
    private $pasportID;

    /**
     * @ORM\ManyToOne(targetEntity="ClientCity")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="homePhone", type="string", length=7, nullable=true)
     */
    private $homePhone;

    /**
     * @var string
     *
     * @ORM\Column(name="mobilePhone", type="string", length=12, nullable=true)
     */
    private $mobilePhone;

    /**
     * @ORM\ManyToOne(targetEntity="ClientCity")
     * @ORM\JoinColumn(name="second_city_id", referencedColumnName="id")
     * @Assert\Valid
     */
    private $secondCity;

    /**
     * @var string
     *
     * @ORM\Column(name="nationality", type="string", length=2)
     * @Assert\Length(
     *      min = 2,
     *      max = 2,
     *      minMessage = "Your nationality name must be at least {{ limit }} characters long",
     *      maxMessage = "Your nationality cannot be longer than {{ limit }} characters",
     *     exactMessage = "Your nationality should have exactly {{ limit }} characters "
     * )
     */
    private $nationality;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Client
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Client
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     *
     * @return Client
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * Get patronymic
     *
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     *
     * @return Client
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * Set gender
     *
     * @param boolean $gender
     *
     * @return Client
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return bool
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set pasport
     *
     * @param string $pasport
     *
     * @return Client
     */
    public function setPasport($pasport)
    {
        $this->pasport = $pasport;

        return $this;
    }

    /**
     * Get pasport
     *
     * @return string
     */
    public function getPasport()
    {
        return $this->pasport;
    }

    /**
     * Set pasportNum
     *
     * @param integer $pasportNum
     *
     * @return Client
     */
    public function setPasportNum($pasportNum)
    {
        $this->pasportNum = $pasportNum;

        return $this;
    }

    /**
     * Get pasportNum
     *
     * @return int
     */
    public function getPasportNum()
    {
        return $this->pasportNum;
    }

    /**
     * Set pasportID
     *
     * @param string $pasportID
     *
     * @return Client
     */
    public function setPasportID($pasportID)
    {
        $this->pasportID = $pasportID;

        return $this;
    }

    /**
     * Get pasportID
     *
     * @return string
     */
    public function getPasportID()
    {
        return $this->pasportID;
    }

    /**
     * Set сшcity
     *
     * @param $city
     * @return Client
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Client
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set homePhone
     *
     * @param string $homePhone
     *
     * @return Client
     */
    public function setHomePhone($homePhone)
    {
        $this->homePhone = $homePhone;

        return $this;
    }

    /**
     * Get homePhone
     *
     * @return string
     */
    public function getHomePhone()
    {
        return $this->homePhone;
    }

    /**
     * Set mobilePhone
     *
     * @param string $mobilePhone
     *
     * @return Client
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set secondCity
     *
     * @param string $secondCity
     *
     * @return Client
     */
    public function setSecondCity($secondCity)
    {
        $this->secondCity = $secondCity;

        return $this;
    }

    /**
     * Get secondCity
     *
     * @return string
     */
    public function getSecondCity()
    {
        return $this->secondCity;
    }

    /**
     * Set nationality
     *
     * @param string $nationality
     *
     * @return Client
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @Assert\Callback
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if (!$this->getCity() || !$this->getSecondCity()) {
            $context->addViolation(
                'City not found',
                []
            );
        }
    }
}

