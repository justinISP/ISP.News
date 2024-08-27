<?php
namespace ISP\News\Controller;

use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Fusion\View\FusionView;
use Neos\Eel\FlowQuery\FlowQuery;

use Neos\Flow\Annotations as Flow;

class CalenderController extends ActionController
{

  public function createDownloadAction(){

  }

  public function getEventAction(string $title){

    $this->view->assign( 'title', $title);

  }

}
?>
