<?php
abstract class AbstractFile
{
    protected $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public abstract function action($actions);

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}

class File extends AbstractFile
{
    public function action($action)
    {
        $action->execute($this);
    }
}

class MyDirectory extends AbstractFile
{
    private $childs;

    public function addElement($child)
    {
        $this->childs[] = $child;
    }

    public function action($action)
    {
        foreach ($this->childs as $child) {
            $child->action($action);
        }
        $action->execute($this);
    }

    public function getElements()
    {
        return $this->childs;
    }
}

class FileActionAddPrefix
{
    public $prefix;

    public function __construct($prefix)
    {
        $this->prefix = $prefix;
    }

    public function execute($file)
    {
        if (get_class($file) === 'File') {
            $fileNameArray = explode('.', $file->getName());
            $size = count($fileNameArray);
            $fileExtension = $fileNameArray[$size - 1];
            $fileNameArray[$size - 1] = $this->prefix;
            $file->setName(implode('', $fileNameArray) . '.' . $fileExtension);
        }
    }
}

$directory = new MyDirectory('Pictures');
$directory->addElement(new File('img1.png'));
$directory->addElement(new File('img2.png'));
$directory->addElement(new File('img3.png'));

foreach ($directory->getElements() as $element) {
    echo $element->getName() . PHP_EOL;
}

echo PHP_EOL . 'Dodaj prefiks "_ko" do nazw plików:' . PHP_EOL;
$fileActionAddPrefix = new FileActionAddPrefix('_ok');
$directory->action($fileActionAddPrefix);

foreach ($directory->getElements() as $element) {
    echo $element->getName() . PHP_EOL;
}
