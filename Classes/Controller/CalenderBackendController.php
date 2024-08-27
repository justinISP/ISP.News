<?php
namespace ISP\News\Controller;

use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Fusion\View\FusionView;
use ISP\News\Domain\Model\Comments;
use Neos\Eel\FlowQuery\FlowQuery;

use Neos\Flow\Annotations as Flow;

class CalenderBackendController extends \Neos\Flow\Mvc\Controller\ActionController {

  /**
   * @Flow\Inject
   * @var \ISP\News\Domain\Repository\CommentsRepository
   */
  protected $newsRepository;

  /**
   * @return void
   */
  public function calIndexAction(){

    $this->view->assign('comments', $this->newsRepository->getUnverifiedComments());

  }


  /**
   * @param \ISP\News\Domain\Model\Comments $comment
   * @return void
   */
  public function verifyAction(Comments $comment){

    $comment->setDeleted("1");
    $this->newsRepository->update($comment);
    $this->persistenceManager->persistAll();
    $this->redirect('index');

  }

  /**
   * @param \ISP\News\Domain\Model\Comments $comment
   * @return void
   */
  public function updateAction(Comments $comment, string $updateField){

    $comment->setComment($updateField);
    $this->newsRepository->update($comment);
    $this->persistenceManager->persistAll();
    $this->redirect('index');

  }

  /**
   * @param \ISP\News\Domain\Model\Comments $comment
   * @return void
   */
  public function deleteAction(Comments $comment){

    $this->newsRepository->remove($comment);
    $this->redirect('index');

  }

}
