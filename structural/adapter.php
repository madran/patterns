<?php

interface Authentication
{
    public function authenticate(string $userLogin, string $password) : bool;
    public function isAuthenticated() : bool;
}
 
class UserAuthentication implements Authentication
{
    private $isAuthenticated = false;
    
    public function authenticate(string $userLogin, string $password) : bool
    {
        echo 'Standard authenticate user: ' . $userLogin;
        
        $this->isAuthenticated = true;
        return true;
    }
    
    public function isAuthenticated() : bool
    {
        return $this->isAuthenticated;
    }
}

class GoogleUserAuthentication
{
    private $login;
    private $password;
    
    public function setLogin(string $login)
    {
        $this->login = $login;
    }
    
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    
    public function authenticateUser() : bool
    {
        echo 'Google authenticate user: ' . $this->login;
        return true;
    }
}

class GoogleUserAuthenticationAdapter implements Authentication
{
    private $userAuth;
    private $isAuthenticated = false;
    
    public function __construct()
    {
        $this->userAuth = new GoogleUserAuthentication();
    }
    
    public function authenticate(string $userLogin, string $password) : bool
    {
        $this->userAuth->setLogin($userLogin);
        $this->userAuth->setPassword($password);
        $this->isAuthenticated = $this->userAuth->authenticateUser();
        return $this->isAuthenticated;
    }
    
    public function isAuthenticated() : bool
    {
        return $this->isAuthenticated;
    }
}

class FileManager
{
    private $authenticationManager = null;
    
    public function setAuthenticationManager($authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    public function getRecentFiles()
    {
        if ($this->authenticationManager->isAuthenticated()) {
            echo 'Files files files.' . PHP_EOL;
        }
    }
}

$userAuthentication = new UserAuthentication();
$userAuthentication->authenticate('kamilka', 'pass');

echo PHP_EOL;
echo PHP_EOL;

$googleUserAuthentication = new GoogleUserAuthenticationAdapter();
$googleUserAuthentication->authenticate('lukasz', 'pass');

echo PHP_EOL;
echo PHP_EOL;

echo PHP_EOL;
echo 'Recent files with user auhentication:' . PHP_EOL;
$fileManager = new FileManager();
$fileManager->setAuthenticationManager($userAuthentication);
$fileManager->getRecentFiles();

echo PHP_EOL;
echo 'Recent files with google user auhentication:' . PHP_EOL;
$fileManager->setAuthenticationManager($googleUserAuthentication);
$fileManager->getRecentFiles();

