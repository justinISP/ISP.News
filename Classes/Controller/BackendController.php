<?php
namespace ISP\News\Controller;

use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Fusion\View\FusionView;
use ISP\News\Domain\Model\Comments;
use Neos\Eel\FlowQuery\FlowQuery;

use Neos\Flow\Annotations as Flow;

class BackendController extends \Neos\Flow\Mvc\Controller\ActionController {

  /**
   * @Flow\Inject
   * @var \ISP\News\Domain\Repository\CommentsRepository
   */
  protected $newsRepository;

  /**
	* @Flow\Inject
	* @var Neos\ContentRepository\Domain\Service\ContextFactoryInterface
	*/
	protected $contextFactory;

  /**
   * @return void
   */
  public function indexAction(){

  }

  public function showNewAction(){

    $comments = $this->newsRepository->getUnverifiedComments();
    $context = $this->contextFactory->create();
    $q = new FlowQuery([$context->getCurrentSiteNode()]);
    $docQuery = $q->find('[instanceof ISP.News:NewsPage]');
    for($i = 0; $i <= (count($comments) - 1); $i++){
      $commentNode[$i] = $comments[$i]->getNode();
      $commentDoc[$i] = $q->find('[instanceof ISP.News:NewsPage]')->filter('[_name = "' . $commentNode[$i] . '"]')->get();
    if($commentDoc[$i] != null){
      $commentsArray[$i] = [
          "objComment" => $comments[$i],
          "name" => $comments[$i]->getName(),
          "email" => $comments[$i]->getEmail(),
          "comment" => $comments[$i]->getComment(),
          "docNode" => $commentDoc[$i],
      ];
    } else {
      $commentsArray[$i] = [
          "objComment" => $comments[$i],
          "name" => $comments[$i]->getName(),
          "email" => $comments[$i]->getEmail(),
          "comment" => $comments[$i]->getComment(),
      ];
    }
  }

  $this->view->assign('comments', $commentsArray);

  }

  public function showOldAction(){

    $commentsVerified = $this->newsRepository->getAllComments();
    for($i = 0; $i <= (count($commentsVerified) - 1); $i++){
      $commentVnode[$i] = $commentsVerified[$i]->getNode();
      $commentVdoc[$i] = $q->find('[instanceof ISP.News:NewsPage]')->filter('[_name = "' . $commentVnode[$i] . '"]')->get();
    if($commentVdoc[$i] != null){
      $commentsVarray[$i] = [
          "name" => $commentsVerified[$i]->getName(),
          "email" => $commentsVerified[$i]->getEmail(),
          "comment" => $commentsVerified[$i]->getComment(),
          "deleted" => $commentsVerified[$i]->getDeleted(),
          "docNode" => $commentVdoc[$i],
      ];
    } else {
      $commentsVarray[$i] = [
          "name" => $commentsVerified[$i]->getName(),
          "email" => $commentsVerified[$i]->getEmail(),
          "comment" => $commentsVerified[$i]->getComment(),
          "deleted" => $commentsVerified[$i]->getDeleted(),
      ];
    }
  }

  $this->view->assign('commentsVerified', $commentsVarray);

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

  protected function initializeUpdateAction() {
    $commentConfiguration = $this->arguments['comment']->getPropertyMappingConfiguration();
    $commentConfiguration->allowAllProperties();
    $commentConfiguration
      ->setTypeConverterOption(
      \Neos\Flow\Property\TypeConverter\PersistentObjectConverter::class,
      \Neos\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
      true
    );
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
