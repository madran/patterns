<?php

abstract class DocumentTemplate
{
    protected $documentView;
    
    public function getDocumentView()
    {
        return $this->documentView;
    }
    
    abstract public function fillTemplate($data);
}

class ProposalDocumentTemplate extends DocumentTemplate
{
    public function fillTemplate($data)
    {
        $user = $data['user'];
        
        $this->documentView = 
            $user->getFirstName() . ' ' . $user->getLastName() . PHP_EOL
          . $user->getAddress()->getStreetName() . ' ' . $user->getAddress()->getHouseNumber() . ' ' . $user->getAddress()->getFlatNumber() . PHP_EOL
          . $user->getAddress()->getCity() . PHP_EOL
          . PHP_EOL
          . PHP_EOL
          . 'Wniosek'
          . PHP_EOL
          . 'Bla bla bla że wniosek.'
          . PHP_EOL;
    }
}

class StatementDocumentTemplate extends DocumentTemplate
{
    public function fillTemplate($data)
    {
        
    }
}

abstract class Document
{
    protected $documentTemplate;
    
    public function generateDocument($data)
    {
        $this->documentTemplate = $this->getDocumentTemplate();
        
        $this->documentTemplate->fillTemplate($data);
        
        return $this;
    }
    
    public function __toString()
    {
        return $this->documentTemplate->getDocumentView();
    }
    
    abstract protected function getDocumentTemplate();
}

class ProposalDocument extends Document
{
    protected function getDocumentTemplate() {
        return new ProposalDocumentTemplate();
    }
}

class StatementDocument extends Document
{
    protected function getDocumentTemplate() {
        return new StatementDocumentTemplate();
    }
}

class DocumentCreator
{
    public function createDocument($type, $data)
    {
        switch ($type) {
            case 'proposal':
                $proposalDocument = new ProposalDocument();
                return $proposalDocument->generateDocument($data);
                break;
            case 'statament':
                $statementDocument = new StatementDocument();
                return $statementDocument->generateDocument($data);
                break;
            default:
                throw new Exception('Bad document type!');
                break;
        }
    }
}

$address = new Address();
$address->setCity('Warszawa');
$address->setStreetName('Mickiewicza');
$address->setHouseNumber('21');
$address->setFlatNumber('44');

$user = new User();
$user->setFirstName('Stefan');
$user->setLastName('Kamyczek');
$user->setAddress($address);

$data = ['user' => $user];

$documentCreator = new DocumentCreator();
$proposalDocument = $documentCreator->createDocument('proposal', $data);

echo $proposalDocument;

class Address
{
    private $city;
    private $streetName;
    private $houseNumber;
    private $flatNumber;
    
    function getCity()
    {
        return $this->city;
    }

    function getStreetName()
    {
        return $this->streetName;
    }

    function getHouseNumber()
    {
        return $this->houseNumber;
    }

    function getFlatNumber()
    {
        return $this->flatNumber;
    }

    function setCity($city)
    {
        $this->city = $city;
    }

    function setStreetName($streetName)
    {
        $this->streetName = $streetName;
    }

    function setHouseNumber($houseNumber)
    {
        $this->houseNumber = $houseNumber;
    }

    function setFlatNumber($flatNumber)
    {
        $this->flatNumber = $flatNumber;
    }
}

class User
{
    private $firstName;
    private $lastName;
    private $address;
    private $homeNumber;
    
    function getFirstName()
    {
        return $this->firstName;
    }

    function getLastName()
    {
        return $this->lastName;
    }

    function getAddress()
    {
        return $this->address;
    }

    function getHomeNumber()
    {
        return $this->homeNumber;
    }

    function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    function setAddress($address)
    {
        $this->address = $address;
    }

    function setHomeNumber($homeNumber)
    {
        $this->homeNumber = $homeNumber;
    }
}