<?php

class MyFile
{
    protected $name;
    protected $size;
    protected $path;
    
    private $content;
    
    public function __construct(string $path)
    {
        $this->path = $path;
        
        preg_match('/\w+(?:\.\w+)*$/', $path, $matches, PREG_OFFSET_CAPTURE);
        $this->name = $matches[0][0];
        
        $this->loadContent($path);
    }
    
    protected function loadContent(string $path)
    {
        echo "Loading file..." . PHP_EOL;
    }
    
    public function delete() {}
    
    public function move(string $newPath) {}
    
    public function copy(string $newPath) {}
    
    public function show()
    {
        echo 'View file: ' . $this->name . PHP_EOL;
    }
}

class MyDirectory extends MyFile
{
    private $files = [];
    
    public function __construct($path)
    {
        parent::__construct($path);
    }
    
    public function loadContent(string $path)
    {
        echo 'Load directory and file data' . PHP_EOL;
        
        $this->files[] = new MyFile('C:\Windows\file1.txt');
        $this->files[] = new MyFile('C:\Windows\file2.txt');
        $this->files[] = new MyFile('C:\Windows\file3.txt');
    }
    
    public function show()
    {
        foreach ($this->files as $file)
        {
            if (is_a($file, MyDirectory::class)) {
                echo $file->show();
            } else {
                echo $file->show();
            }
        }
    }
}

class RemoteFileManager
{
    public function showFolder(string $path)
    {
        $directory = new MyDirectory($path);
        $directory->show();
    }
}

$fileManager = new RemoteFileManager();
$fileManager->showFolder('C:\Windows');

class MyFileProxy extends MyFile
{
    private $file;
    
    public function __construct(string $path)
    {
        $this->path = $path;
    }
    
    public function show()
    {
        $this->file = new MyFile($this->path);
        $this->file->show();
    }
}

class MyDirectoryUsingProxy extends MyFile
{
    private $files = [];
    
    public function __construct($path)
    {
        parent::__construct($path);
    }
    
    public function loadContent(string $path)
    {
        echo 'Load directory and file data' . PHP_EOL;
        
        $this->files[] = new MyFileProxy('C:\Windows\file1.txt');
        $this->files[] = new MyFileProxy('C:\Windows\file2.txt');
        $this->files[] = new MyFileProxy('C:\Windows\file3.txt');
    }
    
    public function show()
    {
        foreach ($this->files as $file)
        {
            if (is_a($file, MyDirectory::class)) {
                echo $file->show();
            } else {
                echo $file->show();
            }
        }
    }
}

class RemoteFileManagerUsingProxy
{
    public function showFolder(string $path)
    {
        $directory = new MyDirectoryUsingProxy($path);
        $directory->show();
    }
}

echo PHP_EOL . PHP_EOL;

$fileManager = new RemoteFileManagerUsingProxy();
$fileManager->showFolder('C:\Windows');