<?php
abstract class Parser
{
    public function __construct(){}

    public function parse($source)
    {
        $data = $this->loadData($source);
        return $this->parser($data);
    }

    abstract protected function loadData($source);
    abstract protected function parser($source);
}

class XmlFileParser extends Parser
{
    protected function loadData($source)
    {
        return file_get_contents(getcwd() . '/' . $source);
    }

    protected function parser($data)
    {
        return new SimpleXMLElement($data);
    }
}

class IniFileParser extends Parser
{
    protected function loadData($source)
    {
        return file_get_contents(getcwd() . '/' . $source);
    }

    protected function parser($data)
    {
        return parse_ini_string($data);
    }
}

$xmlParser = new XmlFileParser();
$iniParser = new IniFileParser();

var_dump($xmlParser->parse('template.xml'));
var_dump($iniParser->parse('template.ini'));
