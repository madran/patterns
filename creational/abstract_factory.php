<?php
class Window
{
    private $width = 0;
    
    private $height = 0;
    
    /**
     *
     * @var Border
     */
    private $border = null;
    
    private $fileNames = [];
    
    private $components = [];
    
    public function __construct(int $width, int $height, Border $border)
    {
        $this->width = $width;
        $this->height = $height;
        $this->border = $border;
    }
    
    public function setFileNames(array $fileNames) :void
    {
        $this->fileNames = $fileNames;
    }
    
    public function addComponent(Component $component, array $options) :void
    {
        $this->components[] = [$component, $options];
    }
    
    public function render() :string
    {
        $window[] = $this->border->getTopLeftCorner()
                  . str_repeat($this->border->getHorizontalBorder(), $this->width - 2)
                  . $this->border->getTopRightCorner()
                  . PHP_EOL;
        
        for ($y = 2, $i = 0; $y < $this->height; $y++, $i++) {
            $window[] = $this->border->getVerticalBorder()
                        . ' '
                        . (isset($this->fileNames[$i]) ? $this->fileNames[$i] : '')
                        . str_repeat(' ', $this->width - 2 - mb_strlen(isset($this->fileNames[$i]) ? $this->fileNames[$i] : '') - 1)
                      . $this->border->getVerticalBorder()
                      . PHP_EOL;
        }
        
        $window[] = $this->border->getBottomLeftCorenr()
                  . str_repeat($this->border->getHorizontalBorder(), $this->width - 2)
                  . $this->border->getBottomRightCorner()
                  . PHP_EOL;
        
        $window = $this->renderComponents($window);
        
        return implode('', $window);
    }
    
    private function renderComponents(array $window) :array
    {
        foreach ($this->components as list($component, $options)) {
            $row = $column = 0;
            
            if ($options['position']['vertical'] === 'top') {
                $row = 0;
            } else {
                $row = $this->height - 1;
            }
            
            if ($options['position']['horizontal'] === 'left') {
                $column = 2;
            } else {
                $column = $this->width - $component->getLenght() - 2;
            }
            
            $window[$row] = mb_substr_replace($window[$row], $component->getView(), $column, $component->getLenght());
        }
        
        return $window;
    }
}

abstract class Border
{
    public $horizontalBorder = '';
    public $verticalBorder = '';
    public $topLeftCorner = '';
    public $topRightCorner = '';
    public $bottomLeftCorenr = '';
    public $bottomRightCorner = '';
    
    function getHorizontalBorder() :string
    {
        return $this->horizontalBorder;
    }

    function getVerticalBorder() :string
    {
        return $this->verticalBorder;
    }

    function getTopLeftCorner() :string
    {
        return $this->topLeftCorner;
    }

    function getTopRightCorner() :string
    {
        return $this->topRightCorner;
    }

    function getBottomLeftCorenr() :string
    {
        return $this->bottomLeftCorenr;
    }

    function getBottomRightCorner() :string
    {
        return $this->bottomRightCorner;
    }
}

class DoubleLineBorder extends Border
{
    public function __construct()
    {
        $this->horizontalBorder = '═';
        $this->verticalBorder = '║';
        $this->topLeftCorner = '╔';
        $this->topRightCorner = '╗';
        $this->bottomLeftCorenr = '╚';
        $this->bottomRightCorner = '╝';
    }
}

class SingleLineBorder extends Border
{
    public function __construct()
    {
        $this->horizontalBorder = '─';
        $this->verticalBorder = '│';
        $this->topLeftCorner = '┌';
        $this->topRightCorner = '┐';
        $this->bottomLeftCorenr = '└';
        $this->bottomRightCorner = '┘';
    }
}

abstract class Component
{
    protected $view = null;
    protected $lenght = null;
    
    protected abstract function render() :string;
    
    public function getView(bool $rerender = false) :string
    {
        if ($rerender === false || $this->view === null) {
            $this->view = $this->render(); 
            $this->lenght = strlen($this->view);
        }
        
        return $this->view;
    }
    
    public function getLenght() :int
    {
        if ($this->view === null) {
            $this->view = $this->render(); 
            $this->lenght = mb_strlen($this->view);
        }
        
        return $this->lenght;
    }
}

class DriverLetterComponent extends Component
{
    private $letters = [];
    
    function __construct(array $letters) {
        $this->letters = $letters;
    }

    protected function render(): string {
        $component = '';
        foreach ($this->letters as $letter) {
            $component .= ' '. $letter;
        }
        
        return '[' . $component . ' ]';
    }
    
    public function getLenght() :int {
        return parent::getLenght();
    }
}

class CurrentPathComponent extends Component
{
    private $path = '';
    
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    protected function render() :string
    {
        return '[ ' . $this->path . ' ]';
    }
}

class DateComponent extends Component
{
    /**
     *
     * @var DateTime
     */
    private $date = null;
    
    public function __construct()
    {
        $this->date = new DateTime();
    }
    
    protected function render() :string
    {
        return '[ ' . $this->date->format('d-m-Y') . ' ]';
    }
}

interface WindowFactory
{
    public function createWindow() :Window;
}

class VerboseWindowFactory implements WindowFactory
{
    public function createWindow(): Window {
        $border = new DoubleLineBorder();
        $driverComponent = new DriverLetterComponent(['A', 'C', 'D']);
        $dateComponent = new DateComponent();
        $currentPathComponent = new CurrentPathComponent("C:/Windows/system");
        $window = new Window(50, 10, $border);
        
        $window->addComponent($driverComponent, ['position' => [
            'horizontal' => 'left',
            'vertical' => 'bottom'
        ]]);
        $window->addComponent($dateComponent, ['position' => [
            'horizontal' => 'right',
            'vertical' => 'bottom'
        ]]);
        $window->addComponent($currentPathComponent, ['position' => [
            'horizontal' => 'left',
            'vertical' => 'top'
        ]]);

        return $window;
    }
}

class SimpleWindowFactory implements WindowFactory
{
    public function createWindow() :Window {
        $border = new SingleLineBorder();
        $window = new Window(50, 10, $border);
        return $window;
    }
}

$windowFactory = new VerboseWindowFactory();
$verboseWindow = $windowFactory->createWindow();
$verboseWindow->setFileNames(['folder1', 'folder2', 'folder folder3']);
echo $verboseWindow->render();

echo PHP_EOL . PHP_EOL . PHP_EOL;

$windowFactory = new SimpleWindowFactory();
$simpleWindow = $windowFactory->createWindow();
$simpleWindow->setFileNames(['folder1', 'folder2', 'folder folder3']);
echo $simpleWindow->render();

function mb_substr_replace($string, $replacement, $start, $length = null, $encoding = null) {

    $string_length = (is_null($encoding) === true) ? mb_strlen($string) : mb_strlen($string, $encoding);

    if ($start < 0) {
        $start = max(0, $string_length + $start);
    } else if ($start > $string_length) {
        $start = $string_length;
    }

    if ($length < 0) {
        $length = max(0, $string_length - $start + $length);
    } else if ((is_null($length) === true) || ($length > $string_length)) {
        $length = $string_length;
    }

    if (($start + $length) > $string_length) {
        $length = $string_length - $start;
    }

    if (is_null($encoding) === true) {
        return mb_substr($string, 0, $start) . $replacement . mb_substr($string, $start + $length, $string_length - $start - $length);
    }

    return mb_substr($string, 0, $start, $encoding) . $replacement . mb_substr($string, $start + $length, $string_length - $start - $length, $encoding);
}