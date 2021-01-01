<?php
declare(strict_types=1);

namespace App\Controller;

require_once 'AbstractController.php';

use App\Exception\NotFoundException;

class NoteController extends AbstractController
{

    public function createAction():void
    {
        if ($this->request->hasPost()) {
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->createNote($noteData);
            $this->redirect('/Notes/',['before' => 'created']);
        }
        $this->view->render('create');
    }
    public function showAction()
    {
        $this->view->render(
            'show',
            ['note' => $this->getNote()]
        );
    }
    public function listAction():void
    {
        $phrase = $this->request->getParam('phrase');
        $pageSize = (int)$this->request->getParam('pagesize',5);
        $pageNumber = (int)$this->request->getParam('page',1);
        $sortBy = $this->request->getParam('sortby', 'title');
        $sortOrder = $this->request->getParam('sortorder','desc');

        if(!in_array($pageSize, [1, 5, 10, 15, 20, 25]))
        {
          $pageSize = 1;
        }

        if($phrase)
        {
            $note = $this->database->searchNotes($phrase, $pageNumber, $pageSize, $sortBy, $sortOrder);
            $notes = $this->database->getsearchCount($phrase );
        }else{
            $note = $this->database->getNotes($pageNumber, $pageSize, $sortBy, $sortOrder);
            $notes = $this->database->getCount();
        }

        $this->view->render(
            'list',
            [
                'page' => ['number'=>$pageNumber, 'size'=>$pageSize,'pages' => (int) ceil($notes/$pageSize) ],
                'phrase' => $phrase,
                'sort' => ['by' => $sortBy, 'order' => $sortOrder],
                'notes' => $note,
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ]
        );
    }
    public function editAction():void
    {
        if($this->request->isPost())
        {
           $noteId = (int)$this->request->postParam('id');
            $noteData = [
                'title' => $this->request->postParam('title'),
                'description' => $this->request->postParam('description')
            ];
            $this->database->editNote($noteId, $noteData);
            $this->redirect('/notes/', ['before' => 'edited']);
        }

        $this->view->render(
            'edit',
            ['note' => $this->getNote()]
        );
    }
    public function deleteAction(): void
    {
        if($this->request->isPost()) {
            $id = (int)$this->request->postParam('id');
            $this->database->deleteNote($id);
            $this->redirect('/Notes/',['before' => 'deleted']);
        }
        $this->view->render(
            'delete',
            ['note' => $this->getNote()]
        );
    }
    private function getNote():array
    {
        $noteId = (int) $this->request->getParam('id');
        if(!$noteId)
        {
            $this->redirect('/Notes/',['error' => 'missingNoteId']);
        }
        try {
            $note = $this->database->getNote($noteId);
        }catch (NotFoundException $e){
            $this->redirect('/Notes/',['error' => 'noteNotFound']);
        }
        return $note;
    }

}