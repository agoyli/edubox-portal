<?php


namespace EduBoxBundle\DomainManager;


use Doctrine\ORM\EntityManagerInterface;
use EduBoxBundle\Entity\Book;
use Endroid\QrCode\QrCode;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Router;

class BookManager
{
    private $entityManager;
    private $kernel;
    private $router;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $kernel, Router $router)
    {
        $this->entityManager = $entityManager;
        $this->kernel = $kernel;
        $this->router = $router;
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