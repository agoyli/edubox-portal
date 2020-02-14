<?php


namespace EduBoxBundle\Controller;


use Application\Sonata\MediaBundle\Entity\Media;
use EduBoxBundle\Entity\Author;
use EduBoxBundle\Entity\Book;
use Endroid\QrCode\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Router;

class BookController extends Controller
{
    /**
     *
     * @Route(path="/book/list", name="edubox_book_list")
     */
    public function listAction(Request $request)
    {
        $bookManager = $this->get('edubox_book_manager');
        return $this->render('@EduBox/Front/book/list.html.twig', [
            'books' => $bookManager->getBooksBy($request),
            'categories' =>  $bookManager->getCategories(),
            'tags' =>  $bookManager->getTags(),
            'authors' => $bookManager->getAuthors(),
        ]);
    }

    /**
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route(path="/book/{id}", name="edubox_book_show")
     */
    public function showAction(Book $book)
    {
        return $this->render('@EduBox/Front/book/show.html.twig', [
            'book' => $book,
            'bookManager' => $this->get('edubox_book_manager'),
        ]);
    }

    /**
     * @return Response
     * @Route(path="/qrcode/scanner", name="edubox_qrcode_scanner")
     */
    public function qrCodeAction()
    {
        return $this->render('@EduBox/Front/book/qrcode.html.twig');
    }

    /**
     * @param Book $book
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route(path="/book/{id}/download", name="edubox_book_download")
     */
    public function downloadAction(Book $book)
    {
        $strAuthors = '';
        $authors = $book->getAuthors();
        foreach ($authors as $key => $author) {
            if ($author instanceof Author) {
                $strAuthors .= $author->getFullName();
                $strAuthors .= ", ";
            }
        }
        if (count($authors) > 0) {
            $strAuthors = rtrim($strAuthors, ", ");
        }
        $bookName = strlen($book->getName().'-'.$strAuthors) > 220 ? $book->getName() : $book->getName().'-'.$strAuthors;
        if ($book->getBookFile() instanceof Media)
            return $this->get('sonata.media.provider.file')
                ->getDownloadResponse($book->getBookFile(), 'reference', 'http', [
                    'Content-Disposition' => sprintf('attachment; filename="%s"', $bookName.'.'.$book->getBookFile()->getExtension()),
                ]);
        else throw $this->createNotFoundException();
    }


    /**
     * @param Book $book
     * @return Response
     * @throws \Endroid\QrCode\Exception\InvalidWriterException
     * @Route(path="/book/{id}/qrcode", name="edubox_book_qrcode")
     */
    public function getQrCode(Book $book)
    {
        $qrCode = new QrCode();
        $qrCode->setText($this->generateUrl('edubox_book_show', ['id' => $book->getId()], Router::ABSOLUTE_URL));
        $response = new Response($qrCode->writeString());
        $response->headers->set('Content-Type', $qrCode->getContentType());
        return $response;
    }


    /**
     * @param Book $book
     * @Route(path="/book/{id}/read", name="edubox_dook_read")
     */
    public function readAction(Book $book)
    {

    }


}