<?php

abstract class DocumentTemplate
{
    protected $data;
    
    public function setData($data)
    {
        $this->data = $data;
    }
    
    abstract public function generateTemplate();
}

class ProposalDocumentTemplate extends DocumentTemplate
{
    public function generateTemplate()
    {
        
    }
}

class StatementDocumentTemplate extends DocumentTemplate
{
    public function generateTemplate()
    {
        
    }
}

abstract class Document
{
    public function generateDocument()
    {
        $documentTemplate = $this->getDocumentTemplate();
        $documentTemplate->setData($this->data);
        
        return $documentTemplate;
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