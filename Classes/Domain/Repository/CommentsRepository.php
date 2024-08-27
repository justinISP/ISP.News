<?php
namespace ISP\News\Domain\Repository;

/*
 * This file is part of the ISP.News package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Persistence\Repository;

/**
 * @Flow\Scope("singleton")
 */
class CommentsRepository extends Repository
{

    /**
     * @param string $node
     * @param string $sorting
     * @return void
     */
    public function getComments($node, $sorting) {
        $comments = '\ISP\News\Domain\Model\Comments';
        $query = $this->persistenceManager->createQueryForType($comments);
        if($sorting=='asc') {
            $result = $query->matching($query->equals('node', $node))->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_ASCENDING))->execute();
        } else {
            $result = $query->matching($query->equals('node', $node))->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        }
        return $result;
    }

    /**
     * @param string $node
     * @param string $sorting
     * @return void
     */
    public function getVerifiedComments($node) {

  //->matching($query->equals('node', $node))   && $query->equals('node', $node)

      	$comments = '\ISP\News\Domain\Model\Comments';
        $deleted = "1";
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->matching($query->equals('node', $node))->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute();

        return $result;
    }

    /**
     * @return void
     */
    public function getAllComments() {
        $comments = '\ISP\News\Domain\Model\Comments';
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        return $result;
    }

    /**
     * @return void
     */
    public function getUnverifiedComments() {
        $comments = '\ISP\News\Domain\Model\Comments';
        $deleted = "0";
        $query = $this->persistenceManager->createQueryForType($comments);
        $result = $query->matching($query->equals('deleted', $deleted))->setOrderings(array('created' => \Neos\Flow\Persistence\QueryInterface::ORDER_DESCENDING))->execute();
        return $result;
    }
}
