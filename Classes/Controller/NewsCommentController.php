<?php
namespace ISP\News\Controller;

use Neos\Flow\Mvc\Controller\ActionController;
use Neos\Fusion\View\FusionView;
use ISP\News\Domain\Model\Comments;
use Neos\Eel\FlowQuery\FlowQuery;
use Neos\Flow\ResourceManagement\ResourceManager;

use Neos\Flow\Annotations as Flow;

class NewsCommentController extends ActionController
{

    /**
     *
     * require repository as protected variable
     *
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
  	* @Flow\Inject
  	* @var Neos\Flow\ResourceManagement\ResourceManager
  	*/
  	protected $resourceManager;

    /**
     *
     * assign the comments to refering document node
     *
     * @return void
     */
    public function indexAction() {

        $sorting = $this->request->getInternalArgument('__sorting');
        #$documentNode = $this->request->getInternalArgument('__documentNode');
        $node = $this->request->getInternalArgument('__documentnode');
        $comments = $this->newsRepository->getVerifiedComments($node);

        $this->view->assign('comments', $comments);

    }

    public function createCaptchaAction(){

            $ciphering = "AES-128-CTR";

            $options = 0;

            // Non-NULL Initialization Vector for decryption
            $decryption_iv = '1234567891011121';

            // Store the decryption key
            $decryption_key = "ABGnet";

            // Use openssl_decrypt() function to decrypt the data
            $decryption=openssl_decrypt ($this->request->getArgument('crypt'), $ciphering,
                    $decryption_key, $options, $decryption_iv);

            // Bildgröße festlegen
            $width = 100;
            $height = 33;

            // Neues Bild erstellen und Transparenz aktivieren
            $image = imagecreatetruecolor($width, $height);
            imagealphablending($image, true);
            imagesavealpha($image, true);

            // Hintergrundfarbe festlegen
            $bg_color = imagecolorallocatealpha($image, 255, 255, 255, 127);

            // Hintergrund mit der Hintergrundfarbe füllen
            imagefill($image, 0, 0, $bg_color);

            #$image = imagecreatefromjpeg("/var/www/abg-net2022.local/web/Packages/Sites/ISP.News/Resources/Public/Captcha/bg3.jpg");

            for ($i = 0; $i < 5; $i++) {
              // Buchstaben auswählen
              $char = $decryption[$i];

              // Schriftart festlegen
              $font = "/var/www/clients/client1/web3/web/Packages/Sites/ISP.ABG/Resources/Public/Fonts/webfonts/fa-brands-400.ttf";

              // Schriftgröße festlegen
              $size = 16;

              // Schriftfarbe festlegen
              $color = imagecolorallocate($image, 153, 153, 153);

              // Text auf das Bild schreiben
              imagettftext($image, $size, 0, 5 + $i * 14.5, 20, $color, $font, $char);
            }

            // Captcha-Bild an den Browser senden
            header("Content-Type: image/png");
            imagepng($image);
            #$this->view->assign('image', $image);
            // Ressourcen freigeben
            imagedestroy($image);

    }

    /**
     *
     * function to inizalize the comment form via plugin view // returning documentnode to form
     *
     * @return void
     */
    public function createAction(){

      session_start();

      // Captcha-Text erstellen
      $chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
      $text = "";

      for ($i = 0; $i < 5; $i++) {
        // Zufälligen Buchstaben auswählen
        $char = $chars[rand(0, strlen($chars) - 1)];
        $text .= $char;
      }

      // Captcha-Text in der Sitzung speichern
      $_SESSION["cap_text"] = $text;

      // Decrypt Captcha text

      // Store the cipher method
      $ciphering = "AES-128-CTR";

      // Use OpenSSl Encryption method
      $iv_length = openssl_cipher_iv_length($ciphering);
      $options = 0;

      // Non-NULL Initialization Vector for encryption
      $encryption_iv = '1234567891011121';

      // Store the encryption key
      $encryption_key = "ABGnet";

      // Use openssl_encrypt() function to encrypt the data
      $encryption = openssl_encrypt($text, $ciphering,
                  $encryption_key, $options, $encryption_iv);

      //

      $this->view->assign('capString', array('crypt' => $encryption));

      $documentnode = $this->request->getInternalArgument('__documentnode');

      $this->view->assign('documentNode', $documentnode);

    }

    /**
     *
     * create comment (values returned from comment form)
     *
     * @param \ISP\News\Domain\Model\Comments $newComment
     * @return void
     */
    public function createdAction(Comments $newComment, string $cap){

      session_start();

      // Captcha-Text aus der Sitzung abrufen
      $captcha_text = $_SESSION["cap_text"];

      $this->view->assign('cap', $captcha_text);
      $this->view->assign('capEntry', $cap);

      if(strtolower($cap) == strtolower($captcha_text)){

        $node = $newComment->getNode();
        #$node = "node-123";
        $newComment->setNode($node);
        $newComment->setDeleted(0);
        $name = $newComment->getName();
        $newComment->setName($name);
        $email = $newComment->getEmail();
        $newComment->setEmail($email);
        $comment = $newComment->getComment();
        $newComment->setComment($comment);
        $s = date('d/m/Y:H:i:s', time());
        $date = date_create_from_format('d/m/Y:H:i:s', $s);
        $date->getTimestamp();
        $newComment->setCreated($date);

        $this->newsRepository->add($newComment);
        $identifier = $this->persistenceManager->getIdentifierByObject($newComment);

        $this->redirect('index');

      }

    }
}
?>
