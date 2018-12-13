<?php

namespace AppBundle\Service;


use AppBundle\Entity\Client;
use AppBundle\Entity\ClientCity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClientService
{
    const REQUEST_FIELDS = [
        'lastname',
        'name',
        'gender',
        'address',
        'birthdate',
        'city',
        'homePhone',
        'secondCity',
        'nationality',
        'mobilePhone',
        'pasport',
        'pasportNum',
        'passportID',
        'patronymic',
    ];

    const MANDATORY_FIELDS = [
        'lastname',
        'name',
        'gender',
        'address',
        'birthdate',
        'city',
        'pasport',
        'pasportNum',
        'patronymic',
        'secondCity',
        'nationality',
    ];

    const MODE_CREATE = 'create';
    const MODE_DELETE = 'delete';
    const MODE_UPDATE = 'update';

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var ValidatorInterface */
    private $validator;

    /** @var array */
    private $errors = [];

    /**
     * ClientService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ValidatorInterface $validator
     */
    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function create(array $params)
    {
        $validatorResponse = $this->validateRequest($params);
        if (!$validatorResponse['success']) {
            return ['message' => 'Request Failed', 'responseCode' => 400, 'errors' => $this->getErrors()];
        }

        $client = new Client();

        /** mandatory fields set-up */
        $city = $this->entityManager->getRepository(ClientCity::class)->find($params['city']);
        $secondCity = $this->entityManager->getRepository(ClientCity::class)->find($params['secondCity']);
        $birthDate = new \DateTime($params['birthdate']);

        $client
            ->setLastname($params['lastname'])
            ->setName($params['name'])
            ->setGender($params['gender'])
            ->setAddress($params['address'])
            ->setBirthDate($birthDate)
            ->setCity($city)
            ->setSecondCity($secondCity)
            ->setPasport($params['pasport'])
            ->setPasportNum($params['pasportNum'])
            ->setPatronymic($params['patronymic'])
            ->setNationality($params['nationality']);

        $errors = $this->validator->validate($client);

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $this->addError($error->getMessage());
            }
            return ['message' => 'Request failed', 'responseCode' => 400, 'errors' => $this->getErrors()];
        }

        /** Non-mandatory fields set-up */
        isset($params['homePhone']) ? $client->setHomePhone($params['homePhone']) : null;
        isset($params['mobilePhone']) ? $client->setMobilePhone($params['mobilePhone']) : null;
        isset($params['passportID']) ? $client->setPasportID($params['passportID']) : null;

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return ['message' => 'Successfully created', 'responseCode' => 200];
    }

    /**
     * @param int $clientId
     * @param array $params
     * @return array
     */
    public function update(int $clientId, array $params)
    {
        $client = $this->entityManager->getRepository(Client::class)->find($clientId);

        $validatorResponse = $this->validateRequest($params, self::MODE_UPDATE, $client);
        if (!$validatorResponse['success']) {
            return ['message' => 'Request Failed', 'responseCode' => $validatorResponse['responseCode'], 'errors' => $this->getErrors()];
        }

        isset($params['lastname']) ? $client->setLastname($params['lastname']) : null;
        isset($params['name']) ? $client->setName($params['name']) : null;
        isset($params['patronymic']) ? $client->setPatronymic($params['patronymic']) : null;
        isset($params['birthDate']) ? $client->setBirthDate($params['birthDate']) : null;
        isset($params['gender']) ? $client->setGender($params['gender']) : null;
        isset($params['pasport']) ? $client->setPasport($params['pasport']) : null;
        isset($params['pasportNum']) ? $client->setPasportNum($params['pasportNum']) : null;
        isset($params['pasportID']) ? $client->setPasportID($params['pasportID']) : null;
        isset($params['city']) ? $client->setCity($params['city']) : null;
        isset($params['address']) ? $client->setAddress($params['address']) : null;
        isset($params['homePhone']) ? $client->setHomePhone($params['homePhone']) : null;
        isset($params['mobilePhone']) ? $client->setMobilePhone($params['mobilePhone']) : null;
        isset($params['secondCity']) ? $client->setSecondCity($params['secondCity']) : null;
        isset($params['nationality']) ? $client->setNationality($params['nationality']) : null;

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return ['message' => 'Successfully updated', 'responseCode' => 200];
    }

    /**
     * @param int $clientId
     * @return array
     */
    public function remove(int $clientId)
    {
        $client = $this->entityManager->getRepository(Client::class)->find($clientId);

        $validatorResponse = $this->validateRequest([], self::MODE_DELETE, $client);
        if (!$validatorResponse['success']) {
            return ['message' => 'Request Failed', 'responseCode' => $validatorResponse['responseCode'], 'errors' => $this->getErrors()];
        }

        $this->entityManager->remove($client);
        $this->entityManager->flush();

        return ['message' => 'Successfully deleted', 'responseCode' => 200];
    }

    /**
     * @param array $params
     * @param string $mode
     * @param $client
     * @return array
     */
    private function validateRequest(array $params, string $mode = self::MODE_CREATE, $client = null)
    {
        if ($client === null && $mode !== self::MODE_CREATE) {
            $this->addError('Client not found!');
            return ['success' => false, 'message' => 'Request Failed', 'responseCode' => 404, 'errors' => $this->getErrors()];
        }

        if (empty($params) && $mode !== self::MODE_DELETE) {
            $this->addError('Request cannot be empty');
            return ['success' => false, 'responseCode' => 400, 'errors' => $this->getErrors()];
        }

        foreach ($params as $key => $value) {
            if (!in_array($key, self::REQUEST_FIELDS)) {
                $this->addError('Incorrect Params');
                return ['success' => false, 'responseCode' => 400, 'errors' => $this->getErrors()];
            }
        }

        if ($mode === self::MODE_CREATE) {
            foreach (self::MANDATORY_FIELDS as $mandatoryField) {
                if (!array_key_exists($mandatoryField, $params)) {
                    $this->addError('Some mandatory fields is missing');
                    return ['success' => false, 'responseCode' => 400, 'errors' => $this->getErrors()];
                }
            }
        }

        return ['success' => true];
    }

    /**
     * @param $error
     */
    public function addError($error)
    {
        $this->errors[] = $error;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}