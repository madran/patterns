<?php

class Character
{
    private $char;
    
    public function __construct(string $char)
    {
        $this->char = $char;
    }
    
    public function getChar() : string
    {
        return $this->char;
    }
}

class CharacterFactory
{
    private $characters = [];
    
    public function &getCharacter(string $char) : Character
    {
        foreach ($this->characters as $objChar) {
            if ($objChar->getChar() === $char) {
                return $objChar;
            }
        }
        
        $newChar = new Character($char);
        $this->characters[] = $newChar;
        return $newChar;
    }
}

abstract class MyDocument
{
    protected $characters = [];
    
    public function __toString()
    {
        $text = '';
                
        foreach ($this->characters as $char) {
            $text .= $char->getChar();
        }
        
        return $text;
    }
    
    public function countValues()
    {
        $newChars = array_map(function($obj) { return spl_object_hash($obj);}, $this->characters);
        
//        var_dump(array_count_values($newChars));
        
        return count(array_count_values($newChars));
    }
}

class DocumentWithFlyweight extends MyDocument
{   
    public function __construct(string $text)
    {
        $charFactory = new CharacterFactory();
        
        foreach ($this->stringIterate($text) as $char) {
            $this->characters[] = &$charFactory->getCharacter($char);
        }
    }
    
    private function stringIterate($str)
    {
        $length = mb_strlen($str);
        
        for ($i = 0; $i < $length; $i++) {
            yield mb_substr($str, $i, 1);
        }
    }
}

class DocumentWithoutFlyweight extends MyDocument
{   
    public function __construct(string $text)
    {
        foreach ($this->stringIterate($text) as $char) {
            $this->characters[] = new Character($char);
        }
    }
    
    private function stringIterate($str)
    {
        $length = mb_strlen($str);
        
        for ($i = 0; $i < $length; $i++) {
            yield mb_substr($str, $i, 1);
        }
    }
}

$documentWithFlyweight = new DocumentWithFlyweight('Ala ma kota a kot ma AIDS');
$documentWithoutFlyweight = new DocumentWithoutFlyweight('Ala ma kota a kot ma AIDS');

echo $documentWithFlyweight . PHP_EOL;
echo 'With flyweight object number: ' . $documentWithFlyweight->countValues() . PHP_EOL;
echo 'Without flyweight object number: ' . $documentWithoutFlyweight->countValues() . PHP_EOL;