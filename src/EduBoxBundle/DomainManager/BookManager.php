<?php


namespace EduBoxBundle\DomainManager;


use Doctrine\ORM\EntityManagerInterface;
use EduBoxBundle\Entity\Book;
use Endroid\QrCode\QrCode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Router;

class BookManager
{
    private $entityManager;
    private $kernel;
    private $router;

    /**
     * BookManager constructor.
     * @param EntityManagerInterface $entityManager
     * @param KernelInterface $kernel
     * @param Router $router
     */
    public function __construct(EntityManagerInterface $entityManager, KernelInterface $kernel, Router $router)
    {
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getBooksBy(Request $request)
    {

        $books = $this->entityManager->getRepository('EduBoxBundle:Book')->createQueryBuilder('b');

        $categoryId = (int)$request->get('category');
        $tagIds = is_array($request->get('tags')) ? $request->get('tags') : [];
        $authorId = (int)$request->get('author');
        $search = $request->get('search');

        if ($categoryId > 0) {
            $books->leftJoin('b.categories', 'c')
                ->where('c.id = :categoryId')->setParameter('categoryId', $categoryId);
        }

        if ($authorId > 0) {
            $books->leftJoin('b.authors', 'a')
                ->where('a.id = :authorId')->setParameter('authorId', $authorId);
        }

        if (count($tagIds) > 0) {
            $books->leftJoin('b.tags', 't')
                ->where($books->expr()->in('t.id', $tagIds));
        }

        if (strlen($search) > 0) {
            $books
                ->andWhere(
                    $books->expr()->orX(
                        $books->expr()->like('lower(b.name)', $books->expr()->literal('%'.strtolower($search).'%')),
                        $books->expr()->like('lower(b.description)', $books->expr()->literal('%'.strtolower($search).'%'))
                    )
                );
        }

        return $books->getQuery();
    }

    /**
     * @return array|\EduBoxBundle\Entity\Author[]
     */
    public function getAuthors()
    {
        return $this
            ->entityManager
            ->getRepository('EduBoxBundle:Author')
            ->findAll();
    }

    /**
     * @return array|\Application\Sonata\ClassificationBundle\Entity\Tag[]
     */
    public function getTags()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Tag')
            ->findBy(['context' => Book::$context]);
    }

    /**
     * @return array|\Application\Sonata\ClassificationBundle\Entity\Category[]
     */
    public function getCategories()
    {
        return $this
            ->entityManager
            ->getRepository('ApplicationSonataClassificationBundle:Category')
            ->findBy(['context' => Book::$context]);
    }

    public function getQRCode(Book $book)
    {
        $qrCodeImage = $this
                ->kernel
                ->getRootDir().'/../web/uploads/qrcode/book/book'.$book->getId().'.png';
        if (!file_exists($qrCodeImage)) {
            $qrCode = new QrCode();
            $qrCode->setText(
                $this
                    ->router
                    ->generate('edubox_book_show', ['id' => $book->getId()], Router::ABSOLUTE_URL));
            $qrCode->writeFile($qrCodeImage);
        }
        return explode('/web', $qrCodeImage)[1];
    }

}